<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\student;

class FeeController extends Controller
{
    function libraryPenaltyStore(Request $request)
    {
        $fee_tye = DB::table('fee_info')->where('fee_type', 'library_penalty')->first();
        if ($fee_tye != null) {
            DB::table('fees_amount')
                ->insert([
                    'fee_info_id' => $fee_tye->id,
                    'amount' => $request->lib_penalty_amount
                ]);
        }
        return "library penalty inserted";
       
    }
    function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $admin = DB::table('admin')
            ->where('email', $request->email)
            ->where('password', $request->password)
            ->first();

        if ($admin == null) {
            return "email or password incorrect";
        }

        $session_name = $admin->username;

        $request->session()->put('admin', $session_name);
        return redirect('allStudents');
    }
    function approve($roll_no)
    {
        DB::table('student_registration')
            ->where('roll_no', $roll_no)
            ->update([
                'status' => 'yes'
            ]);

        $fee_id = DB::table('fee_info')
            ->where('fee_type', 'semester_fee')
            ->join('fees_amount', 'fees_amount.fee_info_id', 'fee_info.id')
            ->orderBy('fees_amount.fee_id', 'desc')
            ->get();



        if (
            DB::table('student_account')
            ->where('roll_no', $roll_no)
            ->where('semester', 1)
            ->first() == null
        ) {
            DB::table('student_account')
                ->insert([
                    'roll_no' => $roll_no,
                    'fee_id' => $fee_id[0]->fee_id,
                    'fees_type' => 'fees_amount',
                    'semester' => 1,
                    'date' => date('d-m-y')
                ]);
        }

        return "student approved";
    }
    function allStudent()
    {
        $students =  DB::table('student_registration')
            ->get();
        return view('AllStudents', compact('students'));
    }
    function storePenalty(Request $request)
    {

        $fee_info_id =  DB::table('fee_info')
            ->insertGetId([
                'fee_type' => $request->penalty_type
            ]);

        $fee_id = DB::table('fees_amount')
            ->insertGetId([
                'amount' => $request->penalty_amount,
                'fee_info_id' => $fee_info_id
            ]);

        DB::table('student_account')
            ->insert([
                'roll_no' => $request->roll_no,
                'semester' => $request->semester,
                'fee_id' => $fee_id,
                'fees_type' => 'fees_amount',
                'date' => date('d-m-y h:i:s')
            ]);

        return "penalty added successfully";
    }
    function find_student_for_penalty(Request $request)
    {
        $validate = $request->validate(['roll_no' => 'required']);
        // $validate = $request->validate(['roll_no'=>'required']);
        $roll_no = $request->roll_no;
        //echo $roll_no;

        //if($roll_no!=null){
        $Student = new student;
        $data = $Student::where('roll_no', $roll_no)->get();
        return view('Penalty')->with(['datas' => $data]);
        //}
        //else
        //return view('plain_page');

    }
    function bus_fee_index()
    {
        return view('busfee');
    }

    function account_fee_index()
    {
        return view('account_fee');
    }
    function account_fee_store(Request $request)
    {
        $fee_tye = DB::table('fee_info')->where('fee_type', 'semester_fee')->first();
        if ($fee_tye != null) {
            DB::table('fees_amount')
                ->insert([
                    'fee_info_id' => $fee_tye->id,
                    'amount' => $request->amount
                ]);
        }
        return "fee inserted";
    }

    function bus_fee_store(Request $request)
    {
        $fee_tye = DB::table('fee_info')->where('fee_type', 'bus_fee')->first();
        if ($fee_tye != null) {
            DB::table('fees_amount')
                ->insert([
                    'fee_info_id' => $fee_tye->id,
                    'amount' => $request->amount
                ]);
        }
        return "fee inserted";
    }
}
