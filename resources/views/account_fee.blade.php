@extends('FeeLayout/master')

@section('body')
<h2>Current semester fee</h2>
<div>
    <h1>{{ $current_semester_fee->amount }} </h1> <br>
    <p>Date: {{ $current_semester_fee->date }}</p>
</div>
<form action="{{Route('account_fee.store')}}" method="POST">
    @csrf
    <input type="text" name="amount" placeholder="enter account fee">
    <button>Submit</button>
</form>

@endsection