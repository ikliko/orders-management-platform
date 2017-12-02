@if(env('DEMO'))
    <div class="alert alert-info">
        @if(env('DEMO_ADMIN'))
        <p>You can simply login as administrator by <a href="{{url('login/admin')}}">clicking me</a></p>
        @endif
        <p>You can login as regular user by <a href="{{url('login/regular')}}">clicking me</a></p>
        <p>You can register new user by <a href="{{url('register')}}">clicking here</a></p>
    </div>
@endif