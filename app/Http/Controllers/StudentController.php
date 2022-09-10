<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    function my_issued_books(Request $request)
    {
        $username = session()->get('student');
        $roll_no = DB::table('student_registration')
            ->where('username', $username)
            ->first()
            ->roll_no;

        $my_issued_books = DB::table('issue_books')
            ->where('student_enrollment', $roll_no)
            ->join('ssid', 'ssid.ssid', 'issue_books.ssid')
            ->where('books_return_date', null)
            ->join('books', 'books.id', 'ssid.book_id')
            ->join('edition_info', 'ssid.edition_id', 'edition_info.edition')
            ->get();


        return view('my_issued_books', compact('my_issued_books'));
    }
    function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $student = DB::table('student_registration')
            ->where('email', $request->email)
            ->first();


        if ($student == null) {
            return "username or password incorrect";
        }

        if (!Hash::check($request->password, $student->password)) {
            return "username or password incorrect";
        }

        if ($student->status == 'no') {
            return "login after admin approve your account";
        }


        $session_name = $student->username;

        $request->session()->put('student', $session_name);
        return redirect('my_issued_books');
    }
}
