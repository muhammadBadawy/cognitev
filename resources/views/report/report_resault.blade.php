{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>Welcome to this beautiful admin panel.</p>
    <div id="container" style="width: 500px; height: 400px;"></div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://cdn.anychart.com/releases/8.6.0/js/anychart-base.min.js"></script>
    <script>
    var data = anychart.data.set([
      @foreach($output_data as $key => $chunk)
      ["{{ $key }}",
      @foreach($chunk as $key_2 => $element)
        {{ $element }}
       @if (!($loop->last))
       ,
       @endif
      @endforeach
      ]
      @if (!($loop->last))
      ,
      @endif
      @endforeach
      ]);
      // map the data

      var seriesData_1 = data.mapAs({x: 0, value: 1, label: 0});
      var seriesData_2 = data.mapAs({x: 0, value: 2, label: 0});
      var seriesData_3 = data.mapAs({x: 0, value: 3, label: 0});
      var seriesData_4 = data.mapAs({x: 0, value: 4, label: 0});

      // create a chart
      chart = anychart.column();
      chart.title("Campaigns Statistics");
      // set the container element
      chart.container("container");
      // create series and set the data
      chart.column(seriesData_1);
      chart.column(seriesData_2);
      chart.column(seriesData_3);
      chart.column(seriesData_4);
      // chart.column(seriesData_2);
      var i=0;
      // create a loop

      chart.getSeriesAt(0).name("Country");
      chart.getSeriesAt(1).name("Budget");
      chart.getSeriesAt(2).name("Goal");
      chart.getSeriesAt(3).name("Category");

      chart.legend(true);
      chart.draw();
    </script>
@stop
