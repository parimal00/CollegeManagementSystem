@extends('FeeLayout/master')

@section('body')
<form action="{{Route('bus_fee.store')}}" method="POST">
    @csrf
    <input name="amount" type="text" placeholder="enter bus fee">
    <button>Submit</button>
</form>

@endsection