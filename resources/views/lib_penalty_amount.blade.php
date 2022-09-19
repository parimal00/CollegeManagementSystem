@extends('Librarian/layout/master')

@section('body')
    <form class="" action="get_lib_penalty_amount" method="post">
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
            <form action="/submit_penalty_amount" method="POST">
                @csrf
                <tr>
                    <th>roll_no </th>
                </tr>
                <tr>
                    <td> {{ $row->roll_no }} <input type="hidden" class="form-control" type="text" name="roll_no"
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
                    <input type="hidden" value="{{$row->ssid}}" name="ssid">
                    <td>{{ $row->ssid }}</td>
                </tr>


                <tr>
                    <td><input class="form-control" value="{{ $row->ssid }}" name="ssid"
                            placeholder="enter book ssid" type="hidden"></td>
                </tr>
                <tr>
                    <th>Penalty Amount</th>
                </tr>
                <tr>
                    <td>{{ $penalty->amount }}</td>
                    <td> <input type="hidden" value=" {{ $penalty->amount }}" name="penalty_amount"></td>
                </tr>
                <tr>
                    <td><button name="btn_addData" class="form-control">Accept payment</button></td>
                </tr>
            </form>
        </table>
    @endforeach
    <?php
}
?>
@endsection
