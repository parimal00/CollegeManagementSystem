@extends('Librarian/layout/master')

@section('body')
@if ($errors->any())
<div class="alert alert-danger">
    <ul class="list-unstyled">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
    <form class="" action="http://localhost:8000/books" method="post" encType="multipart/form-data" class="col-lg-6">
        @csrf
        <table class="table">
            <input type="hidden" name="_csrf" value="123233JFDSJFK" />

            <tr>
                <td><input value="{{old('book_name')}}" type="text" class="form-control" placeholder="Books Name" name="book_name"></td>
            </tr>
            <tr>
                <td><input type="text" class="form-control" placeholder="Enter starting ssid"value="{{old('ssid')}}" name="ssid"></td>
            </tr>
            <tr>
                <td><input type="text" class="form-control" placeholder="Books Author Name"value="{{old('book_author')}}"name="book_author"></td>
            </tr>
            <tr>
                <td><input type="text" class="form-control" placeholder="Enter books edition" value="{{old('edition')}}"name="edition"></td>
            </tr>

            <tr>
                <td><input type="text" class="form-control" placeholder="Books Price"value="{{old('price')}}"name="price"></td>
            </tr>
            <tr>
                <td><input type="text" class="form-control" placeholder="Books Purchase date"value="{{old('bpd')}}"name="bpd"></td>
            </tr>
            <tr>
                <td><input type="text" class="form-control" placeholder="Books Quantity for this edition"value="{{old('quantity')}}"name="quantity">
                </td>
            </tr>

            <tr>
                <td><input type="submit" class="form-control" value="Insert Books"name="submit1"></td>
            </tr>


        </table>
    </form>
@endsection
