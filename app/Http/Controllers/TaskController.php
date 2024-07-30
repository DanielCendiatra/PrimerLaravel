<?php

namespace App\Http\Controllers;

use App\Models\task;
use App\Models\Course;
use App\Models\Classe;
use App\Models\Student;
use App\Models\student_task;
use Illuminate\Console\View\Components\Task as ComponentsTask;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();

        if ($user->rol == 'Docente') {
            $classe = Classe::where('teacher_id', $user->id)->first();
            if ($classe) {
                $tasks = Task::where('class', $classe->id_class)->oldest()->paginate(10);
            } else {
                $tasks = collect(); 
            }

            return view('index', ['tasks' => $tasks]);
        } else {
            $student = Student::where('user_id', $user->id)->first();
            if ($student) {
                $query = DB::table('tasks')
                    ->join('student_tasks', 'tasks.id', '=', 'student_tasks.task_id')
                    ->join('classes', 'tasks.class', '=', 'classes.id_class')
                    ->where('student_tasks.student_id', $student->id_student)
                    ->where('student_tasks.deleted_at', Null)
                    ->select('tasks.*', 'student_tasks.estado as student_task_estado' , 'student_tasks.note as student_task_nota');

                    switch ($request->filter) {
                        case 'name':
                            $query->where('tasks.Titulo', 'like', '%' . $request->search . '%');
                            break;
                        case 'date':
                            $query->whereDate('tasks.tarea_date', $request->search);
                            break;
                        case 'estado':
                            $query->where('student_tasks.estado', $request->search);
                            break;
                        case 'note':
                            $query->where(DB::raw('LEFT(student_tasks.note, 1)'), $request->search);
                            break;
                        case 'class':
                            $query->where('classes.name_class', 'like', '%' . $request->search . '%');
                            break;
                    }

                    $tasks = $query->oldest()->paginate(10);
            
            } else {
                $tasks = collect(); 
            }

            return view('entrega', ['tasks' => $tasks]);
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $courses = Course::all();  
        return view('crear', ['courses'=> $courses]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'Titulo' => 'required', 
            'descripción' => 'required',
            'tarea_date' => 'required|date',
            'course' => 'required|exists:courses,id_course',
        ]);

        $user = Auth::user();

        if($user->rol == 'Docente') {
            $classe = Classe::where('teacher_id', $user->id)->first();
            if ($classe) {
                $task = Task::create([
                    'Titulo' => $request->Titulo,
                    'descripción' => $request->descripción,
                    'tarea_date' => $request->tarea_date,
                    'course' => $request->course,
                    'estado' => 'En progreso',
                    'class' => $classe->id_class,
                ]);

                // Obtener todos los estudiantes del curso especificado
                $students = Student::where('course', $request->course)->get();

                // Crear una entrada en student_tasks para cada estudiante
                foreach ($students as $student) {
                    student_task::create([
                        'task_id' => $task->id,
                        'student_id' => $student->id_student,
                        'estado' => 'Vacia',
                    ]);
                }

                return redirect()->route("tasks.index")->with('success', 'La tarea fue creada exitosamente.');
            } else {
                return redirect()->route("tasks.create")->withErrors('El docente no tiene una clase asignada.');
            }
        } else {
            return redirect()->route("tasks.index")->withErrors('Solo los docentes pueden crear tareas.');
        }
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
    public function destroy(Task $task): RedirectResponse
    {   
        student_task::where('task_id', $task->id)->delete();
        $task->delete();
        return redirect()->route("tasks.index")->with('success', 'La tarea fue eliminada exitosamente.');
    }

    public function entregar(Task $task): RedirectResponse
    {
        $user = Auth::user();
        $task->update(['estado' => 'Finalizada']);
        $students = Student::where('user_id', $user->id)->first();
        student_task::where('student_id', $students->id_student )->where('task_id', $task->id)->update(['estado' => 'Entregada']);
        return redirect()->route('tasks.index')->with('success', 'La tarea ha sido entregada.');
    }
}
