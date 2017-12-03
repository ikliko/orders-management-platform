@extends('layouts.dashboard')

@section('dashboard-content')
    {!! Form::open(['url' => isset($user) ? 'users/'.$user->id : 'users', 'method' => isset($user) ? 'PUT' : 'POST', 'class' => 'form-horizontal']) !!}
    <fieldset>
        <div class="form-group {{$errors->has('name') ? 'has-error' : '' }}">
            <label for="select" class="col-lg-2 control-label">Name</label>
            <div class="col-lg-10">
                {!! Form::text('name', isset($user) ? $user->name : null, ['class' => 'form-control', 'placeholder' => 'Name']) !!}
                @if($errors->has('name'))
                    <p class="text-danger">{{$errors->first('name')}}</p>
                @endif
            </div>
        </div>
        <div class="form-group {{$errors->has('email') ? 'has-error' : '' }}">
            <label for="select" class="col-lg-2 control-label">Email</label>
            <div class="col-lg-10">
                {!! Form::email('email', isset($user) ? $user->email : null, ['class' => 'form-control', 'placeholder' => 'Email']) !!}
                @if($errors->has('email'))
                    <p class="text-danger">{{$errors->first('email')}}</p>
                @endif
            </div>
        </div>
        <div class="form-group text-center">
            <a href="{{url('home')}}" class="btn btn-default">Cancel</a>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </fieldset>
    {!! Form::close() !!}
    @if(isset($user))
        <hr>
        {!! Form::open(['url' => 'password/email']) !!}
        {!! Form::hidden('email', $user->email) !!}
        <button type="submit" class="btn btn-default pull-right">Reset password</button>
        {!! Form::close() !!}
    @endif
@stop