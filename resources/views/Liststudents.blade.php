@extends('Layout.base')

@section('content')
<div class="row">
    <div>
        <header style="background-color: #f1c40e; width: 100%; position: fixed; top: 0; left: 0; display: flex; justify-content: space-between; align-items: center; padding: 0 5%; height: 100px; z-index: 1000" id="cabecera">
            <div class="iden_per">
                <div>
                    <div class="item">
                        <p style="color: black;  font-size: 25px; margin-top: 2%"><strong>{{Auth::user()->name}}</strong></p>
                    </div>
                </div>
            </div>
            <ul style="display: flex; align-items: center; margin-top: 1%">
                <div>
                    <a href="{{route('courses.index')}}" class="btn btn-primary" style="background-color: #1414b8 ; border-color: #1414b8 ; margin-right: 20px">Volver</a>
                </div>
                <div>
                    <a href="{{route('users.index')}}" class="btn btn-primary" style="background-color: #1414b8 ; border-color: #1414b8 ; margin-right: 20px">Usuarios</a>
                </div>
                <div>
                    <a href="{{route('classes.index')}}" class="btn btn-primary" style="background-color: #1414b8 ; border-color: #1414b8 ; margin-right: 20px">Clases</a>
                </div>
                <form action="{{route("logout")}}" method="POST" class="d-inline" style="margin-left: 20px">
                    @csrf
                    <button type="submit" class="btn btn-danger">Cerrar Sesion</button>
                </form>
            </ul>
        </header>
    </div><br><br><br><br><br><br>
    <div class="col-12">
        <div>
            <h2 class="text-white">Cursos Existentes</h2>
        </div>
    </div>

    @if (Session::get('success'))
        <div class="alert alert-success mt-2">
            <strong>{{Session::get('success')}}</strong><br>
        </div>
    @endif

    <div class="col-12 mt-4">
        <table class="table table-bordered text-white">
            <tr class="text-secondary">
                <th style="color: #fff">Estudiante</th>
                <th style="color: #fff">Correo</th>
                <th style="color: #fff">Tareas Pendientes</th>
                <th style="color: #fff">Tareas Entregadas</th>
                <th style="color: #fff">Tareas con Entrega Tardia</th>
                <th style="color: #fff">Tareas Calificadas</th>
            </tr>
            @foreach ($students as $student)
                <tr>
                    <td>{{$student->name_student}}</td>
                    <td>{{$student->correo_student}}</td>
                    <td>{{$student->empty_tasks}}</td>
                    <td>{{$student->delivered_tasks}}</td>
                    <td>{{$student->late_tasks}}</td>
                    <td>{{$student->graded_tasks}}</td>
                </tr>
            @endforeach
            
        </table>
        {{$students->links()}}
    </div>
</div>
<script>
    document.querySelectorAll('.delete-task-button').forEach(button => {
        button.addEventListener('click', function(event){
            event.preventDefault();
            if(confirm('¿Estas seguro de Eliminar esta tarea?')){
                this.closest('form').submit();
            }
        });
    });
</script>
@endsection