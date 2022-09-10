@extends('FeeLayout/master')

@section('body')
<form action="{{Route('library_penalty.store')}}" method="POST">
    @csrf
    <input name="lib_penalty_amount" type="text" placeholder="enter library penalty">
    <button>Submit</button>
</form>

@endsection