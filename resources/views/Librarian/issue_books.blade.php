@extends('Librarian/layout/master')

@section('body')
    <form class="" action="{{ Route('findStudent') }}" method="post">
        @csrf
        <table class="table">
           
            <tr>
                <td><input type="text" class="form-control" placeholder="Enter roll no" name="roll_no"></td>
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

if(isset($_POST['hey'])&&$_POST['roll_no']!=null){
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
            <form action="/issue_book" method="POST">
                @csrf
                <tr>
                    <th>roll_no </th>
                </tr>
                <tr>
                    <td> {{ $row['roll_no'] }} <input type="hidden" class="form-control" type="text" name="roll_no_two"
                            value="{{ $row['roll_no'] }}"></td>
                </tr>
                <tr>
                    <th>firs name</th>
                </tr>
                <tr>
                    <td>{{ $row['firstname'] }}</td>
                </tr>
                <tr>
                    <th>lasname </th>
                </tr>
                <tr>
                    <td>{{ $row['lastname'] }}</td>
                </tr>
                <tr>
                    <th>semester </th>
                </tr>
                <tr>
                    <td>{{ $row['semester'] }}</td>
                </tr>
              

                <tr>
                    <td><input class="form-control" name="ssid"placeholder="enter book ssid" type="text"></td>
                </tr>
                <tr>
                    <td><button name="btn_addData" class="form-control">Issue Book</button></td>
                </tr>
            </form>
        </table>
    @endforeach
    <?php
}
?>
@endsection
