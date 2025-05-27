<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;


class ProjectController extends Controller
{

    public function index()
    {
        $this->authorize('viewAny', Project::class);

        $projects = Project::with(['tasks', 'users', 'creator'])->get()->map(function ($project) {
            $project->calculateProgress();
            return $project;
        });

        return response()->json($projects);
    }


    public function store(ProjectRequest $request)
    {
        $this->authorize('create', Project::class);
        $project = Project::create($request->validated());
        return response()->json($project, 201);
    }

    public function update(ProjectRequest $request, Project $project)
    {
        $this->authorize('update', $project);
        $project->update($request->validated());

        return response()->json($project);
    }

    public function show($id)
    {
        $project = Project::with(['creator', 'tasks', 'users'])->findOrFail($id);
        $this->authorize('viewAny', $project);
        return response()->json($project);
    }

    public function destroy(Project $project)
    {

        $this->authorize('delete', $project);
        $project->delete();
        return response()->json(null, 204);
    }

    public function getProjectTasks(Project $project)
    {
        $this->authorize('viewAny', Project::class);

        $tasks = $project->tasks;

        return response()->json($tasks);
    }
}
