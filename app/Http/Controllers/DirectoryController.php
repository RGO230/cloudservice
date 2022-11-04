<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Directory;

class DirectoryController extends Controller
{
    public function createdirectory(Request $request){
        $request->validate([
            'path'=>'string|required',
            'user_id'=>'required'
        ]);
       
       return Directory::create($request->all());
        

    }
}
