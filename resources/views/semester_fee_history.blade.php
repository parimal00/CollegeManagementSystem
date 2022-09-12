@extends('FeeLayout/master')

@section('body')
    <h1>Semester Fee History</h1>
    <table class="table">
        <tr>
            <th>
                Fee Amount
            </th>

            <th>
                Date
            </th>
        </tr>
        @foreach ($semester_fee_history as $semester_fee)
            <tr>
                <td>
                    {{ $semester_fee->amount }}
                </td>

                <td>
                    {{ $semester_fee->date }}
                </td>
            </tr>
        @endforeach
    </table>
@endsection
