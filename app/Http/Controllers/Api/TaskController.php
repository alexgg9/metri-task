<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use Illuminate\Http\Request;
use App\Models\Task;

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
}
