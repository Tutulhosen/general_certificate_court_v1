<?php
/**
 * Created by PhpStorm.
 * User: ashraful
 * Date: 2/9/18
 * Time: 12:49 PM
 */

namespace App\Services;


use Illuminate\Support\Facades\DB;

class PaymentService
{
    public static function getPaidListByAppealId($appealId){
        $paymentInfo=DB::connection('mysql')
            ->select(DB::raw(
                "SELECT pl.id,
                        pl.appeal_id,
                        pl.paid_loan_amount,
                        ifnull(pl.auctioned_sale,'') as auctioned_sale,
                        ifnull(pl.auctioned_date,'') as auctioned_date,
                        ifnull(pl.auctioneer_name,'') as auctioneer_name,
                        ifnull(pl.auctioneer_recipient_name,'') as auctioneer_recipient_name,
                        ifnull(pl.att_file,'') as att_file,
                        ifnull(pl.att_file_caption,'') as att_file_caption,
                        pl.receipt_no,
                        pl.paid_date,
                        GROUP_CONCAT('<a title=\" ডাউনলোড করতে ক্লিক করুন \" href=\"/ECOURT/',atc.file_path,atc.file_name,'\" class=\"btn-link btn-md\" download=\"\"><i class=\"fa fa-download\"></i> ',atc.file_category,' </a>','<br>' SEPARATOR '') as atachmentList,
                        GROUP_CONCAT(atc.file_category,'<br>' SEPARATOR '') as atachmentListWithoutDownload
                       FROM gcc_payment_lists pl
                       LEFT JOIN attachments atc ON atc.payment_id=pl.id
                       WHERE pl.appeal_id=$appealId
                       GROUP BY pl.id"
            ));
        return $paymentInfo;
    }

    public static function getTotalDueAmount($appealId,$totalLoanAmount){
        $paidLoanAmount=DB::connection('mysql')
            ->select(DB::raw(
                "SELECT sum(pl.paid_loan_amount) as paidLoanAmount
                       FROM gcc_payment_lists pl
                       WHERE pl.appeal_id=$appealId "
            ));
        $totalDueAmount=$totalLoanAmount-$paidLoanAmount[0]->paidLoanAmount;
        return $totalDueAmount;
    }

    public static function getAuctionTotalAmount($appealId){
        $auctionSale=DB::connection('mysql')
            ->select(DB::raw(
                "SELECT sum(pl.auctioned_sale) as auctionSale
                       FROM gcc_payment_lists pl
                       WHERE pl.appeal_id=$appealId "
            ));
        return $auctionSale[0]->auctionSale;
    }

    public static function getPaymentAttachmentByAppealId($appealId){
        $attachmentList=DB::connection('mysql')
            ->select(DB::raw(
                "SELECT atch.file_path,atch.file_name,atch.file_category, pl.paid_date,pl.appeal_id
                       FROM  gcc_attachments atch
                       JOIN gcc_payment_lists pl ON atch.payment_id=pl.id

                       WHERE atch.appeal_id=$appealId "
            ));
            // dd($attachmentList);
        return $attachmentList;

    }

}
