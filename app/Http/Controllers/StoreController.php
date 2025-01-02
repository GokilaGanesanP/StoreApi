<?php

namespace App\Http\Controllers;

use App\Models\store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function store_list()
    {
        $store = Store::all();
        return api_response($store, '201'); 
    }

  
    public function create_store(Request $request)
    {
        $request->validate([
            'storename' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        $store = Store::updateOrCreate(
            ['id' => $request->id], 
            [
                'name' => $request->storename,
                'location' => $request->location
            ]
        );
        // $user = Store::create([
        //     'name' => $request->storename,
        //     'location' => $request->location
        // ]);

        if ($store->wasRecentlyCreated) {
            return api_response("Store Created Successfully", '201'); 
        } else {
            return api_response("Store Updated Successfully", '201'); 
        }


        
    }

    
    public function get_Store(Request $request)
    {
        $store = Store::findOrFail($request->id);
        return api_response($store, '201');
    }

   
    public function delete_Store(Request $request)
    {
        $affectedRows = Store::where('id', '=', $request->id)->delete();
        return api_response('Store deleted successfully', '201');
    }
}
