@extends('layout/master')

@section('body')

    get_amount_blade
    get_amount function, submit_amount function
    calculation of fees from others tables is not included (getInfo_amount)

    <form class="" action="{{ route('roll_get_amount') }}" method="post">
        @csrf
        <table class="table">

            <tr>
                <td><input type="text" class="form-control" placeholder="Enter roll no" name="bname"></td>
            </tr>

            <tr>
                <td><input type="submit" name="hey"></td>
            </tr>

    </form>

    </table>

    <?php

if(isset($_POST['hey'])&&$_POST['bname']!=null){
?>




            <table class="table table-bordered">
                <form action="submit_amount" method="post">
                    @csrf
                    <tr>
                        <th>Amount from {{ $data['semester'] }} semester:</td>
                    </tr>
                    <tr>
                        <td>{{ $data['ts_total'] }}</td>
                    </tr>
                    <tr>
                        <th>Dues from previous semester</td>
                    </tr>
                    <tr>

                        <td>{{ $data['total'] - $data['ts_total'] - $data['total_previous_payment'] }}</td>
                    </tr>
                    <tr>
                        <th>dues from {{ $data['semester'] }} semester</td>
                    </tr>
                    <tr>
                        <td>{{ $data['ts_total'] - $data['ts_payment'] }}</td>
                    </tr>
                    <tr>
                        <th>Total dues</td>
                    </tr>
                    <tr>
                        <td>{{ $data['total'] - $data['ts_payment'] - $data['total_previous_payment'] }}</td>
                    </tr>

                    <tr>
                        <th>Amount obtained </td>
                    </tr>
                    <tr>
                        <td><input class="form-control" name="obtained_amount" placeholder="enter your amount" type="text">
                        </td>
                        <td><input type="hidden" class="form-control" name="roll_no" value="{{ $data['roll_no'] }}"
                                placeholder="enter your amount" type="text"></td>
                    </tr>
                    <tr>
                        <td><button name="btn_addData" class="form-control">Add data in database</button></td>
                    </tr>
                </form>
            </table>
    

    <?php
}
?>


@endsection
