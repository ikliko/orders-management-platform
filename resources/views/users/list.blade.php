@extends('layouts.dashboard')

@section('dashboard-content')
    @include('partials.components.filter')

    <table class="table table-striped table-hover ">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Date</th>
            <th>Actions</th>
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
                                            <i class="ion ion-edit"></i>&nbsp; Edit
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    @if(Request::url() !== url('users/trashed'))
                                        <a data-toggle="modal"
                                           data-target="#deleteModal">
                                            <i class="ion ion-ios-trash"></i>&nbsp; Delete
                                        </a>
                                    @endif

                                    @if(Request::url() === url('users/trashed'))
                                        <a data-toggle="modal"
                                           data-target="#restoreModal">
                                            <i class="ion ion-ios-undo-outline'"></i>&nbsp; Restore
                                        </a>
                                    @endif
                                </li>
                            @endif
                        </ul>

                        @if(Request::url() !== url('users/trashed') && Auth::user() -> is_admin)
                            @include('partials.components.modal', [
                                'hideBtn' => true,
                                'btnText' => '&nbsp; Delete',
                                'modal' => 'deleteModal',
                                'url' => url('users/'.$user['id']),
                                'method' => 'DELETE',
                                'title' => 'Are you sure?',
                                'text' => 'You are going to delete user #'. $user['id']
                            ])
                        @endif

                        @if(Request::url() === url('users/trashed') && Auth::user() -> is_admin)
                            @include('partials.components.modal', [
                                'hideBtn' => true,
                                'btnText' => '&nbsp; Restore',
                                'btnIcon' => 'ion-ios-undo-outline',
                                'modal' => 'restoreModal',
                                'url' => url('users/'.$user['id'].'/restore'),
                                'method' => 'POST',
                                'title' => 'Are you sure?',
                                'text' => 'You are going to restore user #'. $user['id']
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