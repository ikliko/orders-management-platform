@extends('layouts.dashboard')

@section('dashboard-content')
    @include('partials.components.filter')
    <div class="table-wrapper">
        <table class="table table-striped table-hover ">
            <thead>
            <tr>
                <th>#</th>
                <th>{{trans_choice('fields.users', 1)}}</th>
                <th>{{trans_choice('fields.products', 1)}}</th>
                <th>@lang('fields.price')</th>
                <th>@lang('fields.quantity')</th>
                <th>@lang('fields.total')</th>
                <th>@lang('fields.date')</th>
                <th>{{trans_choice('fields.actions', 2)}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders->items() as $order)
                <tr>
                    <td>{{$order['id']}}</td>
                    <td>{{$order['user']['name']}}</td>
                    <td>{{$order['details'][0]['name']}}</td>
                    <td>{{$order['details'][0]['price']}}</td>
                    <td>{{$order['details'][0]['pivot']['quantity']}}</td>
                    <td>{{$order['total']}}</td>
                    <td>{{\Carbon\Carbon::parse($order['created_at'])->format('d M Y, h:iA')}}</td>
                    <td>
                        <div class="btn-group">
                            <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                <i class="ion ion-ios-more"></i>
                            </a>
                            <ul class="dropdown-menu">
                                @if(Request::url() !== url('orders/trashed'))
                                    <li>
                                        <a href="{{url('orders/' . $order['id'])}}">
                                            <i class="ion ion-ios-eye"></i>&nbsp; @lang('fields.view')
                                        </a>
                                    </li>
                                @endif
                                @if(Auth::user()->is_admin)
                                    @if(Request::url() !== url('orders/trashed'))
                                        <li>
                                            <a href="{{url('orders/' . $order['id'] . '/edit')}}">
                                                <i class="ion ion-edit"></i>&nbsp; @lang('fields.edit')
                                            </a>
                                        </li>
                                    @endif
                                    <li>
                                        @if(Request::url() !== url('orders/trashed'))
                                            <a data-toggle="modal"
                                               data-target="#deleteModal">
                                                <i class="ion ion-ios-trash"></i>&nbsp; @lang('fields.delete')
                                            </a>
                                        @endif

                                        @if(Request::url() === url('orders/trashed'))
                                            <a data-toggle="modal"
                                               data-target="#restoreModal">
                                                <i class="ion ion-ios-undo-outline'"></i>&nbsp; @lang('fields.restore')
                                            </a>
                                        @endif
                                    </li>
                                @endif
                            </ul>

                            @if(Request::url() !== url('orders/trashed') && Auth::user() -> is_admin)
                                @include('partials.components.modal', [
                                    'hideBtn' => true,
                                    'btnText' => '&nbsp; '.Lang::get('fields.delete'),
                                    'modal' => 'deleteModal',
                                    'url' => url('orders/'.$order['id']),
                                    'method' => 'DELETE',
                                    'title' => Lang::get('fields.are-you-sure-q'),
                                    'text' => Lang::get('fields.modal-text', [
                                        'entity' => trans_choice('fields.orders', 1),
                                        'action' => Lang::get('fields.delete'),
                                        'id' => $order['id']
                                    ])
                                ])
                            @endif

                            @if(Request::url() === url('orders/trashed') && Auth::user() -> is_admin)
                                @include('partials.components.modal', [
                                    'hideBtn' => true,
                                    'btnText' => '&nbsp; '.Lang::get('fields.restore'),
                                    'btnIcon' => 'ion-ios-undo-outline',
                                    'modal' => 'restoreModal',
                                    'url' => url('orders/'.$order['id'].'/restore'),
                                    'method' => 'POST',
                                    'title' => Lang::get('fields.are-you-sure-q'),
                                    'text' => Lang::get('fields.modal-text', [
                                        'entity' => trans_choice('fields.orders', 1),
                                        'action' => Lang::get('fields.restore'),
                                        'id' => $order['id']
                                    ])
                                ])
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    @if( $orders->lastPage() > 1)
        <ul class="pagination pagination-sm">
            <li class="{{$orders->currentPage() === 1 ? 'disabled' : ''}}">
                @if($orders->currentPage() === 1)
                    <a>&laquo;</a>
                @else
                    <a href="{{Request::url()}}?page={{$orders->currentPage()-1}}">&laquo;</a>
                @endif
            </li>
            @for ( $i = 1; $i <= $orders->lastPage() ; $i++ )
                <li class="{{$i === $orders->currentPage() ? 'active' : ''}}"><a
                            href="{{Request::url()}}?page={{$i}}">{{$i}}</a></li>
            @endfor
            <li class="{{$orders->currentPage() === $orders->lastPage() ? 'disabled' : ''}}">
                @if($orders->currentPage() === $orders->lastPage())
                    <a>&raquo;</a>
                @else
                    <a href="{{Request::url()}}?page={{$orders->currentPage()+1}}">&raquo;</a>
                @endif
            </li>
        </ul>
    @endif
@stop