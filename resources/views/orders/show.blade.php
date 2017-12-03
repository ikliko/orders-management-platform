@extends('layouts.dashboard')

@section('dashboard-content')
    <div class="form-horizontal">
        @if(Auth::user()->is_admin)
            <div class="form-group">
                <label for="select" class="col-lg-2 control-label">{{trans_choice('fields.users', 1)}}</label>
                <div class="col-lg-10">
                    <div class="form-control">
                        {{$order->user->name}}
                    </div>
                </div>
            </div>
        @endif
        <div class="form-group">
            <label for="product" class="col-lg-2 control-label">{{trans_choice('fields.products', 1)}}</label>
            <div class="col-lg-10">
                <div class="form-control">
                    {{$order->details()->first()->name}}
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="quantity" class="col-lg-2 control-label">@lang('fields.quantity')</label>
            <div class="col-lg-10">
                <div class="form-control">
                    {{$order->details()->first()->pivot->quantity}}
                </div>
            </div>
        </div>
        <div class="form-group text-center">
            <a href="{{url('orders')}}" class="btn btn-default">@lang('fields.back')</a>
            @if(Auth::user()->is_admin)
                @include('partials.components.modal', [
                    'btnText' => '&nbsp; Delete',
                    'btnType' => 'danger',
                    'modal' => 'deleteModal',
                    'url' => url('orders/'.$order->id.'?redirectTo=orders/all'),
                    'method' => 'DELETE',
                    'title' => Lang::get('fields.are-you-sure-q'),
                    'text' => Lang::get('fields.modal-text', [
                        'entity' => trans_choice('fields.orders', 1),
                        'action' => Lang::get('fields.delete'),
                        'id' => $order['id']
                    ])
                ])
            @endif
        </div>
    </div>
@stop