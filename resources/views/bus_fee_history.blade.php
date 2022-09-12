@extends('FeeLayout/master')

@section('body')
    <h1>Bus Fee History</h1>
    <table class="table">
        <tr>
            <th>
                Fee Amount
            </th>

            <th>
                Date
            </th>
        </tr>
        @foreach ($bus_fee_history as $bus_fee)
            <tr>
                <td>
                    {{ $bus_fee->amount }}
                </td>

                <td>
                    {{ $bus_fee->date }}
                </td>
            </tr>
        @endforeach
    </table>
@endsection
