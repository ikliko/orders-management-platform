@if(env('DEMO'))
    <div class="alert alert-info">
        @if(env('DEMO_ADMIN'))
        <p>
            @lang('fields.helper-login-text', [
                'action' => Lang::get('fields.login'),
                'who' => trans_choice('fields.administrators',1),
            ])
            <a href="{{url('login/admin')}}">@lang('fields.click-me')</a>
        </p>
        @endif
        <p>
            @lang('fields.helper-login-text', [
                'action' => Lang::get('fields.login'),
                'who' => Lang::get('fields.regular').' '.trans_choice('fields.users',1),
            ])
            <a href="{{url('login/regular')}}">@lang('fields.click-me')</a>
        </p>
        <p>
            @lang('fields.helper-login-text', [
                'action' => Lang::get('fields.register'),
                'who' => Lang::get('fields.new').' '.trans_choice('fields.users',1),
            ])
            <a href="{{url('register')}}">@lang('fields.click-me')</a>
        </p>
    </div>
@endif