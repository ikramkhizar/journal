<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\GoalRequest;
use App\Models\Goal;
use Illuminate\Http\Request;
use Inertia\Response;

class GoalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $goals = Goal::withCount(['targets', 'tasks'])
            ->when($request->input('search'), function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->paginate(7)
            ->withQueryString()
            ->through(fn ($goal) => [
                'id' => $goal->id,
                'name' => $goal->name,
                'description' => $goal->description ? substr($goal->description, 0, 30) . '...' : '',
                'start_date' => $goal->start_date,
                'due_date' => $goal->due_date,
                'targets_count' => $goal->targets_count ?? 0,
                'tasks_count' => $goal->tasks_count ?? 0,
            ]);

        $filters = $request->only(['search']);

        return inertia('User/Goal/Index', compact('goals', 'filters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('User/Goal/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GoalRequest $request)
    {
        Goal::create($request->validated());

        return redirect()->route('user.goals.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Goal $goal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Goal $goal)
    {
        return inertia('User/Goal/Edit', compact('goal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GoalRequest $request, Goal $goal)
    {
        $goal->update($request->validated());

        return redirect()->route('user.goals.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Goal $goal)
    {
        $goal->delete();

        return redirect()->route('user.goals.index');
    }
}
