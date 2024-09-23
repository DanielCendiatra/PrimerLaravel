<?php

namespace App\Http\Controllers;

use App\Models\task;
use App\Models\Course;
use App\Models\Classe;
use App\Models\Student;
use App\Models\student_task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use DateTime;
use Illuminate\Console\View\Components\Task as ComponentsTask;
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->rol == 'Docente') {    
            return view('index');
        } 
        else if ($user->rol == 'Administrador'){
            return redirect(route('chart_porcentaje'));
        }
        else {
            return view('welcome');
        }
    }

    public function create(): View
    {
        $user = Auth::user();
        $classes = Classe::where('teacher_id', $user->id)->get();
        $courses = Course::all();  
        return view('crear', ['courses'=> $courses , 'classes'=> $classes]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'Titulo' => 'required', 
            'descripción' => 'required',
            'tarea_date' => 'required|date',
            'course' => 'required|exists:courses,id_course',
            'class' => 'required|exists:classes,id_class'
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
                    'class' => $request->class,
                ]);

                // Obtener todos los estudiantes del curso especificado
                $students = Student::where('course', $request->course)->get();

                // Crear una entrada en student_tasks para cada estudiante
                foreach ($students as $student) {
                    student_task::create([
                        'task_id' => $task->id,
                        'student_id' => $student->id_student,
                        'estado' => 'Vacia'
                    ]);
                    student_task::updated(['updated_at' => Null]);
                }

                return redirect()->route("tasksclassview")->with('success', 'La tarea fue creada exitosamente.');
            } else {
                return redirect()->route("tasks.create")->withErrors('El docente no tiene una clase asignada.');
            }
        } else {
            return redirect()->route("tasksclassview")->withErrors('Solo los docentes pueden crear tareas.');
        }
    }

    public function show(task $task)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(task $task): View
    {
        $courses = Course::all(); 
        return view('Actualizar', ['task' => $task, 'courses'=> $courses]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task): RedirectResponse
    {
        $request->validate([
            'Titulo' => 'required', 
            'descripción' => 'required',
            'tarea_date' => 'required|date',
            'course' => 'required|exists:courses,id_course'
        ]);

        $task->update($request->all());

        if ($request->tarea_date < Carbon::now()) {
            $task->update(['estado' => 'Finalizada']);
        } else if ($request->tarea_date > Carbon::now()) {
            $task->update(['estado' => 'En progreso']);

            // Crear student_tasks para los estudiantes del curso que no tengan esta tarea
            $students = Student::where('course', $request->course)->get();

            foreach ($students as $student) {
                // Verificar si el student ya tiene esta tarea
                $existingStudentTask = student_task::where('task_id', $task->id)
                    ->where('student_id', $student->id_student)
                    ->first();

                if (!$existingStudentTask) {
                    // Crear una nueva tarea para el student
                    student_task::create([
                        'task_id' => $task->id,
                        'student_id' => $student->id_student,
                        'estado' => 'Vacia'
                    ]);
                }
            }

            student_task::where('estado', 'Entrega Tardia')->where('task_id', $task->id)->update(['estado' => 'Entregada']);
        }

        return redirect()->route("tasksclassview")->with('success', 'La tarea fue actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task): RedirectResponse
    {   
        student_task::where('task_id', $task->id)->delete();
        $task->delete();
        return redirect()->route("tasksview")->with('success', 'La tarea fue eliminada exitosamente.');
    }

    public function entregar(Task $task): RedirectResponse
    {
        $user = Auth::user();
        $students = Student::where('user_id', $user->id)->first();
        if ($task->estado == 'En progreso'){
            student_task::where('student_id', $students->id_student )->where('task_id', $task->id)->update(['estado' => 'Entregada', 'updated_at' => now()]);
        }
        else if($task->estado == 'Finalizada'){
            student_task::where('student_id', $students->id_student )->where('task_id', $task->id)->update(['estado' => 'Entrega Tardia', 'updated_at' => now()]);
        }
        else{
            return redirect()->route('Calificar.index')->with('error', 'Esta tarea no es valida.');
        };
        return redirect()->route('Calificar.index')->with('success', 'La tarea ha sido entregada.');
    }

    public function getTasksByClass()
    {
        $tasks = DB::table('tasks')
            ->join('classes', 'tasks.class', '=', 'classes.id_class') 
            ->select(
                DB::raw('MONTH(tasks.created_at) as mes'),
                'classes.name_class',
                DB::raw('COUNT(tasks.id) as cantidad')
            )
            ->whereYear('tasks.created_at', date('Y')) 
            ->whereNull('tasks.deleted_at')
            ->groupBy('mes', 'classes.name_class')
            ->orderBy('mes', 'desc')
            ->get();

        $data = [];
        $meses = [];

        foreach ($tasks as $task) {
            if (!isset($data[$task->name_class])) {
                $data[$task->name_class] = [];
            }

            if (!in_array($task->mes, $meses)) {
                $meses[] = $task->mes;
            }

            $data[$task->name_class][$task->mes] = $task->cantidad;
        }

        $series = [];
        foreach ($data as $class => $taskData) {
            $mesData = [];
            foreach ($meses as $mes) {
                $mesData[] = $taskData[$mes] ?? 0;
            }
            $series[] = [
                'name' => $class,
                'data' => $mesData
            ];
        }

        $nombresMeses = array_map(function($mes) {
            return DateTime::createFromFormat('!m', $mes)->format('F');
        }, $meses);

        return response()->json([
            'series' => $series,
            'categories' => $nombresMeses
        ]);
    }       

    public function restore($id): RedirectResponse
    {
        $task = Task::withTrashed()->where('id', $id)->first();
        if ($task) {
            $task->restore();
            student_task::withTrashed()->where('task_id', $task->id)->restore();

            if ($task->tarea_date < Carbon::now()) {
                $task->update(['estado' => 'Finalizada']);
            } else if ($task->tarea_date > Carbon::now()) {
                $task->update(['estado' => 'En progreso']);
    
                // Crear student_tasks para los estudiantes del curso que no tengan esta tarea
                $students = Student::where('course', $task->course)->get();
    
                foreach ($students as $student) {
                    // Verificar si el student ya tiene esta tarea
                    $existingStudentTask = student_task::where('task_id', $task->id)
                        ->where('student_id', $student->id_student)
                        ->first();
    
                    if (!$existingStudentTask) {
                        // Crear una nueva tarea para el student
                        student_task::create([
                            'task_id' => $task->id,
                            'student_id' => $student->id_student,
                            'estado' => 'Vacia'
                        ]);
                    }
                }
            }
            return redirect()->route('tasksclassview')->with('success', 'La tarea fue restaurado exitosamente.');
        }  
        return redirect()->route('tasksclassview')->with('error', 'La tarea no se encontró o ya fue restaurada.');
    }


    public function seeTasksAdmin(Request $request): View
    {
        $query = Task::join('classes', 'tasks.class', '=', 'classes.id_class')
            ->join('courses', 'tasks.course', '=', 'courses.id_course')
            ->select('tasks.*', 'courses.name_course as course' , 'classes.name_class as class');
            
        $tasks = $query->oldest()->get(); 
        return view('tasks_admin', ['tasks' => $tasks]);
    }


    public function seeactivities(Request $request): View
    {
        $user = Auth::user();
        
        $classes = Classe::where('teacher_id', $user->id)->get();
        $selectedClass = request('filter');
        
        if ($selectedClass) {
            $tasks = Task::where('class', $selectedClass)
                ->oldest()
                ->get();

        
            $deletasks = Task::onlyTrashed()
                ->where('class', $selectedClass)
                ->oldest()
                ->get();
   
        } else {
            $classe = Classe::where('teacher_id', $user->id)->first();
            if ($classe) {
                $tasks = Task::where('class', $classe->id_class)
                    ->oldest()
                    ->get();
        
                $deletasks = Task::onlyTrashed()
                    ->where('class', $classe->id_class)
                    ->oldest()
                    ->get();
            } else {
                $tasks = collect();
                $deletasks = collect();
            }
        }
        
        return view('tasks_D', ['tasks' => $tasks, 'classes' => $classes, 'deletasks' => $deletasks]);
        
    }

    public function calcular_porcentaje(): View
    {
        $alums = User::where('rol', 'Alumno')
            ->whereNull('deleted_at')
            ->count();

        $docen = User::where('rol', 'Docente')
            ->whereNull('deleted_at')
            ->count();

        $cursos = Course::whereNull('deleted_at')
            ->count();

        $clases = Classe::whereNull('deleted_at')
            ->count();

        $tareas = Task::whereNull('deleted_at')
            ->count();

        $classesP = Classe::whereNull('deleted_at')
            ->get();

        $tareasF = Task::whereNull('deleted_at')
            ->where('estado', 'Finalizada')
            ->count();

        $tareasP = Task::whereNull('deleted_at')
            ->where('estado', 'En progreso')
            ->count();

        $porcientoF = round((100 * $tareasF) / $tareas , 1);
        $porcientoP = round((100 * $tareasP) / $tareas, 1);

        $porcientoT = [];
        $porcentajeCalificadas = [];
        $colores = ['#0d6efd', '#6f42c1', '#20c997', '#ffc107', '#0dcaf0', '#dc3545', '#198754', '#fd7e14', '#d63384'];
        $icons = ['bx-book-reader', 'bx-test-tube', 'bx-medal', 'bx-grid-alt', 'bx-pin', 'bx-award', 'bx-bulb', 'bx-map-pin', 'bx-cube-alt'];

        foreach ($classesP as $index => $classP) {
            $tasks_cantidad = Task:: where('class' , $classP->id_class)
                ->whereNull('deleted_at')
                ->count();

            $tasks_porcentaje = round((100 * $tasks_cantidad) / $tareas, 1);

            $color = $colores[$index % count($colores)];
            $icon = $icons[$index % count($icons)]; 

            $taskIds = Task::where('class',  $classP->id_class)
                ->where('estado' , 'Finalizada')
                ->whereNull('deleted_at')
                ->pluck('id');
            

            $students = Student_task::whereIn('task_id', $taskIds)
                ->distinct('student_id') 
                ->count('student_id');

            $studentsAlDia = Student_task::whereIn('task_id', $taskIds)
                ->whereIn('estado', ['Entregada', 'Entrega Tardia', 'Calificada'])
                ->groupBy('student_id')
                ->selectRaw('COUNT(DISTINCT task_id) as entregadas, student_id') 
                ->havingRaw('entregadas = ?', [count($taskIds)]) 
                ->count('student_id');

            $porcentajealdia = round((100 * $studentsAlDia) / $students, 1);
            
           
            $porcentajeCalificadas[] = [
                'porcentajealdia' => $porcentajealdia,
                'dia' => $studentsAlDia,
                'name' => $classP->name_class,
                'canti' => $students,
                'color' => $color,
                'icon' => $icon
            ];

            $porcientoT[] = [
                'name' => $classP->name_class,
                'data' => $tasks_porcentaje,
                'cantidad' => $tasks_cantidad,
                'color' => $color,
                'icon' => $icon
            ];
        }

        return view('AdminDash', ['alumnos' => $alums, 'docentes' => $docen, 'cursos' => $cursos, 'clases' => $clases, 
            'tareas' => $tareas, 'tareasF' => $tareasF, 'tareasP' => $tareasP, 'porcientoF' => $porcientoF,
            'porcientoP' => $porcientoP, 'porcientoT' => $porcientoT, 'porcentajeCalificadas' => $porcentajeCalificadas]);
    }

}
