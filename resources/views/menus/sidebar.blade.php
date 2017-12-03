<?php $active = Request::url(); ?>

<div class="panel panel-default">
    <div class="panel-heading">Orders</div>
    <div class="panel-body rm-pa">
        <div class="list-group rm-mb">
            @if(Auth::user()->is_admin)
                <a href="{{url('orders/all')}}" class="list-group-item {{$active === url('orders/all') ? 'active' : ''}}">
                    @if($allOrders)
                        <span class="badge">{{$allOrders}}</span>
                    @endif
                    <i class="ion ion-ios-paper-outline"></i>&nbsp;
                    All
                </a>

                <a href="{{url('orders/trashed')}}" class="list-group-item {{$active === url('orders/trashed') ? 'active' : ''}}">
                    @if($trashedOrders)
                        <span class="badge">{{$trashedOrders}}</span>
                    @endif
                    <i class="ion ion-ios-trash-outline"></i>&nbsp;
                    Trashed
                </a>
            @endif

            <a href="{{url('orders')}}" class="list-group-item {{$active === url('orders') ? 'active' : ''}}">
                @if($myOrders)
                    <span class="badge">{{$myOrders}}</span>
                @endif
                <i class="ion ion-ios-paper-outline"></i>&nbsp;
                My orders
            </a>

            <a href="{{url('orders/create')}}" class="list-group-item {{$active === url('orders/create') ? 'active' : ''}}">
                <i class="ion ion-ios-compose-outline"></i>&nbsp;
                Create new order
            </a>
        </div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">Products</div>
    <div class="panel-body rm-pa">
        <div class="list-group rm-mb">
            @if(Auth::user()->is_admin)
                <a href="{{url('products/all')}}" class="list-group-item {{$active === url('products/all') ? 'active' : ''}}">
                    @if($allOrders)
                        <span class="badge">{{$allOrders}}</span>
                    @endif
                    <i class="ion ion-ios-paper-outline"></i>&nbsp;
                    All
                </a>

                <a href="{{url('products/trashed')}}" class="list-group-item {{$active === url('products/trashed') ? 'active' : ''}}">
                    @if($trashedOrders)
                        <span class="badge">{{$trashedOrders}}</span>
                    @endif
                    <i class="ion ion-ios-trash-outline"></i>&nbsp;
                    Trashed
                </a>
            @endif

            <a href="{{url('products')}}" class="list-group-item {{$active === url('products') ? 'active' : ''}}">
                @if($myOrders)
                    <span class="badge">{{$myOrders}}</span>
                @endif
                <i class="ion ion-ios-paper-outline"></i>&nbsp;
                My products
            </a>

            <a href="{{url('products/create')}}" class="list-group-item {{$active === url('products/create') ? 'active' : ''}}">
                <i class="ion ion-ios-compose-outline"></i>&nbsp;
                Create new order
            </a>
        </div>
    </div>
</div>