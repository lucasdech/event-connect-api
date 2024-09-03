<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index(User $users)
    {
        $users = User::all();
        return response()->json($users, 201);
    }


    public function login(Request $request,User $user)
    {
        $validated = $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);
        if (! $token = auth('api')->attempt($validated)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json($token, 201);
    }

    public function store(Request $request,User $user)
    {
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|max:1024', // Max 1MB
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $validated['password'] = Hash::make($validated['password']);


        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $validated['profile_picture'] = $path;
        }

        $user = User::create($validated);
        $token = auth('web')->attempt(['email'=>$validated['email'], 'password'=>$validated['password']]);
        if (!$token ) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        dd($token);
        return response()->json([$user, $token], 201);
    }

    public function update(Request $request, User $user)
    {

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'profile_picture' => 'sometimes|image|max:1024',
            'email' => 'sometimes|string|email|max:255|unique:users',
            'password' => 'sometimes|string|min:8',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $validated['profile_picture'] = $path;
        }

        $user->update($validated);

        return response()->json($user, 201);
    }


    public function show(int $id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }


    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(null, 204);
    }
}
