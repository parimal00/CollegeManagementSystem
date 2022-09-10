<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\book;
use Illuminate\Support\Facades\DB;
use App\student;
use Illuminate\Support\Facades\Validator;


class BookController extends Controller
{
    function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $librarian = DB::table('librarian_registration')
            ->where('email', $request->email)
            ->where('password', $request->password)
            ->first();

        if ($librarian == null) {
            return "email or password incorrect";
        }

        $session_name = $librarian->username;

        $request->session()->put('librarian', $session_name);
        return view('Librarian.issue_books');
    }
    function returnBook(Request $request)
    {

        $penalty =  DB::table('issue_books')
            ->where('ssid', $request->ssid)
            ->where('penalty', 0)
            ->first();
        if ($penalty != null) {
            DB::table('issue_books')
                ->where('ssid', $request->ssid)
                ->update([
                    'books_return_date' => date("Y-m-d")
                ]);

            return "book returned successfully";
        }
        return "book can only be returned after paying the penalty";
    }
    function findStudentWithReturnBook(Request $request)
    {
        $request->validate([
            'ssid' => 'required'
        ]);
        $book_with_student =   DB::table('issue_books')
            ->where('issue_books.ssid', $request->ssid)
            ->join('student_registration', 'student_registration.roll_no', 'issue_books.student_enrollment')
            ->join('ssid', 'ssid.ssid', 'issue_books.ssid')
            ->join('books', 'books.id', 'ssid.book_id')
            ->where('issue_books.books_return_date', null)
            ->get();

        if (count($book_with_student) == 0) {
            return "this book has not been issued yet";
        }


        return view('Librarian.return_book')->with(['datas' => $book_with_student]);
    }
    function updateBook(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'edition' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'author_name' => 'required',
            'book_name' => 'required',
            'ssid' => 'required',
            'book_id' => 'required'
        ]);

        if ($validator->fails()) {
            return view('Librarian.update_book')->with(['error' => $validator->errors()]);
        }

        book::where('id', $request->book_id)
            ->update([
                'book_name' => $request->book_name,
                'author_name' => $request->author_name
            ]);

        DB::table('edition_info')
            ->where('book_id', $request->book_id)
            ->where('edition', $request->edition)
            ->update([
                'edition' => $request->edition,
                'price' => $request->price,
                'total_quantity' => $request->quantity,
            ]);
        return "book successfully updated";
    }
    function findBookToUpdate(Request $request)
    {
        $request->validate(['ssid' => 'required']);
        $book = DB::table('ssid')
            ->where('ssid.ssid', $request->ssid)
            ->join('books', 'books.id', 'ssid.book_id')
            ->join('edition_info', 'edition_info.id', 'ssid.edition_id')
            ->select(
                'ssid.id',
                'ssid.ssid',
                'books.book_name',
                'books.author_name',
                'total_quantity',
                'price',
                'edition',
                'books.id as book_id'
            )
            ->get();


        return view('Librarian.update_book')->with(['book' => $book]);
    }
    function findStudent(Request $request)
    {
        $validate = $request->validate(['roll_no' => 'required']);
        // $validate = $request->validate(['roll_no'=>'required']);
        $roll_no = $request->roll_no;
        //echo $roll_no;

        //if($roll_no!=null){
        $Student = new student;
        $data = $Student::where('roll_no', $roll_no)->get();
        return view('Librarian.issue_books')->with(['datas' => $data]);
    }
    function issueBook(Request $request)
    {

        // $request->validate([
        //     'roll_no_two' => 'required',
        //     'ssid' => 'required'
        // ]);

        $roll_no = $request->roll_no_two;
        $ssid = $request->ssid;

        $book_present = DB::table('ssid')
            ->where('ssid', $ssid)
            ->first();

        if ($book_present == null) {
            return "ssid not valid";
        }
        $issued_book = DB::table('issue_books')
            ->where('ssid', $ssid)
            ->where('books_return_date', null)
            ->first();
        if ($issued_book != null) {
            return 'book is already issued';
        }
        if ($roll_no == null || $ssid == null) {
            return "roll no and ssid required";
        }
        DB::table('issue_books')
            ->insert([
                'ssid' => $ssid,
                'student_enrollment' => $roll_no,
                'books_issue_date' => date("Y-m-d")
            ]);
        return "book issued succcessfuylly";
    }
    function findBook(Request $request)
    {
        $request->validate(['ssid' => 'required']);
        $book = DB::table('ssid')
            ->where('ssid.ssid', $request->ssid)
            ->join('books', 'books.id', 'ssid.book_id')
            ->select('ssid.id', 'ssid.ssid', 'books.book_name', 'books.author_name')
            ->get();


        return view('Librarian.delete_books')->with(['book' => $book]);
    }
    function store(Request $request)
    {
        $request->validate([
            'book_name' => 'required',
            'book_author' => 'required',
            'ssid' => 'required',
            'edition' => 'required',
            'price' => 'required',
            'bpd' => 'required',
            'quantity' => 'required'
        ]);

        //check ssid 

        $ssids = [];
        for ($i = $request->ssid; $i <= $request->ssid + $request->quantity; $i++) {

            $ssid_found = DB::table('ssid')
                ->where('ssid', $i)
                ->first();


            if ($ssid_found != null) {
                array_push($ssids, $i);
            }
        }
        if (count($ssids) > 0) {
            return "these ssids are already uploaded " . json_encode($ssids);
        }
        $book_name = $request->book_name;
        $book_author = $request->book_author;
        $ssid = $request->ssid;
        $amount = $request->amount;
        $edition = $request->edition;
        $price = $request->price;
        $purchased_date = $request->bpd;
        $quantity = $request->quantity;

        $book_id =  book::insertGetId([
            'book_name' => $book_name,
            'author_name' => $book_author,
            'purchased_date' => $purchased_date
        ]);

        $edition_id =  DB::table('edition_info')
            ->insertGetId([
                'edition' => $edition,
                'book_id' => $book_id,
                'price' => $price,
                'total_quantity' => $quantity
            ]);

        for ($i = $ssid; $i < $ssid + $quantity; $i++) {
            DB::table('ssid')
                ->insert([
                    'book_id' => $book_id,
                    'ssid' => $i,
                    'edition_id' => $edition_id
                ]);
        }
        return "book inserted successfully";
    }
    function deleteBook(Request $request)
    {
        $request->validate(['ssid' => 'required']);
        $ssid = $request->ssid;

        $check_book =  DB::table('issue_books')
            ->where('ssid', $ssid)
            ->first();
        if ($check_book != null) {
            return "this book is issued ! cannot delete the book";
        }
        DB::table('ssid')
            ->where('ssid', $ssid)
            ->delete();
        return "book deleted successfully";
    }
}
