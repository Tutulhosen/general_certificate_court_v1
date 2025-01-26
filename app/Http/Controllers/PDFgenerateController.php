<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GccAppealOrderSheet;

class PDFgenerateController extends Controller
{
    public function getOrderSheetsPDF($id)
    {
        $appealId=decrypt($id);
        // dd($appealId);
        $data['appealOrderLists']=GccAppealOrderSheet::where('appeal_id',$appealId)->get();    
        $html = view('PDFGenerate.pdf_order_sheet')->with($data);

       $this->generatePamentPDF($html);
    }

    public function generatePamentPDF($html)
    {
        $mpdf = new \Mpdf\Mpdf([
            'default_font_size' => 12,
            'default_font' => 'kalpurush',

        ]);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

}
