<?php

namespace App\Http\Controllers;

use App\Models\task;
use App\Models\Course;
use App\Models\Classe;
use App\Models\Student;
use App\Models\student_task;
use Illuminate\Console\View\Components\Task as ComponentsTask;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\Request;

class Student_taskController extends Controller
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
        //
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
    public function edit($id): View
    {
        $task = Task::with(['classe', 'courses'])->findOrFail($id);
        $query = student_task::join('students', 'student_tasks.student_id', '=', 'students.id_student')
                    ->join('users', 'students.user_id', '=', 'users.id')
                    ->where('student_tasks.task_id', $id)
                    ->whereNull('student_tasks.deleted_at')
                    ->select('student_tasks.*', 'users.name as name_student', 'users.email as correo_student')
                    ->oldest()->paginate(10);
        return view('Calificar', ['task' => $task , 'datatasks' => $query]);
    }
 
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_student_task): RedirectResponse
    {
        $datatask =student_task::findOrFail($id_student_task);
        $request->validate([
            'note' => 'required|numeric|min:1|max:5'
        ]);
        $datatask->update([
            'note' => $request->note,
            'estado' => 'Calificada'
        ]);
        return redirect()->route("Calificar.edit" , [$datatask->task_id])->with('success', 'La tarea ha sido calificada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
