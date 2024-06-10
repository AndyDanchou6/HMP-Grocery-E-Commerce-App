<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function login(Request $request) 
    {
        try {
            $request->validate([
                'name' => 'required|string|max:16',
                'password' => 'required|string|min:8',
            ]);

            $user = User::where('name', $request->name)->first();

            if(!$user)
            {
                return response()->json([
                    'message' => 'User Not Found'
                ]);
            }

            if(!Hash::check($request->password, $user->password))
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid Credentials'
                ]);
            }

            $token = $user->createToken('token');
            
            return response()->json([
                'access_token' => $token->plainTextToken,
                'status' => true,
                'message' => 'Login Successfully',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

}
