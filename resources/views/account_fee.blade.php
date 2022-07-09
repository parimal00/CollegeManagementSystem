@extends('FeeLayout/master')

@section('body')
<form action="{{Route('account_fee.store')}}" method="POST">
    @csrf
    <input type="text" name="amount" placeholder="enter account fee">
    <button>Submit</button>
</form>

@endsection