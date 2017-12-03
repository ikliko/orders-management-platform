@extends('layouts.dashboard-settings')

@section('dashboard-content')
    {!! Form::open(['url' => url('settings/security'), 'class' => 'form-horizontal']) !!}
    <fieldset>
        <div class="form-group {{$errors->has('old_password') ? 'has-error' : '' }}">
            <label for="old_password" class="col-lg-2 control-label">@lang('fields.old') @lang('fields.password')</label>
            <div class="col-lg-10">
                {!! Form::password('old_password', ['class' => 'form-control', 'id' => 'old_password', 'placeholder' => 'Name']) !!}
                @if($errors->has('old_password'))
                    <p class="text-danger">{{$errors->first('old_password')}}</p>
                @endif
            </div>
        </div>
        <div class="form-group {{$errors->has('new_password') ? 'has-error' : '' }}">
            <label for="new_password" class="col-lg-2 control-label">@lang('fields.new') @lang('fields.password')</label>
            <div class="col-lg-10">
                {!! Form::password('new_password', ['class' => 'form-control', 'id' => 'new_password', 'placeholder' => 'Name']) !!}
                @if($errors->has('new_password'))
                    <p class="text-danger">{{$errors->first('new_password')}}</p>
                @endif
            </div>
        </div>
        <div class="form-group {{$errors->has('new_password_confirmation') ? 'has-error' : '' }}">
            <label for="new_password_confirmation" class="col-lg-2 control-label">@lang('fields.confirm') @lang('fields.password')</label>
            <div class="col-lg-10">
                {!! Form::password('new_password_confirmation', ['class' => 'form-control', 'id' => 'new_password_confirmation']) !!}
                @if($errors->has('new_password_confirmation'))
                    <p class="text-danger">{{$errors->first('new_password_confirmation')}}</p>
                @endif
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
                <button type="submit" class="btn btn-primary">@lang('fields.save')</button>
            </div>
        </div>
    </fieldset>
    {!! Form::close() !!}
@stop