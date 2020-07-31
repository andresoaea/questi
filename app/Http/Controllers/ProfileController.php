<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    
	public function index(Request $request)
	{

		$isProfilePage = true;

		\Javascript::put([
			'isProfile' => true
		]);

		return view('profile', compact('isProfilePage'));

	}

}
