<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        return response()->json(['message' => 'Inscription réussie'], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            $user = Auth::user();
            $token = JWTAuth::fromUser($user);

            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['message' => 'Identifiants invalides'], 401);
        }
    }

    public function manageRoles(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'new_role' => 'required|string|in:' . User::ROLE_ADMIN . ',' . User::ROLE_USER,
        ]);

        $user = auth()->user();

        if ($user->isAdmin()) {
            $userIdToChangeRole = $request->input('user_id');
            $newRole = $request->input('new_role');

            $userToChangeRole = User::find($userIdToChangeRole);

            if (!$userToChangeRole) {
                return response()->json(['message' => 'Utilisateur non trouvé'], 404);
            }

            $userToChangeRole->role = $newRole;
            $userToChangeRole->save();

            return response()->json(['message' => 'Rôle modifié avec succès'], 200);
        } else {
            return response()->json(['message' => 'Accès refusé'], 403);
        }
    }













}
