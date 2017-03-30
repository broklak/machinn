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
        'card_expiry_month', 'card_expiry_year', 'bank_transfer_recipient', 'created_by', 'guest_id', 'flow_type'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'booking_payment_id';

    /**
     * @param $type
     * @param null $extrachargeId
     * @return string
     */
    public static function setDescription($type, $extrachargeId = null) {
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
                'card_expiry_month' => (int) substr($input['card_expired_date'], 0, 2),
                'card_expiry_year' => (int) substr($input['card_expired_date'], -4),
                'bank_transfer_recipient' => $input['cash_account_id'],
                'created_by'        => Auth::id()
            ];

            if(count($payment) == 0){
                parent::create($paymentData);
            } else {
                parent::find($payment->booking_payment_id)->update($paymentData);
            }
        } else { // DELETE ALL DOWNPAYMENT IF TENTATIVE
            $payment = parent::where('booking_id', $header->booking_id)
                ->where('type', 1)->delete();
        }
        return 1;
    }
}
