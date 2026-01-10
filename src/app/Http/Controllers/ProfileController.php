<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('mypage.profile', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileRequest $request)
    {
        $user = $request->user();

        if($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profiles', 'public');
            $user->profile_image = $path;
        }
        
        $user->username = $request->input('username');
        $user->postcode = $request->input('postcode');
        $user->address = $request->input('address');
        $user->building = $request->input('building');

        $user->profile_completed = true;

        $user->save();

        return redirect('/');
    }
}
