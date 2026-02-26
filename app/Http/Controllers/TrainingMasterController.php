<?php
         
namespace App\Http\Controllers;
          
use App\Vehicles;
use App\TrainingMaster;
use Illuminate\Http\Request;
use DataTables;
use DB;
        
class TrainingMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $b = DB::table('trainingmaster');
        
        if ($request->ajax()) {
            $data = $b;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-trainingId="'.$row->trainingId.'" data-original-title="Edit" class="edit btn btn-outline-info btn-sm edit">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('Certificate.trainingmaster',compact('b'));
    }
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
     {
    
    $data = [
        'trainingName' => $request->trainingName,
        'startDate' => $request->startDate,
        'endDate' => $request->endDate,
        'institute' => $request->institute,
        'place' => $request->place,
        'signer1Name' => $request->signer1Name,
        'signer1Designation' => $request->signer1Designation,
        'signer2Name' => $request->signer2Name,
        'signer2Designation' => $request->signer2Designation,
    ];

    // ✅ UPDATE case: keep existing trainingId
    if (!empty($request->trainingId)) {
        Trainingmaster::updateOrCreate(['trainingId' => $request->trainingId], $data);
        return response()->json(['success' => 'Training updated successfully.']);
    }

    // ✅ CREATE case: generate year-based unlimited trainingId (BIGINT)
    DB::transaction(function () use (&$data) {

        $year = (int) date('Y'); // 2026

        // Get max trainingId that starts with the current year
        $maxId = DB::table('trainingmaster')
            ->whereRaw("CAST(trainingId AS CHAR) LIKE ?", [$year . '%'])
            ->lockForUpdate()
            ->max('trainingId');

        // Compute next serial
        if (!$maxId) {
            $nextSerial = 1; // => 0001
        } else {
            $serialPart = substr((string)$maxId, 4); // remove year (first 4 digits)
            $nextSerial = ((int)$serialPart) + 1;
        }

        // Build trainingId: YEAR + min-4-digit serial, grows after 9999
        $data['trainingId'] = (int) ((string)$year . str_pad((string)$nextSerial, 4, '0', STR_PAD_LEFT));

        TrainingMaster::create($data);
    });

    return response()->json(['success' => 'New Training added successfully.']);
}
    
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($trainingId)
    {

     $a = TrainingMaster::where('trainingId', $trainingId)->first();
    return response()->json($a);
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $query = DB::table('designationmaster')->where('id', $request->id)
            ->increment('status');

        return response()
            ->json(['success' => 'Deleted successfully.']);
    }

    //To redirect to the manage_vehicle page after the management of vehicle
    public function message(Request $request)
    {

        return redirect('home');
    }

}