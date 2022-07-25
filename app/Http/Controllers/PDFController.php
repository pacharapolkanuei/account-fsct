<?php

namespace App\Http\Controllers;
use PDF;

use Illuminate\Http\Request;
use App\Cheque;

class PDFController extends Controller
{
    public function pdf(){
        $cheque = Cheque::all();
        $pdf = PDF::loadView('pdf',['cheque'=>$cheque]);
        return @$pdf->stream();
    }
}
