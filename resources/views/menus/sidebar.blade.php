<?php $active = Request::url(); ?>

<div class="panel panel-default">
    <div class="panel-heading">{{trans_choice('fields.orders', 2)}}</div>
    <div class="panel-body rm-pa">
        <div class="list-group rm-mb">
            @if(Auth::user()->is_admin)
                <a href="{{url('orders/all')}}"
                   class="list-group-item {{$active === url('orders/all') ? 'active' : ''}}">
                    @if($allOrders)
                        <span class="badge">{{$allOrders}}</span>
                    @endif
                    <i class="ion ion-ios-paper-outline"></i>&nbsp;
                    @lang('fields.all')
                </a>

                <a href="{{url('orders/trashed')}}"
                   class="list-group-item {{$active === url('orders/trashed') ? 'active' : ''}}">
                    @if($trashedOrders)
                        <span class="badge">{{$trashedOrders}}</span>
                    @endif
                    <i class="ion ion-ios-trash-outline"></i>&nbsp;
                    @lang('fields.trashed')
                </a>
            @endif

            <a href="{{url('orders')}}" class="list-group-item {{$active === url('orders') ? 'active' : ''}}">
                @if($myOrders)
                    <span class="badge">{{$myOrders}}</span>
                @endif
                <i class="ion ion-ios-paper-outline"></i>&nbsp;
                @lang('fields.my-entity', ['entity' => trans_choice('fields.orders', 2)])
            </a>

            <a href="{{url('orders/create')}}"
               class="list-group-item {{$active === url('orders/create') ? 'active' : ''}}">
                <i class="ion ion-ios-compose-outline"></i>&nbsp;
                @lang('fields.create-new', ['entity' => trans_choice('fields.orders',1)])
            </a>
        </div>
    </div>
</div>

@if(Auth::user()->is_admin)
    <div class="panel panel-default">
        <div class="panel-heading">{{trans_choice('fields.products', 2)}}</div>
        <div class="panel-body rm-pa">
            <div class="list-group rm-mb">
                <a href="{{url('products')}}"
                   class="list-group-item {{$active === url('products') ? 'active' : ''}}">
                    @if($allProducts)
                        <span class="badge">{{$allProducts}}</span>
                    @endif
                    <i class="ion ion-ios-paper-outline"></i>&nbsp;
                    @lang('fields.all')
                </a>

                <a href="{{url('products/trashed')}}"
                   class="list-group-item {{$active === url('products/trashed') ? 'active' : ''}}">
                    @if($trashedProducts)
                        <span class="badge">{{$trashedProducts}}</span>
                    @endif
                    <i class="ion ion-ios-trash-outline"></i>&nbsp;
                    @lang('fields.trashed')
                </a>

                <a href="{{url('products/create')}}"
                   class="list-group-item {{$active === url('products/create') ? 'active' : ''}}">
                    <i class="ion ion-ios-compose-outline"></i>&nbsp;
                    @lang('fields.create-new', ['entity' => trans_choice('fields.products',1)])
                </a>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">Users</div>
        <div class="panel-body rm-pa">
            <div class="list-group rm-mb">
                <a href="{{url('users')}}"
                   class="list-group-item {{$active === url('users') ? 'active' : ''}}">
                    @if($allUsers)
                        <span class="badge">{{$allUsers}}</span>
                    @endif
                    <i class="ion ion-ios-paper-outline"></i>&nbsp;
                    @lang('fields.all')
                </a>

                <a href="{{url('users/trashed')}}"
                   class="list-group-item {{$active === url('users/trashed') ? 'active' : ''}}">
                    @if($trashedUsers)
                        <span class="badge">{{$trashedUsers}}</span>
                    @endif
                    <i class="ion ion-ios-trash-outline"></i>&nbsp;
                    @lang('fields.trashed')
                </a>

                <a href="{{url('users/create')}}"
                   class="list-group-item {{$active === url('users/create') ? 'active' : ''}}">
                    <i class="ion ion-ios-compose-outline"></i>&nbsp;
                    @lang('fields.create-new', ['entity' => trans_choice('fields.users',1)])
                </a>
            </div>
        </div>
    </div>
@endif