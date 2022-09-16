@extends('FeeLayout/master')

@section('body')
    @if (Session::has('success'))
        <script>
            toastr.success('{{ session('success') }}')
        </script>
    @endif
    <h2>Current Bus fee</h2>
    <div>
        @if ($current_bus_fee != null)
            <h1>{{ $current_bus_fee->amount }} </h1> <br>
            <p>Date: {{ $current_bus_fee->date }}</p>
        @else
            <h1>No bus fee Allocated</h1>
        @endif
    </div>
    <form action="{{ Route('bus_fee.store') }}" method="POST">
        @csrf
        <input name="amount" type="text" placeholder="Add latest buss fee">
        <button>Submit</button>
    </form>
@endsection
