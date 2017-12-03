@extends('layouts.dashboard')

@section('dashboard-content')
    <div class="table-wrapper">
        <table class="table table-striped table-hover ">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Price</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products->items() as $product)
                <tr>
                    <td>{{$product['id']}}</td>
                    <td>{{$product['name']}}</td>
                    <td>{{$product['price']}}</td>
                    <td>{{\Carbon\Carbon::parse($product['created_at'])->format('d M Y, h:iA')}}</td>
                    <td>
                        <div class="btn-group">
                            <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                <i class="ion ion-ios-more"></i>
                            </a>
                            <ul class="dropdown-menu">
                                @if(Auth::user()->is_admin)
                                    @if(Request::url() !== url('products/trashed'))
                                        <li>
                                            <a href="{{url('products/' . $product['id'] . '/edit')}}">
                                                <i class="ion ion-edit"></i>&nbsp; Edit
                                            </a>
                                        </li>
                                    @endif
                                    <li>
                                        @if(Request::url() !== url('products/trashed'))
                                            <a data-toggle="modal"
                                               data-target="#deleteModal">
                                                <i class="ion ion-ios-trash"></i>&nbsp; Delete
                                            </a>
                                        @endif

                                        @if(Request::url() === url('products/trashed'))
                                            <a data-toggle="modal"
                                               data-target="#restoreModal">
                                                <i class="ion ion-ios-undo-outline'"></i>&nbsp; Restore
                                            </a>
                                        @endif
                                    </li>
                                @endif
                            </ul>

                            @if(Request::url() !== url('products/trashed') && Auth::user() -> is_admin)
                                @include('partials.components.modal', [
                                    'hideBtn' => true,
                                    'btnText' => '&nbsp; '.Lang::get('fields.delete'),
                                    'modal' => 'deleteModal',
                                    'url' => url('products/'.$product['id']),
                                    'method' => 'DELETE',
                                    'title' => Lang::get('fields.are-you-sure-q'),
                                    'text' => Lang::get('fields.modal-text', [
                                        'entity' => trans_choice('fields.products', 1),
                                        'action' => Lang::get('fields.delete'),
                                        'id' => $product['id']
                                    ])
                                ])
                            @endif

                            @if(Request::url() === url('products/trashed') && Auth::user() -> is_admin)
                                @include('partials.components.modal', [
                                    'hideBtn' => true,
                                    'btnText' => '&nbsp; '.Lang::get('fields.restore'),
                                    'btnIcon' => 'ion-ios-undo-outline',
                                    'modal' => 'restoreModal',
                                    'url' => url('products/'.$product['id'].'/restore'),
                                    'method' => 'POST',
                                    'title' => Lang::get('fields.are-you-sure-q'),
                                    'text' => Lang::get('fields.modal-text', [
                                        'entity' => trans_choice('fields.products', 1),
                                        'action' => Lang::get('fields.restore'),
                                        'id' => $product['id']
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

    @if( $products->lastPage() > 1)
        <ul class="pagination pagination-sm">
            <li class="{{$products->currentPage() === 1 ? 'disabled' : ''}}">
                @if($products->currentPage() === 1)
                    <a>&laquo;</a>
                @else
                    <a href="{{Request::url()}}?page={{$products->currentPage()-1}}">&laquo;</a>
                @endif
            </li>
            @for ( $i = 1; $i <= $products->lastPage() ; $i++ )
                <li class="{{$i === $products->currentPage() ? 'active' : ''}}"><a
                            href="{{Request::url()}}?page={{$i}}">{{$i}}</a></li>
            @endfor
            <li class="{{$products->currentPage() === $products->lastPage() ? 'disabled' : ''}}">
                @if($products->currentPage() === $products->lastPage())
                    <a>&raquo;</a>
                @else
                    <a href="{{Request::url()}}?page={{$products->currentPage()+1}}">&raquo;</a>
                @endif
            </li>
        </ul>
    @endif
@stop