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

        session()->flash('success', 'Task created successfully');

        return response()->json($responseData);
    }

    public function show($id){
        // Logic to create a task
    }

    public function edit($id)
    {
        return Inertia::render('EditTask', [
            'task' => Task::findOrFail($id),
        ]);
    }

    public function update(Request $request)
    {
        $requestData = $request->all();

        $task = Task::findOrFail($requestData['id']);
        $task->titulo = $requestData['titulo'];
        $task->descripcion = $requestData['descripcion'];
        $task->prioridad = $requestData['prioridad'];
        $task->save();

        $responseData = [
            'success' => true,
            'message' => 'Task updated successfully',
            'task' => $task,
        ];

        return response()->json($responseData);
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        $responseData = [
            'success' => true,
            'message' => 'Task deleted successfully',
        ];

        return response()->json($responseData);
    }

    public function complete($id)
    {
        $task = Task::findOrFail($id);
        $task->estado = 'COMPLETADA';
        $task->save();

        $responseData = [
            'success' => true,
            'message' => 'Task completed successfully',
        ];

        return response()->json($responseData);
    }
    
}