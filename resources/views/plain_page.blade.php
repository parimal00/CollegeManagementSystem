
@extends('layout/master')

@section('body')



<form class="" action="{{route('roll_no')}}" method="post">
 @csrf
<table class ="table">
plain_page blade
<tr>
  <td><input type="text" class ="form-control"placeholder="Enter roll no" name="roll_no"></td>
</tr>

<tr>
  <td><input type="submit" name="hey"></td>
</tr>
@error('roll_no') {{$message}} @enderror
</form>

</table>

<?php

if(isset($_POST['hey'])&&$_POST['roll_no']!=null){
?>
  @foreach($datas as $row)
  {{$row['lastname']}}
  <table class="table table-bordered">
   <form action="submit" method = "post">
    @csrf
    <tr>
      <th>roll_no </th>
    </tr>
    <tr>
      <td><input class ="form-control"type="text" name="roll_no" value ="{{$row['roll_no']}}"></td>
    </tr>
    <tr>
      <th>firs name</th>
    </tr>
    <tr>
      <td><input class ="form-control"type="text" name="firstname"value ="{{$row['firstname']}}"></td>
    </tr>
    <tr>
      <th>lasname  </th>
    </tr>
    <tr>
      <td><input class ="form-control"type="text"name="lastname"value ="{{$row['lastname']}}"></td>
    </tr>
    <tr>
      <th>semester </th>
    </tr>
    <tr>
      <td><input class ="form-control" name="semester"type="text"value ="{{$row['semester']}}"></td>
    </tr>
    <tr>
      <th> scholarship percentage </th>
    </tr>
    @error('percentage') {{$message}} @enderror

    <tr>
      <td><input class ="form-control"name="percentage"placeholder="enter scholarship percentage" type="text"></td>
    </tr>
    <tr>
      <td><button name="btn_addData" class="form-control">Add data in database</button></td>
    </tr>
  </form>
  </table>
  @endforeach
<?php
}
?>


@endsection
