@guest
<li><a href="{{ route('login') }}">@lang('fields.login')</a></li>
<li><a href="{{ route('register') }}">@lang('fields.register')</a></li>
@else
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
       aria-expanded="false" aria-haspopup="true">
        {{ Auth::user()->name }} <span class="caret"></span>
    </a>

    <ul class="dropdown-menu">
        <li>
            <a href="{{url('settings')}}"><i class="ion-gear-b"></i>&nbsp; @lang('fields.settings')</a>
        </li>
        <li class="divider"></li>
        <li>
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="ion-log-out"></i>&nbsp;
                @lang('fields.logout')
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                  style="display: none;">
                {{ csrf_field() }}
            </form>
        </li>
    </ul>
</li>
@endguest