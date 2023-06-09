<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $projectId = $request->get('project');

        return view('home', [
            'projects' => Project::all()->sortByDesc('id'),
            'tasks' => $projectId
                ? Task::where('project_id', $projectId)->get()->sortBy('priority')
                : Task::all()->sortBy('priority'),
        ]);
    }
}
