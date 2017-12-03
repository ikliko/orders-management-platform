@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">Settings</div>
                    <div class="panel-body rm-pa">
                        <div class="list-group rm-mb">
                            @include('menus.sidebar-settings')
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        @yield('dashboard-content')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
