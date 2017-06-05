<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BookingPayment extends Model
{
    /**
     * @var string
     */
    protected $table = 'booking_payment';

    /**
     * @var array
     */
    protected $fillable = [
        'booking_id', 'payment_method', 'type', 'total_payment', 'card_type', 'card_number', 'cc_type_id', 'bank', 'settlement_id', 'card_name',
        'card_expiry_month', 'card_expiry_year', 'bank_transfer_recipient', 'created_by', 'guest_id', 'flow_type', 'checkout', 'deposit'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'booking_payment_id';

    /**
     * @param $type
     * @param null $extrachargeId
     * @param int $deposit
     * @return string
     */
    public static function setDescription($type, $extrachargeId = null, $deposit = 0) {
        if($deposit == 1){
            return "Check In Deposit";
        }
        $name = '';
        if($extrachargeId != null){
            $extrachargeName = Extracharge::find($extrachargeId);
            $name = $extrachargeName->extracharge_name;
        }
        switch($type) {
            case 1 :
                return 'Down Payment';
                break;
            case 2 :
                return 'Settlement';
                break;
            case 3 :
                return 'Extra Charge - '.$name;
                break;
            case 4:
                return 'Final Payment';
                break;
            case 5:
                return 'Deposit Not Refunded';
                break;
        }
    }

    /**
     * @param $paymentMethod
     * @param $cardName
     * @param $cardType
     * @param $cardNumber
     * @param $bankRecipient
     * @return string
     */
    public static function setPaymentMethodDescription($paymentMethod, $cardName, $cardType, $cardNumber, $bankRecipient){
        if($paymentMethod == 1){
            return 'Cash to Front Office';
        } elseif($paymentMethod == 2){
            return 'Cash to Back Office';
        } elseif($paymentMethod == 3){
            $card = ($cardType == 1) ? 'Credit Card' : 'Debit Card';
            return $card . '<br />' . substr($cardNumber, 0, -3) . 'XXX'. '<br /> Holder :'. $cardName;
        } else {
            $bank = CashAccount::find($bankRecipient);
            return 'Bank Transfer to '.$bank->cash_account_name. '<br />' . $bank->cash_account_desc;
        }
    }

    /**
     * @param $input
     * @param $header
     * @return int
     */
    public static function processPayment($input, $header) {
        if($input['type'] == 1){ // INSERT DOWN PAYMENT IF GUARANTEED
            $payment = parent::where('booking_id', $header->booking_id) // CHECK IF DOWNPAYMENT EXIST
            ->where('type', 1)
                ->first();
            $paymentData = [
                'booking_id'        => $header->booking_id,
                'guest_id'          => $header->guest_id,
                'payment_method'    => isset($input['payment_method']) ? $input['payment_method'] : 1,
                'type'              => 1, // down payment
                'total_payment'     => isset($input['down_payment_amount']) ? $input['down_payment_amount'] : 0,
                'card_type'         => isset($input['card_type']) ? $input['card_type'] : null,
                'card_number'       => $input['card_number'],
                'card_name'         => $input['card_holder'],
                'cc_type_id'        => $input['cc_type'],
                'bank'              => $input['bank'],
                'settlement_id'     => $input['settlement'],
                'card_expiry_month' => $input['month'],
                'card_expiry_year' => $input['year'],
                'bank_transfer_recipient' => $input['cash_account_id'],
                'created_by'        => Auth::id()
            ];

            if(count($payment) == 0){
                parent::create($paymentData);
            } else {
                parent::find($payment->booking_payment_id)->update($paymentData);
            }

            // INSERT TO ACCOUNT RECEIVABLE
            $insertAccReceivable = [
                'booking_id'    => $header->booking_id,
                'date'    => date('Y-m-d'),
                'amount'    => $paymentData['total_payment'],
                'desc'      => 'Down Payment Booking '.$header->booking_code,
                'partner_id' => $header->partner_id,
                'paid'      => 0,
                'created_by' => Auth::id()
            ];

            AccountReceivable::insert($insertAccReceivable);

            // INSERT TO CASH TRANSACTION
            $insertCashTransaction = [
                'booking_id'    => $header->booking_id,
                'amount'            => $paymentData['total_payment'],
                'desc'              => 'Down Payment Booking '.$header->booking_code,
                'cash_account_id'   => $input['cash_account_id'],
                'payment_method'    => $paymentData['payment_method'],
                'type'              => 2
            ];

            CashTransaction::insert($insertCashTransaction);

        } else { // DELETE ALL DOWNPAYMENT IF TENTATIVE
            $payment = parent::where('booking_id', $header->booking_id)
                ->where('type', 1)->delete();

            AccountReceivable::where('booking_id', $header->booking_id)->delete();
        }
        return 1;
    }

    /**
     * @param $bookingId
     * @return mixed
     */
    public static function getTotalPaid ($bookingId){
        return parent::where('booking_id', $bookingId)->where('deposit', 0)->sum('total_payment');
    }

    /**
     * @param $start
     * @param $end
     * @return int
     */
    public static function getIncome ($start, $end){
        $start = date('Y-m-d 00:00:00', strtotime($start));
        $end = date('Y-m-d 23:59:59', strtotime($end));

        $payment = parent::whereBetween('created_at', [$start, $end])->get();

        $total = 0;
        foreach($payment as $key => $val){
            $total = $total + $val->total_payment;
        }

        return $total;
    }
}
