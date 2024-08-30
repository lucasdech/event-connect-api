<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function index(User $users)
    {
        $users = User::all();
        return response()->json($users, 201);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'profile_picture' => 'required|image|max:1024', // Max 1MB
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_picture', 'public');
            $validated['profile_picture'] = $path;
        }

        $user = User::create($validated);

        return response()->json($user, 201);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'profile_picture' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users' . $user->id,
            'password' => 'required|string|min:8',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        if ($request->hasFile('profile_picture')) {
            // Delete old profile_picture if exists
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $validated['profile_picture'] = $path;
        }

        $user->update($validated);

        return response()->json($user);
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
