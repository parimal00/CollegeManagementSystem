@extends('layout/master')

@section('body')


    <form class="" action="{{ route('roll_no') }}" method="post">
        @csrf
        <table class="table">
            plain_page blade
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
    @if ($scholarship == null || $scholarship->scholarship_amount == 0)
        @foreach ($datas as $row)
            {{ $row['lastname'] }}
            <table class="table table-bordered">
                <form action="submit" method="post">
                    @csrf
                    <tr>
                        <th>roll_no </th>
                    </tr>
                    <tr>
                        <td> {{ $row['roll_no'] }} <input type="hidden" class="form-control" type="text" name="roll_no"
                                value="{{ $row['roll_no'] }}"></td>
                    </tr>
                    <tr>
                        <th>first name</th>
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
                        <th> scholarship amount </th>
                    </tr>
                    @error('percentage')
                        {{ $message }}
                    @enderror

                    <tr>
                        <td><input class="form-control" name="percentage"placeholder="enter scholarship amount"
                                type="text"></td>
                    </tr>
                    <tr>
                        <td><button name="btn_addData" class="form-control">Add data in database</button></td>
                    </tr>
                </form>
            </table>
        @endforeach
    @elseif ($scholarship != null || $scholarship->scholarship_amount > 0)
        @foreach ($datas as $row)
            {{ $row['lastname'] }}
            <table class="table table-bordered">
                <form action="{{ route('scholarship.update') }}" method="post" >
                  @method('PUT')
                    @csrf
                    <tr>
                        <th>roll_no </th>
                    </tr>
                    <tr>
                        <td> {{ $row['roll_no'] }} <input type="hidden" class="form-control" type="text" name="roll_no"
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
                        <th> scholarship amount </th>
                    </tr>
                    @error('percentage')
                        {{ $message }}
                    @enderror

                    <tr>
                        <td><input class="form-control" value="{{ $scholarship->scholarship_amount }}"
                                name="percentage"placeholder="enter scholarship amount" type="text"></td>
                    </tr>
                    <tr>
                        <td><button name="btn_addData" class="form-control">Update Scholarship</button></td>
                    </tr>
                </form>
            </table>
        @endforeach
    @endif

    <?php
}
?>


@endsection
