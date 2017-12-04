@extends('layouts.dashboard')

@section('dashboard-content')
    {!! Form::open(['url' => isset($user) ? 'users/'.$user->id : 'users', 'method' => isset($user) ? 'PUT' : 'POST', 'class' => 'form-horizontal']) !!}
    <fieldset>
        <div class="form-group {{$errors->has('name') ? 'has-error' : '' }}">
            <label for="select" class="col-lg-2 control-label">@lang('fields.name')</label>
            <div class="col-lg-10">
                {!! Form::text('name', isset($user) ? $user->name : null, ['class' => 'form-control']) !!}
                @if($errors->has('name'))
                    <p class="text-danger">{{$errors->first('name')}}</p>
                @endif
            </div>
        </div>
        <div class="form-group {{$errors->has('email') ? 'has-error' : '' }}">
            <label for="select" class="col-lg-2 control-label">@lang('fields.email')</label>
            <div class="col-lg-10">
                {!! Form::email('email', isset($user) ? $user->email : null, ['class' => 'form-control']) !!}
                @if($errors->has('email'))
                    <p class="text-danger">{{$errors->first('email')}}</p>
                @endif
            </div>
        </div>
        <div class="form-group {{$errors->has('is_admin') ? 'has-error' : '' }}">
            <label for="select" class="col-lg-2 control-label">{{trans_choice('fields.administrators', 1)}}</label>
            <div class="col-lg-10">
                <input type="checkbox" name="is_admin"
                       class="switcher" {{ isset($user) && $user->is_admin ? 'checked': ''}}>
                @if($errors->has('is_admin'))
                    <p class="text-danger">{{$errors->first('is_admin')}}</p>
                @endif
            </div>
        </div>
        <div class="form-group text-center">
            <a href="{{url('home')}}" class="btn btn-default">@lang('fields.cancel')</a>
            <button type="submit" class="btn btn-primary">@lang('fields.submit')</button>
        </div>
    </fieldset>
    {!! Form::close() !!}
    @if(isset($user))
        <hr>
        {!! Form::open(['url' => 'password/email']) !!}
        {!! Form::hidden('email', $user->email) !!}
        <button type="submit" class="btn btn-default pull-right">@lang('fields.reset') @lang('fields.password')</button>
        {!! Form::close() !!}
    @endif
@stop