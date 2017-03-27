<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
