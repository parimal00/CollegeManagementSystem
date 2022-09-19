@extends('layout/master')

@section('body')
    @error('roll_no')
        {{ $message }}
    @enderror


    <form class="" action="{{ route('roll_no_bus') }}" method="post">
        @csrf
        <table class="table">

            <tr>
               
                <td><input type="text" class="form-control" placeholder="Enter roll no" name="roll_no"></td>

            </tr>
            <tr>
                <td><input type="submit" name="hey"></td>
            </tr>
    </form>

    </table>
    <?php

if(isset($_POST['hey'])&&$_POST['roll_no']!=null){
?>
    @foreach ($datas as $row)
        
        <table class="table table-bordered">
            <form action="submit_bus_fee_info" method="post">
                @csrf
                <tr>
                    <td>Roll No</td>
                </tr>
                <tr>
                    <td> {{ $row['roll_no'] }}<input type="hidden" class="form-control" type="text" name="roll_no"
                            value="{{ $row['roll_no'] }}"></td>
                </tr>
                <tr>
                    <td>Firstname</td>
                </tr>
                <tr>
                    <td>{{ $row['firstname'] }}</td>
                </tr>
                <tr>
                <tr>
                    <td>Lastname</td>
                </tr>
                <td>{{ $row['lastname'] }}</td>
                </tr>
                <tr>
                    <td>Semester</td>
                </tr>
                <tr>
                    <td>{{ $row['semester'] }}</td>
                </tr>
                <tr>
                    <td>Fee amount</td>
                </tr>
                <tr>
                    <td>{{ $bus_fee }}<input class="form-control" name="bus_fee"placeholder="enter  bus_fee"
                            value="{{ $bus_fee }}" type="hidden"></td>
                </tr>
                <tr>
                    <td><input type="hidden" class="form-control" name="fee_id" placeholder="enter  bus_fee"
                            value="{{ $fee_id }}" type="text"></td>
                </tr>
                <tr>
                    <td><button name="btn_addData" class="form-control">Add data in database</button></td>
                </tr>
            </form>
        </table>
    @endforeach

    <?php
}
?>
    <?php 
if(isset($_POSTS['btn_addData'])){
?>
    {!! $data !!}}
    <?php 
}
?>
@endsection
