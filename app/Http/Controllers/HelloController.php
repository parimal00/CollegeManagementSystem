<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller as BaseController;
use App\student;
use App\scholarship;
use App\bus_account;
use App\student_info;
use App\students_with_due_balance;
use Illuminate\Http\Request;

class Hellocontroller extends Controller
{
  function roll_no_payment_history(Request $request)
  {
    $roll_no = $request->roll_no;

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



    return view('payment_history')->with(['datas' => $data]);;
  }
  function payment_history()
  {
    return view('payment_history');
  }

  function accountant_login(Request $request)
  {
    return "jack is sexy";
    $username = $request->username;
    $password = $request->password;

    $row =  DB::table('accountant_registration')
      ->where('username', $username)
      ->where('password', $password)
      ->get();

    //return $row->name;




    if (count($row) == 1) {
      foreach ($row as $rows) {
        $session_name = $rows->username;
      }
      $request->session()->put('accountant', $session_name);

      return view('plain_page');
    } else {
      echo "login failed";
    }
  }


  public function stu_scho_get_info()
  {
    //return session('accountant');

    if (!session()->has('accountant')) {


      return view('accountantlogin');
    }

    //  $scholarship = new scholarship;
    //  $data= $scholarship::all();
    //  return view('view_scholarship_students')->with(['data'=>$data]);
    $data = DB::table('scholarships')
      ->join('student_account', 'student_account.roll_no', 'scholarships.roll_no')
      ->join('student_registration', 'student_registration.roll_no', 'scholarships.roll_no')
      ->get();

    return view('view_scholarship_students')->with(['data' => $data]);
  }

  public function  stu_due_get_info()
  {

    // $student_with_due_balance = new students_with_due_balance;
    // $data= $student_with_due_balance::all();
    // return view('due_balance_students')->with(['data'=>$data]);

    $data = DB::table('students_with_due_balance')
      ->join('student_registration', 'student_registration.roll_no', 'students_with_due_balance.roll_no')
      ->get();

    return view('due_balance_students')->with(['data' => $data]);
  }

  public function update_all_info()
  {
    if (!session()->has('accountant')) {
      return view('accountantlogin');
    }

    $fee_id = DB::table('fee_info')
      ->where('fee_type', 'semester_fee')
      ->rightJoin('fees_amount', 'fees_amount.fee_info_id', 'fee_info.id')
      ->orderBy('fee_id', 'desc')
      ->first()
      ->fee_id;


    $student_info = DB::table('student_registration')
      ->get();

    foreach ($student_info as $student) {
      DB::table('student_registration')
        ->where('roll_no', $student->roll_no)
        ->where('semester', '<', 9)
        ->update([
          'semester' => $student->semester + 1
        ]);

      DB::table('student_account')
        ->where('roll_no', $student->roll_no)
        ->insert([
          'roll_no' => $student->roll_no,
          'fee_id' => $fee_id,
          'fees_type' => 'fees_amount',
          'semester' => $student->semester + 1,
          'date' => date("Y-m-d")
        ]);


      DB::table('scholarships')
        ->where('roll_no', $student->roll_no)
        ->insert([
          'roll_no' => $student->roll_no,
          'scholarship_sem' => $student->semester + 1,
          'scholarship_amount' => 0
        ]);

      if ($student->semester >= 8) {
        DB::table('student_registration')
          ->where('roll_no', $student->roll_no)
          ->update([
            "passed_out" => 1
          ]);
      }
    }
  }









  public function update(Request $request)
  {

    if (!session()->has('accountant')) {


      return view('accountantlogin');
    }
    $student_info = new student_info;
    echo $request->semester;
    echo $request->roll_no;
    echo $request->semester_fee;
    echo $request->balance_due;
    echo $request->scholarship;
    echo $request->bus_fee;
    echo $request->total_fee;

    DB::table('student_registration')
      ->where('roll_no', $request->roll_no)
      ->update([
        'semester' => $request->semester
      ]);

    $student_info::where('roll_no', $request->roll_no)
      ->update(['semester_fee' => $request->semester_fee, 'balance_due' => $request->balance_due, 'scholarship' => $request->scholarship, 'bus_fee' => $request->bus_fee, 'total_fee' => $request->total_fee - $request->scholarship + $request->busfee + $request->balance_due]);

    $scholarship_row = DB::table('scholarships')
      ->where('roll_no', $request->roll_no)
      ->get();

    if (count($scholarship_row) == 0 && $request->scholarship > 0) {
      DB::table('scholarships')
        ->where('roll_no', $request->roll_no)
        ->insert([
          'roll_no' => $request->roll_no
        ]);
    }


    $balance_due_row = DB::table('students_with_due_balance')
      ->where('roll_no', $request->roll_no)
      ->get();

    if (count($balance_due_row) == 0 && $request->balance_due > 0)
      DB::table('students_with_due_balance')
        ->where('roll_no', $request->roll_no)
        ->insert(
          ['roll_no' => $request->roll_no]
        );
  }

  public function edit_student_info(Request $request)
  {
    if (!session()->has('accountant')) {


      return view('accountantlogin');
    }
    $student_info = new student_info;
    $data = DB::table('student_account')
      ->join('student_registration', 'student_registration.roll_no', 'student_account.roll_no')
      ->get();
    //$data = $student_info::where('roll_no',$request->roll_no)->get();
    return view('edit_student_info')->with(['data' => $data]);

    //echo $request->roll_no;

  }

  public function search_student(Request $request)
  {
    if (!session()->has('accountant')) {


      return view('accountantlogin');
    }
    $student_info = new student_info;
    echo $request->roll_no;

    $data = $student_info::where('roll_no', $request->roll_no)->get();

    return view('search_students')->with(['data' => $data]);
  }


  public function submit_amount(Request $request)
  {
    if (!session()->has('accountant')) {


      return view('accountantlogin');
    }

    $roll_no = $request->roll_no;
    $obtained_amount = $request->obtained_amount;

    $student = DB::table('student_registration')
      ->where('roll_no', $roll_no)
      ->get();

    if (count($student) == 0) {
      return "roll no does not exist";
    }
    $semester = $student[0]->semester;

    DB::table('payment')
      ->insert([
        "semester" => $semester,
        "roll_no" => $roll_no,
        "amount" => $obtained_amount,
        "date_of_payment" => date('d-m-y h:i:s')
      ]);

    return "payment done successfully";
  }

  public function getInfo_amount(Request $request)
  {


    if (!session()->has('accountant')) {


      return view('accountantlogin');
    }
    $roll_no = $request->bname;

    $student = DB::table('student_registration')
      ->where('roll_no', $roll_no)
      ->get();

    if (count($student) == 0) {
      return "the roll no does not exist";
    }
    $semester = $student[0]->semester;
    $total = 0;
    for ($i = 1; $i <= $semester; $i++) {
      //this loop is to calculate total of all
      //also consider the scholarship

      $accounts = DB::table('student_account')
        ->where('student_account.roll_no', $roll_no)
        ->where('fees_type', 'fees_amount')
        ->where('semester', $i)
        ->join('fees_amount', 'fees_amount.fee_id', 'student_account.fee_id')
        ->join('fee_info', 'fee_info.id', 'fees_amount.fee_info_id')
        // ->join('scholarships', 'scholarships.roll_no', 'student_account.roll_no')
        // ->where('scholarships.scholarship_sem', $i)
        ->join('scholarships', function ($join) use ($i) {
          $join->on('student_account.roll_no', '=', 'scholarships.roll_no')
            ->where('scholarships.scholarship_sem', '=', $i);
        })
        ->get();





      $scholarships = DB::table('scholarships')
        ->where('roll_no', $roll_no)
        ->where('scholarship_sem', $i)
        ->get();


      foreach ($accounts as $account) {

        if ($account->fee_type == "semester_fee") {
          $total = $total + $account->amount - $account->scholarship_amount;
        } else {
          $total = $total + $account->amount;
        }
      }






      //total is the total fee of all semester





    }





    $ts_total = 0;
    $this_sem_account = DB::table('student_account')
      ->where('student_account.roll_no', $roll_no)
      ->where('fees_type', 'fees_amount')
      ->where('semester', $semester)
      ->join('fees_amount', 'fees_amount.fee_id', 'student_account.fee_id')
      ->join('fee_info', 'fee_info.id', 'fees_amount.fee_info_id')
      ->join('scholarships', 'scholarships.roll_no', 'student_account.roll_no')
      ->where('scholarships.scholarship_sem', $semester)
      ->get();

    foreach ($this_sem_account as $tsa) {
      if ($tsa->fee_type == "semester_fee") {
        $ts_total = $ts_total + $tsa->amount - $tsa->scholarship_amount;
      } else {
        $ts_total = $ts_total + $tsa->amount;
      }

      //ts_total is total fee in this semester
    }




    //calculate total from payment
    $total_previous_payment = 0;
    $ts_payment = 0;

    for ($i = 1; $i < $semester; $i++) {

      $accounts = DB::table('payment')
        ->where('roll_no', $roll_no)
        ->where('semester', $i)
        ->get();





      if (count($accounts) > 0) {

        //to check if there is any payment made

        foreach ($accounts as $account) {
          $total_previous_payment = $total_previous_payment + $account->amount;
        }
      }
    }

    $ts_payment_acc = DB::table('payment')
      ->where('roll_no', $roll_no)
      ->where('semester', $semester)
      ->get();





    if (count($ts_payment_acc) > 0) {

      //to check if there is any payment made in this sem

      foreach ($ts_payment_acc as $account) {
        $ts_payment = $ts_payment + $account->amount;
      }
    }
    //ts_payment is paymjent in this semester


    $j = 0;
    $total_others_account = 0;
    for ($j = 0; $j < $semester; $j++) {
      $others_accounts =  DB::table('student_account')
        ->where('student_account.roll_no', $roll_no)
        ->where('student_account.semester', $j)
        ->where('fees_type', 'others_account')
        ->join('others_account', 'others_account.id', 'student_account.fee_id')
        ->get();

      foreach ($others_accounts as $others_account) {
        $total_others_account = $total_others_account + $others_account->amount;
        //total_others_account is total in others semester
      }
    }

    $total_others_account_ts = 0;
    $others_accounts_ts =  DB::table('student_account')
      ->where('student_account.roll_no', $roll_no)
      ->where('student_account.semester', $semester)
      ->where('fees_type', 'others_account')
      ->join('others_account', 'others_account.id', 'student_account.fee_id')
      ->get();

    foreach ($others_accounts_ts as $others_account) {
      $total_others_account_ts = $total_others_account_ts + $others_account->amount;
      //total_others_account_ts is total in others this semester
    }






    $data = ["roll_no" => $roll_no, "semester" => $semester, "total" => $total + $total_others_account + $total_others_account_ts, "ts_total" => $ts_total + $total_others_account_ts, "total_previous_payment" => $total_previous_payment, "ts_payment" => $ts_payment];



    //calculation ended
    return view('get_amount')->with(['data' => $data]);
  }



  public function getInfo()
  {
    if (!session()->has('accountant')) {


      return view('accountantlogin');
    }

    $datas = DB::table('student_account')
      ->join('student_registration', 'student_registration.roll_no', 'student_account.roll_no')
      ->get();
    //$datas = DB::table('student_account')->get();
    // $student_info = new student_info;
    // $datas = $student_info::all();
    return view('student_info')->with(['data' => $datas]);
  }

  public function busfee_add(Request $request)
  {
    $validate = $request->validate(['roll_no' => 'required']);

    $roll_no = $request->roll_no;


    $students =  DB::table('student_registration')
      ->where('roll_no', $roll_no)
      ->get();



    $fee_id = $request->fee_id;

    $semester = $students[0]->semester;
    $date = date('d-m-y h:i:s');

    $bus_account = DB::table('student_account')
      ->where('semester', $semester)
      ->where('fee_id', $fee_id)
      ->get();

    if (count($bus_account) > 0) {
      return "bus fee already added";
    }

    DB::table('student_account')
      ->insert([
        'roll_no' => $roll_no,
        'fee_id' => $fee_id,
        'fees_type' => 'fees_amount',
        'semester' => $semester,
        'date' => $date
      ]);


    $data = "<script>alert('data submitted successfully');</script>";


    return view('add_account')->with(['data' => $data]);
  }


  public function scholarship_add(Request $request)
  {
    $scholarship = new scholarship;

    $request->validate(['percentage' => 'required']);


    $fee = 103000;

    /* echo $request->roll_no;
      echo $request->firstname;
      echo $request->lastname;
      echo $request->semester;
      echo $request->percentage;*/



    /*$validate = $request->validate(['roll_no'=>'required']);
      $validate = $request->validate(['student_name'=>'required']);
      $validate = $request->validate(['lastname'=>'required']);
      $validate = $request->validate(['scholarship_sem'=>'required']);
      $validate = $request->validate(['scholarship_percentage'=>'required']);
      */





    // $total_fee=0;
    // $scholarship->roll_no = $request->roll_no;
    // $scholarship->student_name =  $request->firstname;
    // $scholarship->lastname = $request->lastname;
    // $scholarship->scholarship_sem = $request->semester;
    // $scholarship->scholarship_percentage = $request->percentage;
    $roll_no = $request->roll_no;
    $scholarship_amount = $request->percentage;
    $student = DB::table('student_registration')
      ->where('roll_no', $roll_no)
      ->get();


    $semester = null;
    foreach ($student as $students) {
      $semester = $students->semester;
    }


    $scholarship_student = DB::table('scholarships')
      ->where('roll_no', $roll_no)
      ->where('scholarship_sem', $semester)
      ->get();

    if ($scholarship_student[0]->scholarship_amount > 0) {
      echo "scholarship already added";
      //echo $scholarship::where('roll_no',$roll_no)->first();
    } else {
      $student_info = new student_info;

      $data = $student_info::where('roll_no', $roll_no)->get();
      foreach ($data as $row) {
        $total_fee = $row['total_fee'];
      }
      DB::table('scholarships')
        ->where('scholarship_sem', $semester)
        ->where('roll_no', $roll_no)
        ->update([
          'roll_no' => $roll_no,
          'scholarship_amount' => $scholarship_amount,
          'scholarship_sem' => $semester
        ]);
      // ->insert([
      //   'roll_no' => $roll_no,
      //   'scholarship_amount' => $scholarship_amount,
      //   'scholarship_sem' => $semester
      // ]);




      // $student_info::where('roll_no',$roll_no)
      // ->update(['scholarship'=>$scholarship_amount]);

      // $student_info::where('roll_no',$roll_no)
      // ->update(['total_fee'=>$total_fee-$scholarship_amount]);

      $script = "<script>alert('scholarship submitted successfully');</script>";
      echo $script;
      return view('plain_page');
    }
  }

  public function getStudentInfo(Request $request)
  {

    $roll_no = $request->bname;

    if ($roll_no != null) {
      $Student = new student;
      $data = $Student::where('roll_no', $roll_no)->get();
      return view('add_account')->with(['datas' => $data]);
    } else
      return view('add_account');
  }

  public function index()
  {
    return view('plain_page');
  }
  public function getData(Request $request)
  {
    if (!session()->has('accountant')) {


      return view('accountantlogin');
    }

    $validate = $request->validate(['roll_no' => 'required']);
    // $validate = $request->validate(['roll_no'=>'required']);
    $roll_no = $request->roll_no;
    //echo $roll_no;

    //if($roll_no!=null){
    $Student = new student;
    $data = $Student::where('roll_no', $roll_no)
      ->where('status', 'yes')
      ->get();
    return view('plain_page')->with(['datas' => $data]);
    //}
    //else
    //return view('plain_page');



  }
  public function getData_bus(Request $request)
  {
    if (!session()->has('accountant')) {


      return view('accountantlogin');
    }

    $validate = $request->validate(['roll_no' => 'required']);

    $roll_no = $request->roll_no;


    // if($roll_no!=null){
    $Student = new student;
    $data = $Student::where('roll_no', $roll_no)
      ->where('status', 'yes')
      ->get();

    $bus_fee = DB::table('fee_info')
      ->where('fee_type', 'bus_fee')
      ->join('fees_amount', 'fees_amount.fee_info_id', 'fee_info.id')
      ->orderBy('date', 'DESC')
      ->get();


    $bus_fee = (json_decode($bus_fee));

    $latest_bus_fee = $bus_fee[0]->amount;
    $fee_id = $bus_fee[0]->fee_id;







    return view('add_account')->with(['datas' => $data, 'bus_fee' => $latest_bus_fee, 'fee_id' => $fee_id]);
    //}
    // else
    //return view('add_account');*/



  }
}
