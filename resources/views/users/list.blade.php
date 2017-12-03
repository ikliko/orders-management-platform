@extends('layouts.dashboard')

@section('dashboard-content')
    @include('partials.components.filter')

    <table class="table table-striped table-hover ">
        <thead>
        <tr>
            <th>#</th>
            <th>@lang('fields.name')</th>
            <th>@lang('fields.email')</th>
            <th>@lang('fields.date')</th>
            <th>{{trans_choice('fields.actions', 2)}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users->items() as $user)
            <tr>
                <td>{{$user['id']}}</td>
                <td>{{$user['name']}}</td>
                <td>{{$user['email']}}</td>
                <td>{{\Carbon\Carbon::parse($user['created_at'])->format('d M Y, h:iA')}}</td>
                <td>
                    <div class="btn-group">
                        <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            <i class="ion ion-ios-more"></i>
                        </a>
                        <ul class="dropdown-menu">
                            @if(Auth::user()->is_admin)
                                @if(Request::url() !== url('users/trashed'))
                                    <li>
                                        <a href="{{url('users/' . $user['id'] . '/edit')}}">
                                            <i class="ion ion-edit"></i>&nbsp; @lang('fields.edit')
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    @if(Request::url() !== url('users/trashed'))
                                        <a data-toggle="modal"
                                           data-target="#deleteModal">
                                            <i class="ion ion-ios-trash"></i>&nbsp; @lang('fields.delete')
                                        </a>
                                    @endif

                                    @if(Request::url() === url('users/trashed'))
                                        <a data-toggle="modal"
                                           data-target="#restoreModal">
                                            <i class="ion ion-ios-undo-outline'"></i>&nbsp; @lang('fields.restore')
                                        </a>
                                    @endif
                                </li>
                            @endif
                        </ul>

                        @if(Request::url() !== url('users/trashed') && Auth::user() -> is_admin)
                            @include('partials.components.modal', [
                                'hideBtn' => true,
                                'btnText' => '&nbsp; '.Lang::get('fields.delete'),
                                'modal' => 'deleteModal',
                                'url' => url('users/'.$user['id']),
                                'method' => 'DELETE',
                                'title' => Lang::get('fields.are-you-sure-q'),
                                'text' => Lang::get('fields.modal-text', [
                                    'entity' => trans_choice('fields.users', 1),
                                    'action' => Lang::get('fields.delete'),
                                    'id' => $user['id']
                                ])
                            ])
                        @endif

                        @if(Request::url() === url('users/trashed') && Auth::user() -> is_admin)
                            @include('partials.components.modal', [
                                'hideBtn' => true,
                                'btnText' => '&nbsp; '.Lang::get('fields.restore'),
                                'btnIcon' => 'ion-ios-undo-outline',
                                'modal' => 'restoreModal',
                                'url' => url('users/'.$user['id'].'/restore'),
                                'method' => 'POST',
                                'title' => Lang::get('fields.are-you-sure-q'),
                                'text' => Lang::get('fields.modal-text', [
                                    'entity' => trans_choice('fields.users', 1),
                                    'action' => Lang::get('fields.delete'),
                                    'id' => $user['id']
                                ])
                            ])
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @if( $users->lastPage() > 1)
        <ul class="pagination pagination-sm">
            <li class="{{$users->currentPage() === 1 ? 'disabled' : ''}}">
                @if($users->currentPage() === 1)
                    <a>&laquo;</a>
                @else
                    <a href="{{Request::url()}}?page={{$users->currentPage()-1}}">&laquo;</a>
                @endif
            </li>
            @for ( $i = 1; $i <= $users->lastPage() ; $i++ )
                <li class="{{$i === $users->currentPage() ? 'active' : ''}}"><a
                            href="{{Request::url()}}?page={{$i}}">{{$i}}</a></li>
            @endfor
            <li class="{{$users->currentPage() === $users->lastPage() ? 'disabled' : ''}}">
                @if($users->currentPage() === $users->lastPage())
                    <a>&raquo;</a>
                @else
                    <a href="{{Request::url()}}?page={{$users->currentPage()+1}}">&raquo;</a>
                @endif
            </li>
        </ul>
    @endif
@stop