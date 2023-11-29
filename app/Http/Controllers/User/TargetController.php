<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\TargetRequest;
use App\Models\Goal;
use App\Models\Target;
use Illuminate\Http\Request;

class TargetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $targets = Target::with('goal:id,name')
            ->withCount('tasks')
            ->when($request->input('search'), function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->paginate(7)
            ->withQueryString()
            ->through(fn ($target) => [
                'id' => $target->id,
                'goal_name' => $target->goal->name,
                'name' => $target->name,
                'position' => $target->position,
                'type_label' => $target->type_label,
                'tasks_count' => $target->tasks_count
            ]);

        $filters = $request->only(['search']);

        return inertia('User/Target/Index', compact('targets', 'filters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $goals = Goal::select('id', 'name')->get();

        return inertia('User/Target/Create', compact('goals'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TargetRequest $request)
    {
        $position = Target::max('position') + 1 ?? 1;

        Target::create(array_merge($request->validated(), ['position' => $position]));

        return redirect()->route('user.targets.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Target $target)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Target $target)
    {
        $goals = Goal::select('id', 'name')->get();

        return inertia('User/Target/Edit', compact('target', 'goals'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TargetRequest $request, Target $target)
    {
        $target->update($request->validated());

        return redirect()->route('user.targets.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Target $target)
    {
        $target->delete();

        return redirect()->route('user.targets.index');
    }
}
