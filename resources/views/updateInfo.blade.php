@extends('layout/master')

@section('body')
    <form action="{{ route('update_all_info') }}" method="POST">
        @csrf
        <table class="table">
            <input type="submit" value="Upgrade Students">
        </table>
    </form>
@endsection
