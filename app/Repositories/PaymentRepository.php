<?php
/**
 * Created by PhpStorm.
 * User: destructor
 * Date: 11/29/2017
 * Time: 9:51 PM
 */
namespace App\Repositories;

use App\Appeal;
use App\Models\GccPaymentList;
use App\Models\LawBroken;
use App\Models\PaymentList;
use App\Services\AdminAppServices;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Mcms\Auth\Exception;


class PaymentRepository
{
    public static function storePaymentInfo($appealId,$paymentInfo){
        $flag='false';
        $lastPayment='';
        try{
            $payment=new GccPaymentList();
            $payment->paid_loan_amount=$paymentInfo->installMentPay;
            $payment->paid_date= date('Y-m-d',strtotime($paymentInfo->payDate));
            $payment->auctioned_sale=$paymentInfo->auctionSale;
            $payment->auctioned_date= $paymentInfo->auctionDate?date('Y-m-d',strtotime($paymentInfo->auctionDate)):null;
            $payment->auctioneer_name=$paymentInfo->auctioneerName;
            $payment->auctioneer_recipient_name=$paymentInfo->auctioneerRecipientName;
            $payment->is_nilam=$paymentInfo->isNilam;
            $payment->receipt_no=$paymentInfo->payReceipt;
            $payment->appeal_id=$appealId;
            $payment->created_at=date('Y-m-d H:i:s');
            $payment->created_by=globalUserInfo()->username;
            $payment->updated_at=date('Y-m-d H:i:s');
            $payment->updated_by=globalUserInfo()->username;
            $payment->save();
            $flag='true';
            $lastPayment = $payment;

        }catch (\Exception $e) {
            $flag='false';
        }
        return $lastPayment;
    }





}
