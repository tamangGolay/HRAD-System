<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class PdfController extends Controller
{
    public function create()
    {
    	$data = ['title' => 'Laravel 7 Generate PDF From View Example Tutorial'];
        $pdf = PDF::loadView('pdf', $data);
  
        return $pdf->download('Nicesnippets.pdf');
    }
}