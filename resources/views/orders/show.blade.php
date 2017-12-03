@extends('layouts.dashboard')

@section('dashboard-content')
    <div class="form-horizontal">
        @if(Auth::user()->is_admin)
            <div class="form-group">
                <label for="select" class="col-lg-2 control-label">User</label>
                <div class="col-lg-10">
                    <div class="form-control">
                        {{$order->user->name}}
                    </div>
                </div>
            </div>
        @endif
        <div class="form-group">
            <label for="product" class="col-lg-2 control-label">Product</label>
            <div class="col-lg-10">
                <div class="form-control">
                    {{$order->details()->first()->name}}
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="quantity" class="col-lg-2 control-label">Quantity</label>
            <div class="col-lg-10">
                <div class="form-control">
                    {{$order->details()->first()->pivot->quantity}}
                </div>
            </div>
        </div>
        <div class="form-group text-center">
            <a href="{{url('orders')}}" class="btn btn-default">Back</a>
            @if(Auth::user()->is_admin)
                @include('partials.components.modal', [
                    'btnText' => '&nbsp; Delete',
                    'btnType' => 'danger',
                    'modal' => 'deleteModal',
                    'url' => url('orders/'.$order->id.'?redirectTo=orders/all'),
                    'method' => 'DELETE',
                    'title' => 'Are you sure?',
                    'text' => 'You are going to delete order #'. $order->id
                ])
            @endif
        </div>
    </div>
@stop