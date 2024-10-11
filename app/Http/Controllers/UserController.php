<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class UserController extends Controller
{

    /**
     * @OA\Tag(
     *     name="User",
     *     description="Operations related to Users"
     * )
     */

    public function __construct(private UserRepository $userRepository) {}

    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Get all users",
     *     tags={"User"},
     *     @OA\Response(
     *         response=200,
     *         description="A list of users",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/User"))
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     * )
     */
    public function index(User $users)
    {
        $users = User::all()->where('role', '=', 'user');
        return $this->jsonResponse('success', 'All users list', ['users' => $users], 200);
    }


    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Login a user",
     *     tags={"User"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", example="johndoe@example.com"),
     *             @OA\Property(property="password", type="string", example="password")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User successfully logged in",
     *         @OA\JsonContent(
     *             @OA\Property(property="user", ref="#/components/schemas/User"),
     *             @OA\Property(property="token", type="string", example="jwt-token")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     * )
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);
        if (! $token = auth('api')->attempt($validated)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = User::where('email', '=', $validated['email'])->first();

        return $this->jsonResponse('success', 'User Login', ['user' => $user, 'token' => $token], 201);
    }


    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Create a new user",
     *     tags={"User"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="User 1"),
     *             @OA\Property(property="email", type="string", example="exemple@example.com"),
     *             @OA\Property(property="password", type="string", example="password"),
     *             @OA\Property(property="profile_picture", type="string", example="picture.jpg"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User created",
     *         @OA\JsonContent(
     *             @OA\Property(property="user", ref="#/components/schemas/User"),
     *             @OA\Property(property="token", type="string", example="jwt-token")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     * )
     */

    public function store(Request $request, User $user)
    {
        $inputs = $request->all();
        $password = $inputs['password'];
        $inputs['password'] = Hash::make($inputs['password']);


        //upload de photo a deplacer dans un service
        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $path = $request->file('profile_picture')->store('profile_pictures');
            $inputs['profile_picture'] = $path;
        }

        //envoie de mail a voir prcq la c'est chiant je peut en envoyer que a moi...
        // Mail::send('emails.register', [
        //     'title' => 'Bienvenue sur notre plateforme',
        //     'content' => 'Merci de vous être inscrit à notre service. Nous sommes ravis de vous compter parmi nous.'
        // ], function($message) {
        //     $message->to('lucasdechavanne22@gmail.com')
        //             ->subject('Bienvenue sur notre plateforme');
        // });

        $user = $this->userRepository->create($inputs);

        if (!$token = auth('api')->attempt(['email' => $inputs['email'], 'password' => $password])) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->jsonResponse('success', 'User created', ['user' => $user, 'token' => $token], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/users/{id}",
     *     summary="Update an existing user",
     *     tags={"User"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the user to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="User 2"),
     *             @OA\Property(property="email", type="string", example="exemple@example.com"),
     *             @OA\Property(property="password", type="string", example="newpassword"),
     *             @OA\Property(property="profile_picture", type="string", example="/path/to/picture.jpg"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User updated",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     * )
     */
    public function update(Request $request, User $user)
    {
        $inputs = $request->all();

        if (isset($inputs['password'])) {
            $inputs['password'] = Hash::make($inputs['password']);
        }

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::disk('public/profile_picture')->delete($user->profile_picture);
            }
            $path = $request->file('profile_picture')->store('profile_picture', 'public');
            $inputs['profile_picture'] = $path;
        }

        $user = $this->userRepository->update($inputs, $user->id);
        return $this->jsonResponse('success', 'User Updated', ['user' => $user], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     summary="Get details of a specific user",
     *     tags={"User"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the user",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User details",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(response=404, description="User not found"),
     * )
     */
    public function show(int $id)
    {
        $user = User::findOrFail($id);
        return $this->jsonResponse('success', 'User details', ['user' => $user], 201);
    }

    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     summary="Delete a user",
     *     tags={"User"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the user",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="User deleted successfully",
     *     ),
     *     @OA\Response(response=404, description="User not found"),
     * )
     */
    public function destroy(User $user)
    {
        $user->delete();
        return $this->jsonResponse('success', 'User Deleted', ['user' => $user], 204);
    }
}
