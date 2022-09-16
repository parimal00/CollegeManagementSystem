<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Test extends Controller
{
    function index(Request $request){
        
      $username= $request->username;
      $password =$request->password;

    $row=  DB::table('accountant_registration')
      ->where('username',$username)
      ->where('password',$password)
      ->get();

      //return $row->name;

  


     if(count($row)==1){
      foreach($row as $rows){
        $session_name= $rows->username;
      }
        $request->session()->put('accountant',$session_name);
       
        return view('plain_page');
     }
     else{
       return back()->with('failure','Login failed');
     }

    }
}
