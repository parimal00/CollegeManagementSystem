@extends('FeeLayout/master')

@section('body')
    <form class="" action="{{ route('find_student_for_penalty') }}" method="post">
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
    @foreach ($datas as $row)
        {{ $row['lastname'] }}
        <table class="table table-bordered">
            <form action="{{ Route('penalty.store') }}" method="post">
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
                    <td>{{ $row['semester'] }} <input type="hidden" name="semester" value="{{ $row['semester'] }}">
                    </td>
                </tr>
                <tr>
                    <th> penalty amount </th>
                </tr>
                @error('percentage')
                    {{ $message }}
                @enderror

                <tr>
                    <td><input class="form-control" placeholder="enter penalty amount" name="penalty_amount" type="text">
                    </td>
                </tr>
                <tr>
                    <th> Reason of penalty </th>
                </tr>
                <tr>
                    <td><input class="form-control" placeholder="reason of penalty" name="penalty_type" type="text"></td>
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
@endsection
