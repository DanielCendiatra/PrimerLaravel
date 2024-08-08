<?php

namespace App\Http\Controllers;

use App\Models\classe;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\task;
use App\Models\student_task;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ClasseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $clases = DB::table('classes')
            ->leftJoin('users', 'classes.teacher_id', '=', 'users.id')
            ->leftJoin('tasks', 'classes.id_class', '=', 'tasks.class')
            ->select('classes.teacher_id', 'classes.id_class', 'classes.name_class', 'classes.created_at', 'users.name as nombre', 'users.email as correo', DB::raw('count(tasks.id) as total'))
            ->whereNull('classes.deleted_at')
            ->whereNull('tasks.deleted_at')
            ->groupBy('classes.teacher_id', 'classes.id_class', 'classes.name_class', 'classes.created_at', 'users.name', 'users.email')
            ->oldest()->paginate(10);

        $deleteclases = DB::table('classes')
            ->leftJoin('users', 'classes.teacher_id', '=', 'users.id')
            ->leftJoin('tasks', 'classes.id_class', '=', 'tasks.class')
            ->select('classes.id_class', 'classes.name_class', 'classes.created_at', 'users.name as nombre', 'users.email as correo', DB::raw('count(tasks.id) as total'))
            ->whereNotNull('classes.deleted_at')
            ->groupBy('classes.id_class', 'classes.name_class', 'classes.created_at', 'users.name', 'users.email')
            ->oldest()->paginate(10);

        $teachers = User::where('rol' , 'Docente')->get();  
    
        return view('Clases', ['clases' => $clases , 'deleteclases' => $deleteclases , 'teachers'=> $teachers]);
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
            'name_class' => 'required', 
            'docente' => 'required|exists:users,id',
        ]);

        $user = Auth::user();

        if($user->rol == 'Administrador') {
            
                classe::create([
                    'name_class' => $request->name_class,
                    'teacher_id' => $request->docente
                ]);

                return redirect()->route("classes.index")->with('success', 'La clase fue creada exitosamente.');
        } else {
            return redirect()->route("classes.index")->withErrors('Solo un administrador puede crear clases.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(classe $classe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(classe $classe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_class): RedirectResponse
    {
        $datatask =classe::findOrFail($id_class);   
        $request->validate([
            'name' => 'required',
            'docente' => 'required'
        ]);
        $datatask->update([
            'name_class' => $request->name,
            'teacher_id' => $request->docente
        ]);
        return redirect()->route("classes.index")->with('success', 'La clase ha sido actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_class): RedirectResponse
    {
        $tasks = task::where('class', $id_class)->get();
        foreach ($tasks as $tas){
            student_task::where('task_id', $tas->id)->delete();
            $tas->delete();
        }
        classe::where('id_class' , $id_class)->delete();
        return redirect()->route("classes.index")->with('success', 'La Clase fue eliminada exitosamente.');
    }

    public function restore($id_class): RedirectResponse
    {
        $class = Classe::withTrashed()->where('id_class', $id_class)->first();
        if ($class) {
            $class->restore();
            $tasks = Task::withTrashed()->where('class', $id_class)->get();
            foreach ($tasks as $task) {
                $task->restore();
                student_task::withTrashed()->where('task_id', $task->id)->restore();
            }

            return redirect()->route('classes.index')->with('success', 'La Clase fue restaurada exitosamente.');
        }

        return redirect()->route('classes.index')->with('error', 'La Clase no se encontró o ya fue restaurada.');
    }
}
