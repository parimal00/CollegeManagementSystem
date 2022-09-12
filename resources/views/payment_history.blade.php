@extends('layout/master')

@section('body')
    payment_history blade, <br>
    roll_no_payment_history function,

    get_amount function, submit_amount function
    calculation of fees from others tables is not included (getInfo_amount)

    <form class="" action="{{ route('roll_no_payment_history') }}" method="post">
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




    <table class="table table-bordered">
        <form action="submit_amount" method="post">
            @csrf
            @foreach ($datas as $data)
                @foreach ($data as $dat)
                    @if ($loop->index == 0)
                        <tr>
                            <th>roll_no</th>
                            <th>semester</th>
                            <th>amount</th>
                            <th>date of payment</th>
                        </tr>
                        @if ($dat != null)
                            @foreach ($dat as $da)
                                <tr>
                                    <td>{{ $da->roll_no }}</td>
                                    <td>{{ $da->semester }}</td>
                                    <td>{{ $da->amount }}</td>
                                    <td>{{ $da->date_of_payment }}</td>
                                </tr>
                            @endforeach
                        @endif
                        @if ($dat == null)
                            waaaaaa
                        @endif
                        @if (count($dat) == 0)
                            @foreach ($dat as $da)
                                <tr>
                                    <td>{{ $da->roll_no }}</td>
                                    <td>{{ $da->semester }}</td>
                                    <td> 0</td>
                                    <td>null</td>
                                </tr>
                            @endforeach
                        @endif
                    @endif
                    @if ($loop->index == 1)
                        <tr>
                            <th>roll_no</th>
                            <th>semester</th>
                            <th>amount</th>
                            <th>fee type</th>
                            <th>date</th>
                        </tr>
                        @foreach ($dat as $da)
                            <tr>
                                <td>{{ $da->roll_no }}</td>
                                <td>{{ $da->semester }}</td>
                                <td>{{ $da->amount }}</td>
                                <td>{{ $da->fee_type }}</td>
                            </tr>
                        @endforeach
                    @endif
                @endforeach
            @endforeach
        </form>
    </table>

    <?php
}
?>
@endsection
