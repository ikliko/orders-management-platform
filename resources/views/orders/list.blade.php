@extends('layouts.dashboard')

@section('dashboard-content')
    @include('partials.components.filter')

    <table class="table table-striped table-hover ">
        <thead>
        <tr>
            <th>#</th>
            <th>User</th>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{{$order->id}}</td>
                <td>{{$order->user->name}}</td>
                <td>{{$order->details->first()->name}}</td>
                <td>{{$order->details->first()->price}}</td>
                <td>{{$order->details->first()->pivot->quantity}}</td>
                <td>{{$order->total}}</td>
                <td>{{$order->created_at->format('d M Y, h:iA')}}</td>
                <td>
                    <div class="btn-group">
                        <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            <i class="ion ion-ios-more"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{url('orders/' . $order->id)}}">
                                    <i class="ion ion-ios-eye"></i>&nbsp; View
                                </a>
                            </li>
                            @if(Auth::user()->is_admin)
                                <li>
                                    <a href="{{url('orders/' . $order->id . '/edit')}}">
                                        <i class="ion ion-edit"></i>&nbsp; Edit
                                    </a>
                                </li>
                                <li>
                                    @if(Request::url() !== url('orders/trashed'))
                                        <a data-toggle="modal"
                                                data-target="#deleteModal">
                                            <i class="ion ion-ios-trash"></i>&nbsp; Delete
                                        </a>
                                    @endif

                                    @if(Request::url() === url('orders/trashed'))
                                        <a data-toggle="modal"
                                                data-target="#restoreModal">
                                            <i class="ion ion-ios-undo-outline'"></i>&nbsp; Restore
                                        </a>
                                    @endif
                                </li>
                            @endif
                        </ul>

                        @if(Request::url() !== url('orders/trashed') && Auth::user() -> is_admin)
                            @include('partials.components.modal', [
                                'hideBtn' => true,
                                'btnText' => '&nbsp; Delete',
                                'modal' => 'deleteModal',
                                'url' => url('orders/'.$order->id),
                                'method' => 'DELETE',
                                'title' => 'Are you sure?',
                                'text' => 'You are going to delete order #'. $order->id
                            ])
                        @endif

                        @if(Request::url() === url('orders/trashed') && Auth::user() -> is_admin)
                            @include('partials.components.modal', [
                                'hideBtn' => true,
                                'btnText' => '&nbsp; Restore',
                                'btnIcon' => 'ion-ios-undo-outline',
                                'modal' => 'restoreModal',
                                'url' => url('orders/'.$order->id.'/restore'),
                                'method' => 'POST',
                                'title' => 'Are you sure?',
                                'text' => 'You are going to restore order #'. $order->id
                            ])
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop