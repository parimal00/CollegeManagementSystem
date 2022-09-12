@extends('FeeLayout/master')

@section('body')
    <h2>Current Bus fee</h2>
    <div>
        <h1>{{ $current_bus_fee->amount }} </h1> <br>
        <p>Date: {{ $current_bus_fee->date }}</p>
    </div>
    <form action="{{ Route('bus_fee.store') }}" method="POST">
        @csrf
        <input name="amount" type="text" placeholder="Add latest buss fee">
        <button>Submit</button>
    </form>
@endsection
