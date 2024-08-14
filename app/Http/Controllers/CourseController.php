<?php

namespace App\Http\Controllers;

use App\Models\course;
use App\Models\student;
use App\Models\task;
use App\Models\student_task;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $courses = DB::table('courses')
            ->leftJoin('students', function($join) {
                $join->on('courses.id_course', '=', 'students.course')
                ->whereNull('students.deleted_at');
            })
            ->leftJoin(DB::raw("(SELECT course, COUNT(*) as total_progress_tasks FROM tasks WHERE estado = 'En progreso' AND deleted_at IS NULL GROUP BY course) as progress_tasks"), function($join) {
                $join->on('courses.id_course', '=', 'progress_tasks.course');
            })
            ->leftJoin(DB::raw("(SELECT course, COUNT(*) as total_final_tasks FROM tasks WHERE estado = 'Finalizada' AND deleted_at IS NULL GROUP BY course) as final_tasks"), function($join) {
                $join->on('courses.id_course', '=', 'final_tasks.course');
            })
            ->select('courses.id_course', 'courses.name_course', 'courses.created_at',
                DB::raw('COUNT(DISTINCT students.id_student) as total'),
                DB::raw("COALESCE(progress_tasks.total_progress_tasks, 0) as progress_tasks"),
                DB::raw("COALESCE(final_tasks.total_final_tasks, 0) as finaly_tasks")
            )
            ->whereNull('courses.deleted_at')
            ->groupBy('courses.id_course', 'courses.name_course', 'courses.created_at', 'progress_tasks.total_progress_tasks', 'final_tasks.total_final_tasks')
            ->oldest()
            ->paginate(10);

        $deletecouses = DB::table('courses')
            ->leftJoin('students', 'courses.id_course', '=', 'students.course')
            ->select('courses.id_course', 'courses.name_course', 'courses.created_at',  DB::raw('count(students.id_student) as total'))
            ->whereNotNull('courses.deleted_at')
            ->groupBy('courses.id_course', 'courses.name_course', 'courses.created_at')
            ->oldest()->paginate(10);

        return view('Cursos', ['couses' => $courses , 'deletecouses' => $deletecouses]);
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
    public function store(Request $request):RedirectResponse
    {
        $request->validate([
            'name_course' => 'required'
        ]);

        $user = Auth::user();

        if($user->rol == 'Administrador') {
            
                course::create([
                    'name_course' => $request->name_course
                ]);

                return redirect()->route("courses.index")->with('success', 'El curso fue creado exitosamente.');
        } else {
            return redirect()->route("courses.index")->withErrors('Solo un administrador puede crear cursos.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id_course): View
    {
        $students = student::leftjoin('users', 'students.user_id', '=', 'users.id')
            ->leftJoin('student_tasks', 'students.id_student', '=', 'student_tasks.student_id')
            ->where('course' , $id_course)
            ->whereNull('student_tasks.deleted_at')
            ->select('students.*', 'users.name as name_student', 'users.email as correo_student',
                DB::raw("SUM(CASE WHEN student_tasks.estado = 'Vacia' THEN 1 ELSE 0 END) as empty_tasks"),
                DB::raw("SUM(CASE WHEN student_tasks.estado = 'Entregada' THEN 1 ELSE 0 END) as delivered_tasks"),
                DB::raw("SUM(CASE WHEN student_tasks.estado = 'Calificada' THEN 1 ELSE 0 END) as graded_tasks"),
                DB::raw("SUM(CASE WHEN student_tasks.estado = 'Entrega Tardia' THEN 1 ELSE 0 END) as late_tasks")
            )
            ->groupBy('students.id_student', 'users.name', 'users.email')
            ->oldest()->paginate(10);

        return view('Liststudents', ['students' => $students]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_course):RedirectResponse
    {
        $datatask =course::findOrFail($id_course);   
        $request->validate([
            'name_course' => 'required'
        ]);
        $datatask->update([
            'name_course' => $request->name_course,
            'updated_at' => now()
        ]);
        return redirect()->route("courses.index")->with('success', 'El Curso ha sido actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_course):RedirectResponse
    {
        $tasks = task::where('course', $id_course)->get();
        foreach ($tasks as $tas){
            student_task::where('task_id', $tas->id)->delete();
            $tas->delete();
        }
        course::where('id_course' , $id_course)->delete();
        return redirect()->route("courses.index")->with('success', 'La Clase fue eliminada exitosamente.');
    }


    public function restore($id_course): RedirectResponse
    {
        $course = course::withTrashed()->where('id_course', $id_course)->first();
        if ($course) {
            $course->restore();
            $tasks = Task::withTrashed()->where('course', $id_course)->get();
            foreach ($tasks as $task) {
                $task->restore();
                student_task::withTrashed()->where('task_id', $task->id)->restore();
            }

            return redirect()->route('courses.index')->with('success', 'El curso fue restaurada exitosamente.');
        }

        return redirect()->route('courses.index')->with('error', 'El curso no se encontró o ya fue restaurada.');
    }
}
