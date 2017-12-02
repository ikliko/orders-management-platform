@if(isset($hideBtn) && !$hideBtn)
    <button type="button"
            data-toggle="modal"
            data-target="#{{$modal}}"
            class="{{isset($btnType) ? 'btn btn-'.$btnType : ''}}">
        <i class="ion {{isset($btnIcon) ? $btnIcon : 'ion-ios-trash'}}"></i> {{isset($btnText) ?  $btnText : ''}}
    </button>
@endif

<div class="modal fade" id="{{$modal}}" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(['url' => $url, 'method' => $method]) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{$title}}</h4>
            </div>
            <div class="modal-body">
                <p>{{$text}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-default">OK</button>
            </div>
            {!! Form::close() !!}
        </div>

    </div>
</div>