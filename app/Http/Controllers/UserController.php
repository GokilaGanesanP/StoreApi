<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function user_list()
    {
        $user = User::leftjoin('stores','stores.id', '=' , 'users.store_id')
        ->select(['stores.name as storename', 
                  'users.name', 
                  'users.email', 
                  DB::raw("case when users.role = 1 then 'Admin' else 'User' end as role"),
                  'users.id'])
        ->get();
        return api_response($user, '201'); 
    }

    public function get_User(Request $request)
    {
        $user = User::findOrFail($request->id);
        return api_response($user, '201');
    }

    public function delete_User(Request $request)
    {
        $affectedRows = User::where('id', '=', $request->id)->delete();
        return api_response('User deleted successfully', '201');
    }

    public function update_User(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255', 
            'role' => 'required',
            'store' => 'required',
            'id' => 'required'
        ]);
      
        $user = User::find($request->id);
        $user->update([
            'name' => $request->name,
            'role' => $request->role,   
            'store_id' => $request->store,        
        ]);
        
        return api_response("User Updated Successfully", '201');
    }

}
