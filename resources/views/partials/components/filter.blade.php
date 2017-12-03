{!! Form::open(['method' => 'GET', 'class' => 'form-inline']) !!}
<div class="panel panel-default">
    <div class="panel-body">
        <fieldset>
            <div class="form-group">
                <label for="email">@lang('fields.period'):</label>
                {!! Form::select('period', $periods, null, array('class' => 'form-control')) !!}
            </div>
            <div class="form-group">
                {!! Form::text('user_product', null, ['class' => 'form-control', 'placeholder' => Lang::get('fields.search-multi-text', [
                        'entity' => trans_choice('fields.products', 2),
                        'entity1' => trans_choice('fields.users', 2),
                    ])]) !!}
            </div>
            <a href="{{url(Request::url())}}" type="reset" class="btn btn-default">@lang('fields.clear')</a>
            <button type="submit" class="btn btn-default">@lang('fields.search')</button>
        </fieldset>
    </div>
</div>
{!! Form::close() !!}
