@extends('FeeLayout/master')

@section('body')
    <form class="" action="{{ route('roll_no') }}" method="post">
        @csrf
        <table class="table">
            plain_page blade

            <tr>
                <th>roll_no</th>
                <th>firstname </th>
                <th>lastname </th>
                <th>username </th>
                <th>email</th>
                <th>semester</th>

                <th>status</th>
                <th>Approve</th>

            </tr>
            @foreach ($students as $student)
                <tr>
                    <th>{{ $student->roll_no }}</th>
                    <th>{{ $student->firstname }}</th>
                    <th>{{ $student->lastname }} </th>
                    <th>{{ $student->username }} </th>
                    <th>{{ $student->email }}</th>
                    <th>{{ $student->semester }}</th>

                    <th>{{ $student->status }}</th>
                    <th> <a href="/approve/{{$student->roll_no}}"> Approve</a></th>

                </tr>
            @endforeach
    </form>

    </table>
@endsection
