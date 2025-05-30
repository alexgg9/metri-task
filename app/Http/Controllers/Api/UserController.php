<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);
        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);


        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $id,
            'password' => 'sometimes|string|min:8',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);
        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'User deleted successfully.']);
    }

    public function removeUserFromProject($projectId, $userId)
    {
        $project = Project::findOrFail($projectId);
        $project->users()->detach($userId);
        return response()->json(['message' => 'Usuario eliminado del proyecto exitosamente']);
    }

    public function addUserToProject(Request $request, $projectId)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $project = Project::findOrFail($projectId);
        $userId = $request->input('user_id');

        $project->users()->attach($userId);
        return response()->json(['message' => 'Usuario añadido al proyecto exitosamente']);
    }

    public function getProjectUsers($projectId)
    {
        $project = Project::findOrFail($projectId);
        $users = $project->users()->with('roles')->get();
        return response()->json($users);
    }

    public function getCurrentUser()
    {
        $user = Auth::user();
        return response()->json([
            'user' => $user,
            'roles' => $user->roles->pluck('name') 
        ]);
    }
}
