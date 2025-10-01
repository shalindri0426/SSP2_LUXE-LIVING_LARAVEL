<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function showuser($id){
        $users = User::find($id);

        // return view('admin.editcat',compact('user'));
    }

    public function deleteuser($id){
        $users = User::findOrFail($id);
        $users->delete();

        return redirect()->back()->with('deleted','User Deleted Successfully!');
    }

    
}
