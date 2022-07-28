<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\notesheetRequest;
use App\notesheetapprove;

use PDF;
// use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;


class ProductController extends Controller
{

    public function index1 () {


        // $product = Product::all()->where('user_id',$id);
        $notesheet = notesheetRequest::all();

        return view('report', compact ('notesheet'));
    }
    public function index ($id) {

        // dd($id);

        $product = Product::all()->where('user_id',$id);
        $user = User::find($id);

        return view('index', compact ('product','user'));
    }
   
   public function createPDF ($id) {


    $notesheetapprove = notesheetapprove::all()->where('noteId',$id);
    $notesheet = notesheetRequest::find($id);
        // view()->share ('products', $products);
        $pdf = PDF ::loadView ('index', array('notesheet'=>$notesheet,'notesheetapprove'=>$notesheetapprove));
        return $pdf->download ('notesheet.pdf');
    }
}