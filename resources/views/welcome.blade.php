@extends('layouts.default')

@section('content')
    <div class="well">
        {!! Form::open(['url' => 'orders', 'class' => 'form-horizontal']) !!}
        <fieldset>
            <div class="form-group">
                <label for="select" class="col-lg-2 control-label">User</label>
                <div class="col-lg-10">
                    {!! Form::select('user_id', \App\User::pluck('name', 'id'), null, array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="form-group">
                <label for="select" class="col-lg-2 control-label">Product</label>
                <div class="col-lg-10">
                    {!! Form::select('product_id', \App\Models\Product::pluck('name', 'id'), null, array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="form-group">
                <label for="quantity" class="col-lg-2 control-label">Quantity</label>
                <div class="col-lg-10">
                    <input type="number"
                           class="form-control"
                           id="quantity"
                           name="quantity"
                           placeholder="Quantity"
                           min="1"
                           value="1">
                </div>
            </div>
            <div class="form-group text-center">
                <button type="reset" class="btn btn-default">Cancel</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </fieldset>
        {!! Form::close() !!}
    </div>

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
                    <a href="{{url('orders/' . $order->id . '/edit')}}" class="btn btn-default">
                        <i class="ion ion-edit"></i>
                    </a>
                    <button type="button"
                            data-toggle="modal"
                            data-target="#myModal"
                            class="btn btn-danger">
                        <i class="ion ion-ios-trash"></i>
                    </button>

                    <div class="modal fade" id="myModal" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                {!! Form::open(['url'=> 'orders/'.$order->id, 'method'=>'DELETE']) !!}
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Are you sure?</h4>
                                </div>
                                <div class="modal-body">
                                    <p>You are going to delete order: #{{$order->id}}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-default">Delete</button>
                                </div>
                                {!! Form::close() !!}
                            </div>

                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop