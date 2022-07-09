@extends('Librarian/layout/master')

@section('body')
    <form class="" action="{{ route('books.findBook') }}" method="post">
        @csrf
        <table class="table">
            plain_page blade
            <tr>
                <td><input type="text" class="form-control" placeholder="Enter book ssid" name="ssid"></td>
            </tr>

            <tr>
                <td><input type="submit" name="hey"></td>
            </tr>
            @error('ssid')
                {{ $message }}
            @enderror
    </form>

    </table>

    <?php

if(isset($_POST['hey'])&&$_POST['ssid']!=null){
?>
    @if (count($book) == 0)
        <div>no book found</div>
    @endif
    @foreach ($book as $row)
        <table class="table table-bordered">
            <form action="{{ Route('book.delete') }}" method="post">
                @csrf
                <tr>
                    <th>ssid </th>
                </tr>
                <tr>
                    <td> {{ $row->ssid }} <input type="hidden" class="form-control" type="text" name="ssid"
                            value="{{ $row->ssid }}"></td>
                </tr>
                <tr>
                    <th>book_name </th>
                </tr>
                <tr>
                    <td> {{ $row->book_name }} <input type="hidden" class="form-control" type="text" name="book_name"
                            value="{{ $row->book_name }}"></td>
                </tr>
                <tr>
                    <th>author name </th>
                </tr>
                <tr>
                    <td> {{ $row->author_name }} <input type="hidden" class="form-control" type="text" name="roll_no"
                            value="{{ $row->author_name }}"></td>
                </tr>
                <tr>
                    <td><button name="btn_addData" class="form-control">Delete this book</button></td>
                </tr>
            </form>
        </table>
    @endforeach
    <?php
}
?>
@endsection
