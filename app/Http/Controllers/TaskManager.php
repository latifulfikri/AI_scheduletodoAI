<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\Step;

class TaskManager extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dataTodo = [
            'todo_name' => $request->taskName,
            'user_id' => Session::get('user_id'),
            'todo_difficulty_level' => $request->taskDifficulty,
            'todo_link' => $request->taskLink,
            'todo_deadline' => $request->taskDeadline,
        ];
        $currentTodo = Todo::insert($dataTodo);
        $taskStep = $request->taskStep;

        for ($i = 0; $i < $taskStep; $i++) {
            $dataStep = [
                'step_name' => $request->input('taskStep'.$i),
                'todo_id' => $currentTodo->todo_id,
                'step_detail' => $request->input('taskDesc'.$i),
                'step_isdone' => 0
            ];
            Step::insert($dataStep);
        }        
        return redirect('/');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
