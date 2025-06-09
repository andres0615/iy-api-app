<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $taskModel = new Task();
        $tasks = $taskModel->all();

        $response = response()->json([
            'tasks' => $tasks,
        ]);

        return $response;
    }

    public function create()
    {
        return Inertia::render('AddTask');
    }

    public function store(Request $request)
    {
        $requestData = $request->all();

        $task = new Task();
        $task->titulo = $requestData['titulo'];
        $task->descripcion = $requestData['descripcion'];
        $task->prioridad = $requestData['prioridad'];
        $task->estado = 'PENDIENTE';
        $task->save();

        $responseData = [
            'success' => true,
            'message' => 'Task created successfully',
            'task' => $task,
        ];

        return response()->json($responseData);
    }

    public function show($id){
        // Logic to create a task
    }

    public function edit($id)
    {
        // Logic to create a task
    }

    public function update(Request $request)
    {
        // Logic to create a task
    }

    public function destroy($id)
    {
        // Logic to create a task
    }
    
}