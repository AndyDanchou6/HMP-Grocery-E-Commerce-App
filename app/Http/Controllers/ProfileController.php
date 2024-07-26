<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (auth()->user()->role == 'Admin') {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:users,email,' . $id,
                'name' => 'string|max:255',
                'phone' => 'string|nullable',
                'fb_link' => 'string|nullable',
                'address' => 'string|nullable',
                'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $user = User::findOrFail($id);
            $user->name = $request->input('name');
            $user->phone = $request->input('phone');
            $user->fb_link = $request->input('fb_link');
            $user->address = $request->input('address');
            $user->email = $request->input('email');

            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                $user->avatar = $avatarPath;
            }

            $user->save();

            return redirect()->back()->with('success', 'Profile Updated Successfully');
        } else {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:users,email,' . $id,
                'name' => 'required',
                'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $user = User::findOrFail($id);
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->fb_link = $request->input('fb_link');
            $user->address = $request->input('address');
            $user->phone = $request->input('phone');

            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                $user->avatar = $avatarPath;
            }

            $user->save();

            return redirect()->back()->with('success', 'Profile Updated Successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function changePass(Request $request)
    {
        $validatedPassword = Validator::make($request->all(), [
            'lastPassword' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validatedPassword->fails()) {

            return redirect()->back()->with('error', 'Please check if the new password had atleast 8 characters and matches with the confirm input.');
        }

        $user = User::findOrFail($request->input('userId'));
        $originalPassword = $user->password;

        if (!Hash::check($request->input('lastPassword'), $originalPassword)) {

            return redirect()->back()->with('error', 'Last password does not match!');
        }

        $user->password = Hash::make($request->input('password'));

        if (!$user->save()) {

            return redirect()->back()->with('error', 'Password change failed!');
        }

        return redirect()->back()->with('success', 'Password change successful!');
        // dd($user);
    }
}
