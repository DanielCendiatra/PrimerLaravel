<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\User;
use App\Models\Course;
use App\Models\Classe;
use App\Models\Student;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showRegisterForm(): View 
    {
        $classes = Classe::whereNull('teacher_id')->get();
        $courses = Course::all();
        return view('registro', ['classes'=> $classes , 'courses'=> $courses]);
    }
     

    public function register(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'rol' => 'required|string|in:Docente,Alumno',
            'extra_field' => 'required_if:rol,Docente,Alumno',
        ]);

        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->rol = $request->rol;

        $user->save();

        if ($request->rol === 'Docente') 
        { 
            $classe = Classe::find($request->extra_field); 
            if ($classe) { 
                $classe->teacher_id = $user->id; 
                $classe->save(); 
            } 
        } 
        else if ($request->rol === 'Alumno') 
        { 
            $student = new Student(); 
            $student->user_id = $user->id; 
            $student->course = $request->extra_field; 
            $student->save(); 
        }

        Auth::login($user);

        return redirect(route('login'));
    }

    public function login(Request $request){
        $credentials = [
            "email" => $request->email,
            "password" => $request->password
        ];

        $remember = ($request->has('remember') ? true : false);

        if(Auth::attempt($credentials, $remember)){
            $request->session()->regenerate();
            return redirect(route('tasks.index'));
        }else{
            return redirect('login');
        }
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('login'));
    }
}
