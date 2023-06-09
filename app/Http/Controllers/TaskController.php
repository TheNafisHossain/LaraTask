<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function create()
    {
        return view('task.create', ['projects' => Project::all()->sortByDesc('id')]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:128',
            'project' => 'required'
        ]);

        $maxPriority = Task::max('priority');
        $priority = $maxPriority ? $maxPriority + 1 : 1;

        $task = Task::create([
            'project_id' => $request->project,
            'title' => $request->title,
            'priority' => $priority,
        ]);

        return redirect()->route('index');
    }

    public function edit(Task $task)
    {
        return view('task.create', [
            'task' => $task,
            'projects' => Project::all()->sortByDesc('id'),
        ]);
    }

    public function update(Task $task, Request $request)
    {
        $request->validate([
            'title' => 'required|max:128',
            'project' => 'required'
        ]);

        $task->update([
            'project_id' => $request->project,
            'title' => $request->title,
        ]);

        return redirect()->route('index');
    }

    public function updatePriorities(Request $request)
    {
        $sortedItems = $request->sortedItems;
        foreach ($sortedItems as $newIndex => $itemId) {
            Task::where('id', $itemId)->update(['priority' => $newIndex + 1]);
        }

        return response()->json('ok');
    }

    public function delete(Task $task)
    {
        $task->delete();
        return redirect()->route('index');
    }
}
