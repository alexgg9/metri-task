<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $tasks = Task::with('project', 'user')->get();
        return response()->json($tasks);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {

        $validated = $request->validated();
        $task = Task::create($validated);
        return response()->json($task, 201);
    }

    /**
     * Get tasks by project ID
     */
    public function getTasksByProject(string $projectId)
    {
        $tasks = Task::with('user')
            ->where('project_id', $projectId)
            ->get();

        return response()->json($tasks);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::with('project', 'user')->findOrFail($id);
        return response()->json($task);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, string $id)
    {

        $task = Task::findOrFail($id);
        $task->update($request->all());
        return response()->json($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json(null, 204);
    }

    /**
     * Obtiene todas las tareas del usuario autenticado
     * Incluye tareas donde el usuario es creador o está asignado
     */
    public function getUserTasks()
    {
        try {
            $user = auth()->user();
            
            if (!$user) {
                return response()->json(['error' => 'Usuario no autenticado'], 401);
            }
            
            // Asegurarse de que user_id y assigned_to sean números
            $userId = (int) $user->id;
            
            // Obtener tareas donde el usuario es creador
            $createdTasks = Task::where('user_id', $userId)
                ->with(['user', 'project', 'assignedTo'])
                ->get();
            
            // Obtener tareas donde el usuario está asignado
            $assignedTasks = Task::where('assigned_to', $userId)
                ->with(['user', 'project', 'assignedTo'])
                ->get();
            
            // Combinar y eliminar duplicados
            $allTasks = $createdTasks->concat($assignedTasks)->unique('id');
            
            return response()->json($allTasks);
        } catch (\Exception $e) {
            // Log detallado del error
            \Illuminate\Support\Facades\Log::error('Error en getUserTasks:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => 'Error al obtener las tareas',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
