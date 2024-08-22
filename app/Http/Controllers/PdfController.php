<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mpdf\Mpdf;

class PdfController extends Controller
{
    public function generatePDF()
    {
        $mpdf = new Mpdf(); // Gunakan alias namespace
        $mpdf->WriteHTML('<h1>Hello World</h1>');
        $mpdf->Output();
    }
}