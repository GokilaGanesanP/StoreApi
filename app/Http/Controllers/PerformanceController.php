<?php

namespace App\Http\Controllers;

use App\Models\performance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerformanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create_performance(Request $request)
    {
        $request->validate([
            'userid' => 'required',
            'storeid' => 'required',
            'date' => 'required',
            'packages' => 'required',

        ]);

        $performance = Performance::updateOrCreate(
            ['id' => $request->id], 
            [
                'user_id' => $request->userid,
                'store_id' => $request->storeid,
                'packages_done' => $request->packages,
                'package_date' => $request->date
            ]
        );
      

        if ($performance->wasRecentlyCreated) {
            return api_response("User Performance Created Successfully", '201'); 
        } else {
            return api_response("User Performance Updated Successfully", '201'); 
        }
    }


    public function performance_list(Request $request)
    {       
      
        $performance = Performance::leftjoin('stores','stores.id', '=' , 'performances.store_id')
        ->leftjoin('users','users.id', '=' , 'performances.user_id')
        ->select(['users.name as username',
                  'stores.name as storename', 
                  'performances.packages_done', 
                  'performances.package_date',
                  'performances.id'
    ]);

    if($request->role === '2'){
        $performance->where('performances.user_id', $request->userid);
    }

  
         $performanceData = $performance->get();

            
        return api_response($performanceData, '201'); 
    }


    public function get_Performance_id(Request $request)
    {
        $performance = Performance::leftjoin('stores','stores.id', '=' , 'performances.store_id')
        ->leftjoin('users','users.id', '=' , 'performances.user_id')
        ->select(['stores.name as storename', 
                  'performances.packages_done', 
                  'performances.package_date',
                  'performances.id',
                  'performances.user_id',
                  'performances.store_id'])
        ->where('performances.id',$request->id)
        ->first();
        return api_response($performance, '201'); 
    }

    public function delete_Performance(Request $request)
    {
        $affectedRows = Performance::where('id', '=', $request->id)->delete();
        return api_response('Performance deleted successfully', '201');
    }


    public function get_user_performance()
    {
        $performance = Performance::leftjoin('stores','stores.id', '=' , 'performances.store_id')
        ->leftjoin('users','users.id', '=' , 'performances.user_id')
        ->select(DB::raw('users.name, SUM(packages_done) as y'))
        ->groupBy('performances.user_id', 'users.name')
        ->get();

        return api_response($performance, '201'); 
    }

    public function get_store_performance()
    {
        $performance = Performance::leftjoin('stores','stores.id', '=' , 'performances.store_id')
        ->leftjoin('users','users.id', '=' , 'performances.user_id')
        ->select(DB::raw('stores.name as label, CONVERT(SUM(packages_done), UNSIGNED) as y'))
        ->groupBy('performances.store_id', 'stores.name')
        ->get();

        return api_response($performance, '201'); 
    }





   

}
