@extends('layouts.master')

@section('head')
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{url('css/app.css')}}">
    <title>{{env('APP_NAME')}}</title>
@stop

@section('body')
    @include('partials.headers.default')

    <div class="container">
        @yield('content')
    </div>
@stop

@section('scripts')
    <script src="{{url('js/app.js')}}"></script>
@stop