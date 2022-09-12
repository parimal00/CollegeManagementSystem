@extends('FeeLayout/master')

@section('body')
<h2>Current library penalty</h2>
<div>
    <h1>{{ $current_library_penalty->amount }} </h1> <br>
    <p>Date: {{ $current_library_penalty->date }}</p>
</div>
<form action="{{Route('library_penalty.store')}}" method="POST">
    @csrf
    <input name="lib_penalty_amount" type="text" placeholder="enter library penalty">
    <button>Submit</button>
</form>

@endsection