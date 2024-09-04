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
        return $this->jsonResponse('success', 'All users list', ['users' => $users], 200) ;
    }


    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);
        if (! $token = auth('api')->attempt($validated)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = User::where('email','=', $validated['email']);
        
        return $this->jsonResponse('success', 'User Login', ['user' => $user, 'token' => $token], 201);
    }


    public function store(Request $request,User $user)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|max:2048', // Max 2MB
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $password = $validated['password'];
        $validated['password'] = Hash::make($validated['password']);


        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $validated['profile_picture'] = $path;
        }

        $user = User::create($validated);
        if (!$token = auth('api')->attempt(['email'=>$validated['email'], 'password'=> $password]) ) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->jsonResponse('success', 'User created', ['user' => $user, 'token' => $token], 201) ;
    }


    public function update(Request $request, User $user)
    {

        //appeler mon repository repository->validator($request->data)

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'profile_picture' => 'sometimes|image|max:2048',
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

        return $this->jsonResponse('success', 'User Updated', ['user' => $user], 201) ;
    }


    public function show(int $id)
    {
        $user = User::findOrFail($id);
        return $this->jsonResponse('success', 'User details', ['user' => $user], 201) ;
    }
   

    public function destroy(User $user)
    {
        $user->delete();
        return $this->jsonResponse('success', 'User created', ['user' => $user], 204) ;
    }
}
