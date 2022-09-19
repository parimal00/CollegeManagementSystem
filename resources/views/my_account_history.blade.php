@extends('Student/layout/master')

@section('body')
   

    {{-- <form class="" action="{{ route('roll_no_payment_history') }}" method="post">
        @csrf
        <table class="table">

            <tr>
                <td><input type="text" class="form-control" placeholder="Enter roll no" name="roll_no"></td>
            </tr>

            <tr>
                <td><input type="submit" name="hey"></td>
            </tr>

    </form> --}}

    </table>

  






    <table class="table table-bordered">
        <form action="submit_amount" method="post">
            @csrf
            @foreach ($datas as $data)
                @foreach ($data as $dat)
                    @if ($loop->index == 0)
                        <tr>
                            <th>roll_no</th>
                            <th>semester</th>
                            <th>amount</th>
                            <th>date of payment</th>
                        </tr>
                    

                        @if ($dat != null)

                            @foreach ($dat as $da)
                          
                                <tr>
                                    <td>{{ $da->roll_no }}</td>
                                    <td>{{ $da->semester }}</td>
                                    <td>{{ $da->amount }}</td>
                                    <td>{{ $da->date_of_payment }}</td>
                                </tr>
                            @endforeach
                        @else
                        <tr>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                        @endif
                        @if (count($dat) == 0)
                            @foreach ($dat as $da)
                                <tr>
                                    <td>{{ $da->roll_no }}</td>
                                    <td>{{ $da->semester }}</td>
                                    <td> 0</td>
                                    <td>null</td>
                                </tr>
                            @endforeach
                        @endif
                    @endif
                    @if ($loop->index == 1)
                        <tr>
                            <th>roll_no</th>
                            <th>semester</th>
                            <th>amount</th>
                            <th>fee type</th>
                           
                        </tr>

                        @foreach ($dat as $da)
                            <tr>
                                <td>{{ $da->roll_no }}</td>
                                <td>{{ $da->semester }}</td>
                                <td>{{ $da->amount }}</td>
                                <td>{{ $da->fee_type }}</td>

                            </tr>
                        @endforeach
                        @foreach ($scholarship as $s)
                            @if ($s->scholarship_sem == $da->semester)
                                <tr>
                                    <td>{{ $da->roll_no }}</td>
                                    <td>{{$da->semester}}</td>
                                    <td>{{$s->scholarship_amount}}</td>
                                    <td>scholarship</td>

                                </tr>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            @endforeach
        </form>
    </table>


@endsection
