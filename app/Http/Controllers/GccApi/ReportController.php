<?php

namespace App\Http\Controllers\GccApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    //gcc report generate
    public function gcc_report_pdf_generate(Request $request){
        return $request->all();
    }
}
