@extends('Librarian/layout/master')

@section('body')
@if(isset($error))

<div class="alert alert-danger">
    <ul class="list-unstyled">
        @foreach ($error->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>

@endif
    <form class="" action="{{ route('books.findBookToUpdate') }}" method="post">
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
            <form action="{{ Route('book.update') }}" method="post">
                @csrf
                <tr>
                    <th>ssid </th>
                </tr>
                <tr>
                    <td><input type="text" class="form-control" type="text" name="ssid"
                            value="{{ $row->ssid }}"></td>
                </tr>
                <tr>
                    <th>book_name </th>
                </tr>
                <tr>
                    <td> <input type="text" class="form-control" type="text" name="book_name"
                            value="{{ $row->book_name }}"></td>
                </tr>
                <tr>
                    <th>author name </th>
                </tr>
                <tr>
                    <td> <input type="text" class="form-control" type="text" name="author_name"
                            value="{{ $row->author_name }}"></td>
                </tr>
                <tr>
                    <th>edition</th>
                </tr>
                <tr>
                    <td> <input type="text" class="form-control" type="text" name="edition"
                            value="{{ $row->edition }}"></td>
                </tr>
                <tr>
                    <th>price</th>
                </tr>
                <tr>
                    <td> <input type="text" class="form-control" type="text" name="price"
                            value="{{ $row->price }}"></td>
                </tr>
                <tr>
                    <th>total amount</th>
                </tr>
                <tr>
                    <td> <input type="text" class="form-control" type="text" name="quantity"
                            value="{{ $row->total_quantity }}"></td>
                </tr>
                <tr>
                    <td> <input type="hidden" class="form-control" type="text" name="book_id"
                            value="{{ $row->book_id }}"></td>
                </tr>
                <tr>
                    <td><button name="btn_addData" class="form-control">Update Book</button></td>
                </tr>
            </form>
        </table>
    @endforeach
    <?php
}
?>
@endsection
