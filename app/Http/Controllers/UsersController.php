<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsersController extends Controller {
	public function rules($update = false, $ignoreEmailId = null) {
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

		if (!$update) {
			$rules['password'] = 'required|min:4';
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

	public function update(Request $request) {
		$this->validate($request, $this->rules(true, Auth::user()->id));
		$user = Auth::user();
		$user->name = $request->get('name');
		$user->email = $request->get('email');
		$user->save();

		return back();
	}
}
