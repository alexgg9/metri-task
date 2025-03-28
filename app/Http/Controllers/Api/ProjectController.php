<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;


class ProjectController extends Controller
{
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

    public function show(Project $project)
    {
        $this->authorize('view', $project);
        return response()->json($project);
    }

    public function destroy(Project $project)
    {

        $this->authorize('delete', $project);
        $project->delete();
        return response()->json(null, 204);
    }
}
