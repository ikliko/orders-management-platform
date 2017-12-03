@extends('layouts.dashboard')

@section('dashboard-content')
    {!! Form::open(['url' => isset($product) ? 'products/'.$product->id : 'products', 'method' => isset($product) ? 'PUT' : 'POST', 'class' => 'form-horizontal']) !!}
    <fieldset>
        <div class="form-group {{$errors->has('name') ? 'has-error' : '' }}">
            <label for="select" class="col-lg-2 control-label">Name</label>
            <div class="col-lg-10">
                {!! Form::text('name', isset($product) ? $product->name : null, ['class' => 'form-control', 'placeholder' => 'Name']) !!}
                @if($errors->has('name'))
                    <p class="text-danger">{{$errors->first('name')}}</p>
                @endif
            </div>
        </div>
        <div class="form-group {{$errors->has('price') ? 'has-error' : '' }}">
            <label for="select" class="col-lg-2 control-label">Price</label>
            <div class="col-lg-10">
                {!! Form::text('price', isset($product) ? $product->price : null, ['class' => 'form-control', 'placeholder' => 'Price']) !!}
                @if($errors->has('price'))
                    <p class="text-danger">{{$errors->first('price')}}</p>
                @endif
            </div>
        </div>
        <div class="form-group {{$errors->has('discount') ? 'has-error' : '' }}">
            <label for="select" class="col-lg-2 control-label">Discount</label>
            <div class="col-lg-10">
                <input type="checkbox" name="discount"
                       class="switcher" {{ isset($product) && $product->discount ? 'checked': ''}}>
                @if($errors->has('discount'))
                    <p class="text-danger">{{$errors->first('discount')}}</p>
                @endif
            </div>
        </div>
        <div class="form-group text-center">
            <a href="{{url('home')}}" class="btn btn-default">Cancel</a>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </fieldset>
    {!! Form::close() !!}
@stop