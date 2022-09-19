<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LibraryPenaltyController extends Controller
{
    function index()
    {

        $datas = DB::table('issue_books')
            ->join('student_registration', 'student_registration.roll_no', 'issue_books.student_enrollment')
            ->join('ssid', 'ssid.ssid', 'issue_books.ssid')
            ->join('books', 'books.id', 'ssid.book_id')
            ->get();

        $penalty = DB::table('fee_info')
            ->where('fee_type', 'library_penalty')
            ->join('fees_amount', 'fees_amount.fee_info_id', 'fee_info.id')
            ->orderBy('fees_amount.fee_id', 'desc')
            ->first();

        return view('lib_penalty_amount', compact('datas'))->with(['penalty' => $penalty]);
    }
    function store(Request $request)
    {
        $request->validate([
            'penalty_amount' => 'required',
            'roll_no' => 'required',
            'ssid' => 'required'
        ]);
        $semester = DB::table('student_registration')->where('roll_no',$request->roll_no)->first()->semester;
        DB::table('payment')
            ->insert([
                'amount' => $request->penalty_amount,
                'roll_no' => $request->roll_no,
                'semester' => $semester,
                'date_of_payment' => date('y-m-h')
            ]);

        DB::table('issue_books')
            ->where('ssid', $request->ssid)
            ->update([
                'penalty' => 0
            ]);

            return "payment done successfully";
    }
}
