{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Report')

@section('content_header')
    <h1>Dashboard</h1>
@stop
@section('content')
<form class="" action="/client/campaigns/report" method="post">
      {{ csrf_field() }}
      <div class="row form-group">
      <div class="col-md-3">
        From : <input class="form-control" type="text" id="datepicker1" name="from" value="">
      </div>
      <div class="col-md-3">
         To : <input class="form-control" type="text" id="datepicker2" name="to" value="">
      </div>
    </div>

    <div class="row form-group">
      <div class="col-md-4">
        Dimention :
        <select class="form-control" class="" name="dimention">
          <option value="country">Country</option>
          <option value="budget">Bugget</option>
          <option value="category">Category</option>
          <option value="goal">Goal</option>
        </select>
      </div>
    </div>

    <div class="row form-group">
      <div class="col-md-4">
        Fields :
        <br>
        <input class="form-check-input" type="checkbox" name="filters[]" value="country">Country<br>
        <input class="form-check-input" type="checkbox" name="filters[]" value="budget">Budget<br>
        <input class="form-check-input" type="checkbox" name="filters[]" value="category">Category<br>
        <input class="form-check-input" type="checkbox" name="filters[]" value="goal">Goal<br>
      </div>
    </div>

    <div class="row form-group">
      <div class="col-md-2"></div>
      <div class="col-md-4">
        <button type="submit" class="btn btn-default">Submit</button>
      </div>
    </div>
</form>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
@stop
@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
      $( function() {
        $( "#datepicker1" ).datepicker();
        $( "#datepicker1" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
      } );
      $( function() {
        $( "#datepicker2" ).datepicker();
        $( "#datepicker2" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
      } );
    </script>
@stop
