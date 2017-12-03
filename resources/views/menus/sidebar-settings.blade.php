<?php $active = Request::url(); ?>

<a href="{{url('settings')}}" class="list-group-item {{$active === url('settings') ? 'active' : ''}}">
    <i class="ion ion-person"></i>&nbsp;
    @lang('fields.profile')
</a>

<a href="{{url('settings/security')}}" class="list-group-item {{$active === url('settings/security') ? 'active' : ''}}">
    <i class="ion ion-lock-combination"></i>&nbsp;
    @lang('fields.security')
</a>