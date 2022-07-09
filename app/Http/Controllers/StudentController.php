<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    function my_issued_books(Request $request)
    {

        return view('my_issued_books');
    }
    function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $student = DB::table('student_registration')
            ->where('email', $request->email)
            ->where('password', md5($request->password))
            ->first();

        if ($student == null) {
            return "email or password incorrect";
        }

        if ($student->status == 'no') {
            return "login after admin approve your account";
        }

        $session_name = $student->username;

        $request->session()->put('student', $session_name);
        return redirect('my_issued_books');
    }
}
