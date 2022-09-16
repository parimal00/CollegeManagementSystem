@extends('FeeLayout/master')

@section('body')
    @if (Session::has('success'))
        <script>
            toastr.success('{{ session('success') }}')
        </script>
    @endif
    <h2>Current semester fee</h2>
    <div>
        @if ($current_semester_fee != null)
            <h1>{{ $current_semester_fee->amount }} </h1> <br>
            <p>Date: {{ $current_semester_fee->date }}</p>
        @else
            <h1>No semester fee Allocated</h1>
        @endif
    </div>
    <form action="{{ Route('account_fee.store') }}" method="POST">
        @csrf
        <input type="text" name="amount" placeholder="enter account fee">
        <button>Submit</button>
    </form>
@endsection
