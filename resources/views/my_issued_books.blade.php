@extends('Student/layout/master')

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
            <tr>
                <th>
                    ssid
                </th>
                <th>
                    book name
                </th>
                <th>
                    author name
                </th>
                <th>
                    edition
                </th>
                <th>
                    book issued date
                </th>
            </tr>
            @foreach($my_issued_books as $my_issued_book)
            <tr>
                <td>{{$my_issued_book->ssid}}</td>
                <td>{{$my_issued_book->book_name}}</td>
                <td>{{$my_issued_book->author_name}}</td>
                <td>{{$my_issued_book->edition}}</td>
                <td>{{$my_issued_book->books_issue_date}}</td>
            </tr>

            @endforeach
        </table>
    </form>
@endsection
