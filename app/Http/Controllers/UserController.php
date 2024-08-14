<?php

namespace App\Http\Controllers;

use App\Models\student;
use App\Models\User;
use App\Models\student_task;
use App\Models\Classe;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        switch ($request->filter) {
            case 'Administradores':
                $tipe = '1';
                $users = User::where('rol', 'Administrador')->whereNull('deleted_at')->oldest()->paginate(10);;
                return view('ListUser' , ['tipe' => $tipe , 'users' => $users]);
            break;
            case 'Docentes':
                $tipe = '2';
                $users = User::where('users.rol', 'Docente')    
                    ->whereNull('users.deleted_at')
                    ->leftJoin('classes', 'users.id', '=', 'classes.teacher_id')
                    ->whereNull('classes.deleted_at')
                    ->select('users.*', DB::raw('GROUP_CONCAT(classes.name_class SEPARATOR ", ") as classes'))
                    ->groupBy('users.id', 'users.name', 'users.email', 'users.created_at', 'users.updated_at')
                    ->oldest()->paginate(10);
                    return view('ListUser', ['tipe' => $tipe, 'users' => $users]);
            break;
            case 'Alumnos':
                $tipe = '3';
                $users = User::Join('students', 'users.id', '=', 'students.user_id')
                    ->Join('courses', 'students.course' , 'courses.id_course')
                    ->where('users.rol', 'Alumno')    
                    ->whereNull('users.deleted_at')
                    ->select('users.*', 'courses.name_course as course')
                    ->oldest()->paginate(10);
                return view('ListUser' , ['tipe' => $tipe , 'users' => $users]);
            break;
            case 'Usuarios Activos':
                $tipe = '4';
                $users = User::whereNull('deleted_at')->oldest()->paginate(10);
                return view('ListUser' , ['tipe' => $tipe , 'users' => $users]);
            break;
            case 'Usuarios Eliminados':
                $tipe = '5';
                $users = DB::table('users')->whereNotNull('deleted_at')->oldest()->paginate(10);
                return view('ListUser' , ['tipe' => $tipe , 'users' => $users]);
            break;
            case '':
                $tipe = '6';
                return view('ListUser' , ['tipe' => $tipe]);
            break;
        }
        
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
    public function show(User $User)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::where('id', $id)->first();

        if ($user->rol == 'Alumno') {
            $user = User::join('students', 'users.id', '=', 'students.user_id')
                ->join('courses', 'students.course', '=', 'courses.id_course')
                ->where('users.id', $id)
                ->select('users.*', 'courses.name_course as course', 'courses.id_course as idcourse')
                ->first();
        }

        $courses = Course::all(); 
        return view('ActualizarUser', ['id' => $id, 'courses'=> $courses, 'tipe' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'correo' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('correo');

        if ($user->rol == 'Alumno') {
            $student = Student::where('user_id', $user->id)->first();
            $student->course = $request->input('course');
            $student->save();
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $user = User::where('id', $id)->first();
    
        if ($user->rol == 'Docente'){
            $classe = Classe::where('teacher_id', $user->id)->get();
            foreach ($classe as $class){
                Classe::where('id_class', $class->id_class)->update([
                    'teacher_id' => null
                ]);     
            }
            $user->delete();
        }
        else if ($user->rol == 'Administrador'){
            $user->delete();
        }
        else if ($user->rol == 'Alumno'){
            $students = student::where('user_id', $user->id)->get();
            foreach ($students as $student) {
                student_task::where('student_id', $student->id_student)->delete();
                $student->where('id_student', $student->id_student)->delete();
            }
            $user->delete();
        } 

        return redirect()->route("users.index")->with('success', 'El usuario fue eliminada exitosamente.');
    }

    public function restore($id): RedirectResponse
    {
        $user = User::withTrashed()->where('id', $id)->first();
        if ($user) {
            $user->restore();
            if ($user->rol == 'Alumno'){
                $students = student::withTrashed()->where('user_id', $user->id)->first();
                if($students){
                    $students->where('id_student', $students->id_student)->restore();
                    student_task::withTrashed()->where('student_id', $students->id_student)->restore();
                }
                
            }
            return redirect()->route('users.index')->with('success', 'El Usuario fue restaurado exitosamente.');
        }  
        return redirect()->route('users.index')->with('error', 'El Usuario no se encontró o ya fue restaurada.');
    }

}
