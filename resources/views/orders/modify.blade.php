@extends('layouts.dashboard')

@section('dashboard-content')
    {!! Form::open(['url' => isset($order) ? 'orders/'.$order->id : 'orders', 'method' => isset($order) ? 'PUT' : 'POST', 'class' => 'form-horizontal']) !!}
    <fieldse>
        @if(Auth::user()->is_admin)
        <div class="form-group {{$errors->has('user_id') ? 'has-error' : '' }}">
            <label for="select" class="col-lg-2 control-label">User</label>
            <div class="col-lg-10">
                {!! Form::select('user_id', \App\User::pluck('name', 'id'), isset($order) ? $order->user->id : null, ['class' => 'form-control']) !!}
            </div>
            @if($errors->has('user_id'))
                <p class="text-danger">{{$errors->first('user_id')}}</p>
            @endif
        </div>
        @endif
        <div class="form-group {{$errors->has('product_id') ? 'has-error' : '' }}">
            <label for="product" class="col-lg-2 control-label">Product</label>
            <div class="col-lg-10">
                {!! Form::select('product_id', \App\Models\Product::pluck('name', 'id'), isset($order) ? $order->details()->first()->id : null, array('id' => 'product', 'class' => 'form-control')) !!}
                @if($errors->has('product_id'))
                    <p class="text-danger">{{$errors->first('product_id')}}</p>
                @endif
            </div>
        </div>
        <div class="form-group {{$errors->has('quantity') ? 'has-error' : '' }}">
            <label for="quantity" class="col-lg-2 control-label">Quantity</label>
            <div class="col-lg-10">
                <input type="number"
                       class="form-control"
                       id="quantity"
                       name="quantity"
                       placeholder="Quantity"
                       min="1"
                       value="{{isset($order) ? $order->details()->first()->pivot->quantity : 1}}">
                @if($errors->has('quantity'))
                    <p class="text-danger">{{$errors->first('quantity')}}</p>
                @endif
            </div>
        </div>
        <div class="form-group text-center">
            <a href="{{url('home')}}" class="btn btn-default">Cancel</a>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </fieldse>
    {!! Form::close() !!}
@stop