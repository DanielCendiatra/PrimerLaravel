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
                    <a href="{{route('tasks.index')}}" class="btn btn-primary" style="background-color: #1414b8 ; border-color: #1414b8 ; margin-right: 20px">Volver</a>
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
    <div class="col-12 mt-4" style="display: flex; align-items:center">
        <form method="POST" action="{{ route('courses.store') }}" class="form-inline">
            @csrf
            <div class="form-group mx-sm-3 mb-4">
                <label for="name_course" class="sr-only mb-2">Nombre</label>
                <input type="text" class="form-control" id="name_course" name="name_course" placeholder="Nombre">
            </div>
            <button type="submit" class="btn btn-primary mb-4" style="margin-left: 7% ; background-color: #2ECC71; border-color: #2ECC71; color: #fff">Crear Curso</button>
        </form>
    </div>
    <div class="col-12 mt-4">
        <table class="table table-bordered text-white">
            <tr class="text-secondary">
                <th style="color: #fff">Curso</th>
                <th style="color: #fff">Creada</th>
                <th style="color: #fff">Cantidad estudiantes</th>
                <th style="color: #fff">Tareas en Proceso</th>
                <th style="color: #fff">Tareas Finalizadas</th>
                <th style="color: #fff">Actualizar</th>
                <th style="color: #fff">Estudiantes</th>
                <th style="color: #fff">Eliminar</th>
            </tr>
            @foreach ($couses as $couse)
                <tr>
                    <form action="{{route("courses.update", [$couse->id_course])}}" method="POST">
                        @csrf
                        @method('PUT')
                        <td style="padding-top: 15px ; text-align:center">
                            <input type="text" name="name_course" class="form-control" placeholder="Nombre" value="{{$couse->name_course}}" style="background: transparent ; border: none ; outline: none ; color:#fff ; width: 100px">
                        </td>
                        <td>{{$couse->created_at}}</td>
                        <td>
                            {{$couse->total}}
                        </td>
                        <td>{{$couse->progress_tasks}}</td>
                        <td>{{$couse->finaly_tasks}}</td>
                        <td style="text-align:center">
                            <button type="submit" class="btn btn-primary mt-2" style="background-color: #1414b8; border-color:#1414b8">Actualizar</button>
                        </td>
                    </form>
                    <td style="text-align:center">
                        <a href="{{route("courses.show" , $couse->id_course)}}" class="btn btn-warning m-2">Ver Estudiantes</a>
                    </td>
                    <td style="display: flex ;  justify-content: center ; align-items: center">
                        <form action="{{route("courses.destroy", $couse->id_course)}}" method="POST" class="d-inline m-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger delete-task-button">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            
        </table>
        {{$couses->links()}}
    </div>
    <div class="col-12 mt-4">
        <div>
            <h2 class="text-white">Cursos Eliminadas</h2>
        </div>
    </div>
    <div class="col-12 mt-4">
    </div>
    <div class="col-12 mt-4">
        <table class="table table-bordered text-white">
            <tr class="text-secondary">
                <th style="color: #fff">Curso</th>
                <th style="color: #fff">Creada</th>
                <th style="color: #fff">Cantidad estudiantes</th>
                <th style="color: #fff">Habilitar</th>
            </tr>
            @foreach ($deletecouses as $deletecouse)
                <tr>
                    <td>{{$deletecouse->name_course}}</td>
                    <td>{{$deletecouse->created_at}}</td>
                    <td>{{$deletecouse->total}}</td>
                    <td style="display: flex ;  justify-content: center ; align-items: center">
                        <form action="{{route("courses.restore", $deletecouse->id_course)}}" method="POST" class="d-inline m-2">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-danger delete-task-button" style="background-color: #E67E22 ; border-color: #E67E22">Habilitar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            
        </table>
        {{$deletecouses->links()}}
    </div>
</div>
<script>
    document.querySelectorAll('.delete-task-button').forEach(button => {
        button.addEventListener('click', function(event){
            event.preventDefault();
            if(confirm('¿Estas seguro de realizar esta accion?, las tareas enviadas a este curso tambien seran afectadas')){
                this.closest('form').submit();
            }
        });
    });
</script>
@endsection