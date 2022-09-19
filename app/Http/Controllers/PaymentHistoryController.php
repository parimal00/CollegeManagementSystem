<?php

namespace App\Http\Controllers;

use App\scholarship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentHistoryController extends Controller
{
    function index(){
        $username=session('student');
      
        $roll_no = DB::table('student_registration')
        ->where('username',session('student'))
        ->first()->roll_no;

       
        $student =  DB::table('student_registration')
          ->where('roll_no', $roll_no)
          ->get();
        if (count($student) == 0) {
          return "roll no does not exist";
        }
        $semester = $student[0]->semester;
    
    
        $data = [];
        for ($i = 1; $i <= $semester; $i++) {
    
          $array = [];
    
          $payments = DB::table('payment')
            ->where('roll_no', $roll_no)
            ->where('semester', $i)
            ->get();
    
    
          $fees = DB::table('student_account')
            ->where('roll_no', $roll_no)
            ->where('semester', $i)
            ->join('fees_amount', 'fees_amount.fee_id', 'student_account.fee_id')
            ->join('fee_info', 'fee_info.id', 'fees_amount.fee_info_id')
            ->get();
          array_push($array, $payments, $fees);
    
          array_push($data, $array);
          $array = [];
        }
    
        $scholarship = scholarship::where('roll_no', $roll_no)
          ->get();
    
        return view('my_account_history')->with(['datas' => $data, 'scholarship' => $scholarship]);;
    }
}
