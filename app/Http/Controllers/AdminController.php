<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'name' => 'required',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::findOrFail($id);
        $user->role = $request->input('role');
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatar', 'public');
            $user->avatar = $avatarPath;
        }

        $user->save();

        return redirect()->route('users.index')->with('success', ' Updated Successfully');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required',
            'email' => 'required|email|unique:users,email',
            'name' => 'required',
            'password' => 'required|string|min:8',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = new User([
            'role' => $request->role,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Created Successfully');
    }

    public function destroy($id)
    {
        $currentUser = Auth::user();

        $user = User::findOrFail($id);

        if ($currentUser->id === $user->id && $currentUser->role === 'Admin') {
            return redirect()->route('users.index')->with('error', "You can't delete your own account!");
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Deleted Successfully');
    }


    public function index(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'Admin') {
            $usersQuery = User::query();

            if ($request->has('search')) {
                $search = $request->input('search');
                $usersQuery->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('role', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->orWhere('address', 'like', '%' . $search . '%');
            }

            $users = $usersQuery->paginate(10);

            return view('users.index', compact('users'));
        } elseif (Auth::check()) {
            return redirect()->route('error404');
        } else {
            return redirect()->route('error404');
        }
    }
}
