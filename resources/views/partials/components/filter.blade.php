{!! Form::open(['method' => 'GET', 'class' => 'form-inline']) !!}
<div class="panel panel-default">
    <div class="panel-body">
        <fieldset>
            <div class="form-group">
                <label for="email">Period:</label>
                {!! Form::select('period', $periods, null, array('class' => 'form-control')) !!}
            </div>
            <div class="form-group">
                {!! Form::text('user_product', null, ['class' => 'form-control', 'placeholder' => 'Search user or product..']) !!}
            </div>
            <a href="{{url(Request::url())}}" type="reset" class="btn btn-default">Clear</a>
            <button type="submit" class="btn btn-default">Search</button>
        </fieldset>
    </div>
</div>
{!! Form::close() !!}
