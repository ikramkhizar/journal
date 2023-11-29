<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Models\Goal;
use App\Models\Target;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tasks = Task::with(['goal', 'target'])
            ->when($request->input('search'), function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->paginate(7)
            ->withQueryString()
            ->through(fn ($task) => [
                'id' => $task->id,
                'goal_name' => $task->goal->name,
                'target_name' => $task->target->name,
                'name' => $task->name,
                // 'description' => $task->description ? substr($task->description, 0, 50) . '...' : '',
                'status_label' => $task->status_label,
                'priority' => $task->priority,
                'priority_label' => $task->priority_label,
                'due_date' => $task->due_date
            ]);

        $filters = $request->only(['search']);

        return inertia('User/Task/Index', compact('tasks', 'filters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $goals = Goal::select('id', 'name')->get();

        return inertia('User/Task/Create', compact('goals'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        Task::create($request->validated());

        return redirect()->route('user.tasks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $task->load('goal');

        $goals = Goal::select('id', 'name')->get();

        $targets = Target::where('goal_id', $task->goal->id)->get();

        return inertia('User/Task/Edit', compact('task', 'goals', 'targets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, Task $task)
    {
        $task->update($request->validated());

        return redirect()->route('user.tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('user.tasks.index');
    }

    public function targets(Request $request)
    {
        $goal_id = $request->get('goal_id');

        $targets = Target::where('goal_id', $goal_id)->get();

        return response()->json($targets);
    }
}
