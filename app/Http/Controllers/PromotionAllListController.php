<?php

namespace App\Http\Controllers;
use App\promotionAll;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;
use DataTables;
      

class PromotionAllListController extends Controller
{
   /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */
       

    public function index(Request $request)

    {
        $b = DB::table('promotionall')
            ->join('users', 'users.empId', '=', 'promotionall.empId')
            ->select('users.basicPay','promotionall.id','promotionall.empId','promotionall.grade',DB::raw('Year(promotionDueDate) AS promotionDueDate'),DB::raw('month(promotionDueDate) AS month'))
            ->get();

         if ($request->ajax()) {
            $data=$b;
            // $data = promotionAll::latest()->get();
            return Datatables::of($data)

                    // ->addIndexColumn()

                    ->filter(function ($instance) use ($request) {

                        if (!empty($request->get('promotionDueDate'))) {

                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {

                                return Str::contains($row['promotionDueDate'], $request->get('promotionDueDate')) ? true : false;

                            });

                        } 
                        
                        if (!empty($request->get('month'))) {

                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {

                                return Str::contains($row['month'], $request->get('month')) ? true : false;

                            });

                        }

   

                        if (!empty($request->get('search'))) {

                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {

                                if (Str::contains(Str::lower($row['promotionDueDate']), Str::lower($request->get('search')))){

                                    return true;

                                }else if (Str::contains(Str::lower($row['grade']), Str::lower($request->get('search')))) {

                                    return true;

                                }else if (Str::contains(Str::lower($row['empId']), Str::lower($request->get('search')))) {

                                    return true;

                                }else if (Str::contains(Str::lower($row['basicPay']), Str::lower($request->get('search')))) {

                                    return true;

                                }

   

                                return false;

                            });

                        }

   

                    })

                    ->addColumn('action', function($row){

  

                           $btn = '<input type="checkbox" >';
                        //    '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';

                            return $btn;

                    })

                    ->rawColumns(['action'])

                    ->make(true);

        }

    

        return view('promotion.promotionAllList');

    }

}

?>
