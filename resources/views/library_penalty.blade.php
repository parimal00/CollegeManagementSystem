@extends('FeeLayout/master')

@section('body')
    @if (Session::has('success'))
        <script>
            toastr.success('{{ session('success') }}')
        </script>
    @endif
    <h2>Current library penalty</h2>
    <div>
        @if ($current_library_penalty != null)
            <h1>{{ $current_library_penalty->amount }} </h1> <br>
            <p>Date: {{ $current_library_penalty->date }}</p>
        @else
            <h1>No Library Penalty Allocated</h1>
        @endif
    </div>
    <form action="{{ Route('library_penalty.store') }}" method="POST">
        @csrf
        <input name="lib_penalty_amount" type="text" placeholder="enter library penalty">
        <button>Submit</button>
    </form>
@endsection
