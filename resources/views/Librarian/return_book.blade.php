@extends('Librarian/layout/master')

@section('body')
    <form class="" action="{{ Route('findStudentWithReturnBook') }}" method="post">
        @csrf
        <table class="table">

            <tr>
                <td><input type="text" class="form-control" placeholder="Enter book ssid" name="ssid"></td>
            </tr>

            <tr>
                <td><input type="submit" name="hey"></td>
            </tr>
            @error('roll_no')
                {{ $message }}
            @enderror
    </form>

    </table>

    <?php

if(isset($_POST['hey'])&&$_POST['ssid']!=null){
?>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="list-unstyled">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @foreach ($datas as $row)
        <table class="table table-bordered">
            <form action="/return_book" method="POST">
                @csrf
                <tr>
                    <th>roll_no </th>
                </tr>
                <tr>
                    <td> {{ $row->roll_no }} <input type="hidden" class="form-control" type="text" name="roll_no_two"
                            value="{{ $row->roll_no }}"></td>
                </tr>
                <tr>
                    <th>firs name</th>
                </tr>
                <tr>
                    <td>{{ $row->firstname }}</td>
                </tr>
                <tr>
                    <th>lasname </th>
                </tr>
                <tr>
                    <td>{{ $row->lastname }}</td>
                </tr>
                <tr>
                    <th>semester </th>
                </tr>
                <tr>
                    <td>{{ $row->semester }}</td>
                </tr>
                <tr>
                    <th>Book Name </th>
                </tr>
                <tr>
                    <td>{{ $row->book_name }}</td>
                </tr>
                <tr>
                    <th>Book Author </th>
                </tr>
                <tr>
                    <td>{{ $row->author_name }}</td>
                </tr>
                <tr>
                    <th>ssid </th>
                </tr>
                <tr>
                    <td>{{ $row->ssid }}</td>
                </tr>


                <tr>
                    <td><input class="form-control" value="{{$row->ssid}}" name="ssid" placeholder="enter book ssid" type="hidden"></td>
                </tr>
                <tr>
                    <td><button name="btn_addData" class="form-control">Return Book</button></td>
                </tr>
            </form>
        </table>
    @endforeach
    <?php
}
?>
@endsection
