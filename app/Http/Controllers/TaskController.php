<?php

namespace App\Http\Controllers;

use App\Models\task;
use Illuminate\Console\View\Components\Task as ComponentsTask;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Stmt\Return_;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $tasks = Task::oldest()->paginate(10);
        if(Auth::user()->rol == 'Docente'){
            return view('index', ['tasks'=> $tasks]);
        }else{
            return view('entrega', ['tasks'=> $tasks]);
        }
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('crear');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'Titulo' => 'required', 
            'descripción' => 'required'
        ]);
        Task::create($request->all());
        return redirect()->route("tasks.index")->with('success', 'La tarea fue creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(task $task)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(task $task): View
    {
        return view('Actualizar', ['task' => $task]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, task $task): RedirectResponse
    {
        $request->validate([
            'Titulo' => 'required', 
            'descripción' => 'required'
        ]);
        $task->update($request->all());
        return redirect()->route("tasks.index")->with('success', 'La tarea fue actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(task $task)
    {
        $task->delete();
        return redirect()->route("tasks.index")->with('success', 'La tarea fue Eliminada exitosamente.');
    }

    public function entregar(Task $task): RedirectResponse
    {
        $task->update(['estado' => 'Completada']);
        return redirect()->route('tasks.index')->with('success', 'La tarea ha sido entregada.');
    }
}
