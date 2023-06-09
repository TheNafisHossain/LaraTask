<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function create()
    {
        return view('project.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:128'
        ]);

        $project = Project::create($request->all());
        return redirect()->route('index');
    }

    public function edit(Project $project)
    {
        return view('project.create', ['project' => $project]);
    }

    public function update(Project $project, Request $request)
    {
        $request->validate([
            'title' => 'required|max:128'
        ]);

        $project->update($request->all());
        return redirect()->route('index');
    }

    public function delete(Project $project)
    {
        $project->delete();
        return redirect()->route('index');
    }
}
