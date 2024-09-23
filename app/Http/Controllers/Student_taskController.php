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
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\View\View;
use Illuminate\Http\Request;

class Student_taskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();

        $student = Student::where('user_id', $user->id)->first();
            if ($student) {
                $tasks = DB::table('tasks')
                    ->join('student_tasks', 'tasks.id', '=', 'student_tasks.task_id')
                    ->join('classes', 'tasks.class', '=', 'classes.id_class')
                    ->where('student_tasks.student_id', $student->id_student)
                    ->where('student_tasks.deleted_at', Null)
                    ->select('tasks.*', 'student_tasks.estado as student_task_estado' , 'student_tasks.note as student_task_nota', 'classes.name_class as name_class')->oldest()->get();
            } else {
                $tasks = collect(); 
            }

            return view('entrega', ['tasks' => $tasks]);
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
                    ->oldest()->get();
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

    public function generateReport($id_student)
    {
        // Obtener el estudiante y su curso usando la clave primaria correcta
        $student = Student::where('id_student', $id_student)->firstOrFail();
        $course_id = $student->course;
        $course_s = Course::where('id_course', $student->course)->first();
    
        // Obtener las clases que tienen al menos una tarea asociada con el curso del estudiante
        $classes = Classe::whereHas('tasks', function ($query) use ($course_id) {
            $query->where('course', $course_id);
        })->get();
    
        $data = [];
    
        // Para cada clase, calcular el promedio de las notas de las tareas finalizadas
        foreach ($classes as $class) {
            $promedio = student_task::join('tasks', 'student_tasks.task_id', '=', 'tasks.id')
                ->where('student_tasks.student_id', $student->id_student) 
                ->where('tasks.class', $class->id_class)
                ->where('tasks.estado', 'Finalizada')
                ->whereNull('student_tasks.deleted_at')
                ->avg('student_tasks.note');

            $promedio = round($promedio, 1);

            $tareas_vacias = student_task::join('tasks', 'student_tasks.task_id', '=', 'tasks.id')
                ->where('student_tasks.student_id', $student->id_student)
                ->where('tasks.class', $class->id_class)
                ->where('tasks.estado', 'Finalizada')
                ->where('student_tasks.estado', 'Vacia')
                ->whereNull('student_tasks.deleted_at')
                ->count();

            $Ntasks = task::where('class', $class->id_class)
                ->where('course', $student->course)
                ->where('estado', 'Finalizada')
                ->whereNull('deleted_at')
                ->count();
            
            if ($promedio <= 2.0){
                $desempeño = 'Insuficiente';
            }
            if ($promedio > 2.0 && $promedio <= 3.3){
                $desempeño = 'Medio Bajo';
            }
            if ($promedio >= 3.4 && $promedio < 4.0){
                $desempeño = 'Medio';
            }
            if ($promedio >= 4.0 && $promedio <= 4.6){
                $desempeño = 'Alto';
            }
            if ($promedio >= 4.7){
                $desempeño = 'Sobresaliente';
            }

            $data[] = [
                'class_name' => $class->name_class,
                'promedio' => $promedio,
                'Ntasks' => (int) $Ntasks,
                'tareas_vacias' => (int) $tareas_vacias,
                'desempeño' => $desempeño
            ];
        }
    
        // Generar el PDF usando los datos
        $pdf = Pdf::loadView('certificado', compact('student', 'data', 'course_s'));
    
        // Descargar el PDF
        return $pdf->download('certificado' . $student->user->name . '.pdf');
    }

}
