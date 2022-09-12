@extends('FeeLayout/master')

@section('body')
    <h1>Library Penalty History</h1>
    <table class="table">
        <tr>
            <th>
                Fee Amount
            </th>

            <th>
                Date
            </th>
        </tr>
        @foreach ($library_penalty_history as $library_penalty)
            <tr>
                <td>
                    {{ $library_penalty->amount }}
                </td>

                <td>
                    {{ $library_penalty->date }}
                </td>
            </tr>
        @endforeach
    </table>
@endsection
