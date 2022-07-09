<?php

use App\Http\Controllers\FeeController;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Test;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//stdent

Route::view('my_issued_books',[StudentController::class,'my_issued_books'])->middleware('check_student');

Route::view('student_login','student_login');
Route::post('student_login',[StudentController::class,'login']);

//admin 
Route::group(['middleware' => ['check_admin']], function () {

    Route::get('bus_fee', [FeeController::class, 'bus_fee_index'])->name('bus_fee.index');

    Route::get('allStudents', [FeeController::class, 'allStudent']);

    Route::get('approve/{roll_no}', [FeeController::class, 'approve']);

    Route::post('bus_fee', [FeeController::class, 'bus_fee_store'])->name('bus_fee.store');

    Route::get('account_fee', [FeeController::class, 'account_fee_index'])->name('account_fee.index');

    Route::post('account_fee', [FeeController::class, 'account_fee_store'])->name('account_fee.store');

    Route::view('penalty', 'Penalty');

    Route::post('find_student_for_penalty', [FeeController::class, 'find_student_for_penalty'])->name('find_student_for_penalty');

    Route::post('storePenalty', [FeeController::class, 'storePenalty'])->name('penalty.store');

    Route::get('admin_logout', function () {
        session()->pull('admin');
        session()->flush();
        return redirect('admin_login');
    });
});
Route::post('admin_login', [FeeController::class, 'login']);

Route::view('admin_login', 'adminlogin');

//
/// librarian

Route::post('librarian_login', [BookController::class, 'login']);
Route::get('librarian_login', function () {
    return view('Librarian.login');
});

Route::group(['middleware' => 'librarian'], function () {

    Route::get('librarian/logout', function () {
        session()->pull('librarian');
        session()->flush();
        return redirect('librarian_login');
    });
    Route::get('return_book', function () {
        return view('Librarian.return_book');
    });

    Route::post('findStudentWithBook', [BookController::class, 'findStudentWithReturnBook'])->name('findStudentWithReturnBook');
    Route::post('return_book', [BookController::class, 'returnBook'])->name('return_book');
    Route::get('update_book', function () {
        return view('Librarian.update_book');
    });

    Route::post('findBookToUpdate', [BookController::class, 'findBookToUpdate'])->name('books.findBookToUpdate');
    Route::post('book/update', [BookController::class, 'updateBook'])->name('book.update');

    Route::get('issue_books', function () {
        return view('Librarian.issue_books');
    });
    Route::post('issue_book', [BookController::class, 'issueBook'])->name('issue_book');

    Route::post('findStudent', [BookController::class, 'findStudent'])->name('findStudent');
    Route::get('books', function () {
        return view('Librarian.books');
    });
    Route::get('deleteBooks', function () {
        return view('Librarian.delete_books');
    });

    Route::post('findBook', [BookController::class, 'findBook'])->name('books.findBook');
    Route::post('books', [BookController::class, 'store']);
    Route::post('deleteBook', [BookController::class, 'deleteBook'])->name('book.delete');
    //
});
Route::get('and', 'Test@index');

//Route::get('/{name}','Hellocontroller@index')->where(["name"=>"[0-9]+"]);

//use PhpParser\Node\Expr\FuncCall;

//Route::get('/','secondController@index');


//////////////////////////////////////////////////////////////
//////  Student Scholarship Add in the database 


Route::get('lol', function () {
    //return view('accountantlogin');

    if (session()->has('accountant')) {
        return view('plain_page');
    } else {
        return view('accountantlogin');
    }
});
Route::post('submit', 'HelloController@scholarship_add');

Route::post('lol', 'HelloController@getData')->name('roll_no');

////////////////////////////////////////////////////////////
///// Add bus fee in database and update the bus fee



Route::post('bus_manage', 'HelloController@getData_bus')->name('roll_no_bus');

Route::get('bus_manage', function () {
    if (session()->has('accountant')) {


        return view('add_account');
    } else {
        return view('accountantlogin');
    }
});

Route::post('submit_bus_fee_info', 'HelloController@busfee_add');





///////////////////////////////////////////////////////////////////
////////View Student Information

Route::group(['middleware' => ['hey']], function () {
    Route::get('welcome', function () {
        echo "welcome";
    });
});

Route::get('student_info', 'HelloController@getInfo');




/////////////////////////////////////////////////////////////////
/////////Get Amount

Route::get('get_amount', function () {
    if (session()->has('accountant')) {
        return view('get_amount');
    }
    return view('accountantlogin');
});


Route::post('student_info', 'HelloController@getInfo_amount')->name('roll_get_amount');

Route::post('submit_amount', 'HelloController@submit_amount');


//////search_student

Route::post('layout/master', 'HelloController@search_student')->name('search');

/////////////////////////////////////
///////////Edit Student account information

Route::get('edit_student_info', 'HelloController@edit_student_info');

Route::post('edit_student_info', 'HelloController@update')->name('edit_info');


////////////////////////////////////////////////////////////
///////////////////Update all the information

Route::get('update', function () {
    if (session()->has('accountant')) {
        return view('updateInfo');
    } else {
        return view('accountantlogin');
    }
});

Route::post('update', 'HelloController@update_all_info')->name('update_all_info');

///////////////////////////////////////////////////////////////////
///////////////////////View students with due balance

Route::get('view_due', 'HelloController@stu_due_get_info');


/////////////////////////////////////////////////////////////////
//////////////////////View students with scholarships

Route::get('view_scholarship', 'HelloController@stu_scho_get_info');


Route::get('admin/lol', function () {
    return view('admin');
});
////////////////payment history//////

Route::get('payment_history', 'HelloController@payment_history');

Route::post('roll_no_payment_history', 'HelloController@roll_no_payment_history')->name('roll_no_payment_history');

/*


Route::post('add_account','Hellocontroller@getStudentInfo')->name('roll_no');
Route::get('insert_stu_data',function(){
    return view('insert_student_data');
});

//Route::post('lol','Hellocontroller@scholarship_add')->name('scholarship_add');

Route::get('student_info',function(){
return view('student_info');
});




*/

Route::get('accountantlogin', function () {
    return view('accountantlogin');
});

Route::post('login_accountant', 'Test@index');

//Route::post('login_accountant',[hellocontroller::class,'accountant_login']);

// Route::post('login_accountant',function(){
//     echo "jack is sexy";
// });

Route::get('logout', function () {
    session()->pull('accountant');
    return view('accountantlogin');
});
