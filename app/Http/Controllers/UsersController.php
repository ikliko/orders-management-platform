<?php

namespace App\Http\Controllers;

use App\Exceptions\NotAuthorized;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsersController extends Controller {
	public function rules($ignoreEmailId = null) {
		$rules = [
			'name' => 'required',
			'email' => 'required|email|unique:users,email'
		];

		if ($ignoreEmailId) {
			$rules['email'] = [
				'required',
				Rule::unique('users')->ignore($ignoreEmailId)
			];
		}

		return $rules;
	}

	public function passwordsRules() {
		return [
			'new_password' => 'required|min:4|confirmed',
		];
	}

	public function settings() {
		$user = Auth::user();

		return view('users.settings', compact('user'));
	}

	public function security() {
		$user = Auth::user();

		return view('users.security', compact('user'));
	}

	public function securityUpdate(Request $request) {
		if (!Hash::check($request->get('old_password'), Auth::user()->getAuthPassword())) {
			return back()->withErrors([
				'old_password' => 'Password does not match'
			]);
		}

		$this->validate($request, $this->passwordsRules());

		$user = Auth::user();
		$user->password = bcrypt($request->get('new_password'));
		$user->save();

		return back();
	}

	public function updateProfile(Request $request) {
		$this->validate($request, $this->rules(Auth::user()->id));
		$user = Auth::user();
		$user->name = $request->get('name');
		$user->email = $request->get('email');
		$user->save();

		return back();
	}

	public function accessible() {
		if (!Auth::user()->is_admin) {
			throw new NotAuthorized('Access denied', 401);
		}
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 * @throws NotAuthorized
	 */
	public function index() {
		$this->accessible();
		$users = User::paginate(5);

		return view('users.list', compact('users'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$this->accessible();

		return view('users.modify');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$this->accessible();
		$this->validate($request, $this->rules());
		User::create([
			'name' => $request->get('name'),
			'email' => $request->get('email'),
			'password' => bcrypt('123456'),
			'is_admin' => !!$request->get('is_admin')
		]);

		return back();
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\User $user
	 * @return \Illuminate\Http\Response
	 * @throws NotAuthorized
	 */
	public function edit(User $user) {
		$this->accessible();

		return view('users.modify', compact('user'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\Models\User $user
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, User $user) {
		$this->accessible();
		$this->validate($request, $this->rules($user->id));
		$user->name = $request->get('name');
		$user->email = $request->get('email');
		$user->is_admin = !!$request->get('is_admin');
		$user->save();

		return back();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\User $user
	 * @return \Illuminate\Http\Response
	 * @throws NotAuthorized
	 */
	public function destroy(Request $request, User $user) {
		$this->accessible();
		$user->delete();

		if ($request->get('redirectTo')) {
			return redirect($request->get('redirectTo'));
		}

		return back();
	}

	public function trashed() {
		$this->accessible();
		$users = User::onlyTrashed()->paginate(5);

		return view('users.list', compact('users'));
	}

	public function restore($id) {
		$this->accessible();
		$user = User::onlyTrashed()->find($id);
		$user->restore();

		return back();
	}
}
