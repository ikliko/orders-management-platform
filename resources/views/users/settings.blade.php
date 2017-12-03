@extends('layouts.dashboard-settings')

@section('dashboard-content')
    {!! Form::open(['url' => url('settings'), 'class' => 'form-horizontal']) !!}
    <fieldset>
        <div class="form-group {{$errors->has('name') ? 'has-error' : '' }}">
            <label for="name" class="col-lg-2 control-label">Name</label>
            <div class="col-lg-10">
                {!! Form::text('name', $user->name, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Name']) !!}
                @if($errors->has('name'))
                    <p class="text-danger">{{$errors->first('name')}}</p>
                @endif
            </div>
        </div>
        <div class="form-group {{$errors->has('email') ? 'has-error' : '' }}">
            <label for="email" class="col-lg-2 control-label">Email</label>
            <div class="col-lg-10">
                {!! Form::email('email', $user->email, ['class' => 'form-control', 'id' => 'email']) !!}
                @if($errors->has('email'))
                    <p class="text-danger">{{$errors->first('email')}}</p>
                @endif
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </fieldset>
    {!! Form::close() !!}
@stop