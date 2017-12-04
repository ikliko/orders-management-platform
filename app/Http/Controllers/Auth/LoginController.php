<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {
	/*
	|--------------------------------------------------------------------------
	| Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles authenticating users for the application and
	| redirecting them to your home screen. The controller uses a trait
	| to conveniently provide its functionality to your applications.
	|
	*/

	use AuthenticatesUsers;

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('guest')->except('logout');
		$this->redirectTo = config('omp-config.loginHome');
	}

	public function regular() {
		if (env('DEMO')) {
			Auth::login(User::whereIsAdmin(false)->inRandomOrder()->first());

			return redirect($this->redirectTo);
		}
	}

	public function admin() {
		if (env('DEMO') && env('DEMO_ADMIN')) {
			Auth::login(User::whereIsAdmin(true)->first());

			return redirect($this->redirectTo);
		}
	}
}
