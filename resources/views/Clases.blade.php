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
                    <a href="" class="btn btn-primary" style="background-color: #1414b8 ; border-color: #1414b8 ; margin-right: 20px">Usuarios</a>
                </div>
                <div>
                    <a href="{{route('courses.index')}}" class="btn btn-primary" style="background-color: #1414b8 ; border-color: #1414b8 ; margin-right: 20px">Cursos</a>
                </div>
                <form action="{{route("logout")}}" method="POST" class="d-inline" style="margin-left: 20px">
                    @csrf
                    <button type="submit" class="btn btn-danger">Cerrar Sesion</button>
                </form>
            </ul>
        </header>
    </div><br><br><br><br><br><br>
    <div class="col-12" style="text-align: center">
        <div>
            <h1 class="text-white">Clases</h1>
        </div>
    </div>
    @if (Session::get('success'))
        <div class="alert alert-success mt-2">
            <strong>{{Session::get('success')}}</strong><br>
        </div>
    @endif
    <div class="col-12 mt-4">
        <form method="POST" action="{{ route('classes.store') }}" class="form-inline">
            @csrf
            <div class="form-group mx-sm-3 mb-4">
                <label for="name_class" class="sr-only mb-2">Nombre</label>
                <input type="text" class="form-control" id="name_class" name="name_class" placeholder="Nombre">
            </div>
            <div class="form-group mx-sm-3 mb-4">
                <label for="docente" class="sr-only mb-2">Docente</label>
                <select class="form-control" id="docente" name="docente">
                    <option value="">-- Elige un Docente --</option>
                    @foreach ($teachers as $teacher)
                        <option value="{{$teacher->id}}">{{$teacher->name}}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary mb-4" style="margin-left: 46% ; background-color: #2ECC71; border-color: #2ECC71; color: #fff">Crear Clase</button>
        </form>
    </div>
    <div class="col-12">
        <div>
            <h2 class="text-white">Clases Existentes</h2>
        </div>
    </div>
    <div class="col-12 mt-4">
    </div>
    <div class="col-12 mt-4">
        <table class="table table-bordered text-white">
            <tr class="text-secondary">
                <th style="color: #fff">Clase</th>
                <th style="color: #fff">Docente</th>
                <th style="color: #fff">Correo</th>
                <th style="color: #fff">Creada</th>
                <th style="color: #fff">Numero de Tareas creadas</th>
                <th style="color: #fff">Actualizar</th>
                <th style="color: #fff">Eliminar</th>
            </tr>
            @foreach ($clases as $clase)
                <tr>
                    <form action="{{route("classes.update", [$clase->id_class])}}" method="POST">
                        @csrf
                        @method('PUT')
                        <td style="padding-top: 15px ; text-align:center">
                            <input type="text" name="name" class="form-control" placeholder="Nombre" value="{{$clase->name_class}}" style="background: transparent ; border: none ; outline: none ; color:#fff ">
                        </td>
                        <td>
                            <select class="form-control" id="docente" name="docente" style="background: transparent ; border: none ; outline: none ; color:#fff ">
                                @foreach ($teachers as $teacher)
                                    <option value="{{$teacher->id}}" {{ $teacher->id == $clase->teacher_id ? 'selected' : '' }} style="color: black">{{$teacher->name}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>{{$clase->correo}}</td>
                        <td>{{$clase->created_at}}</td>
                        <td>{{$clase->total}}</td>
                        <td style="text-align:center">
                            <button type="submit" class="btn btn-primary mt-2" style="background-color: #F1C40F; border-color:#F1C40F; color:black">Actualizar</button>
                        </td>
                    </form>
                    
                    <td style="display: flex ;  justify-content: center ; align-items: center">
                        <form action="{{route("classes.destroy", $clase->id_class)}}" method="POST" class="d-inline m-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger delete-task-button">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            
        </table>
        {{$clases->links()}}
    </div>
    <div class="col-12 mt-4">
        <div>
            <h2 class="text-white">Clases Eliminadas</h2>
        </div>
    </div>
    <div class="col-12 mt-4">
    </div>
    <div class="col-12 mt-4">
        <table class="table table-bordered text-white">
            <tr class="text-secondary">
                <th style="color: #fff">Clase</th>
                <th style="color: #fff">Docente</th>
                <th style="color: #fff">Correo</th>
                <th style="color: #fff">Creada</th>
                <th style="color: #fff">Numero de Tareas creadas</th>
                <th style="color: #fff">Acción</th>
            </tr>
            @foreach ($deleteclases as $deleteclase)
                <tr>
                    <td>{{$deleteclase->name_class}}</td>
                    <td>{{$deleteclase->nombre}}</td>
                    <td>{{$deleteclase->correo}}</td>
                    <td>{{$deleteclase->created_at}}</td>
                    <td>{{$deleteclase->total}}</td>
                    <td style="display: flex ;  justify-content: center ; align-items: center">
                        <form action="{{route("classes.restore", $deleteclase->id_class)}}" method="POST" class="d-inline m-2">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-danger delete-task-button" style="background-color: #E67E22 ; border-color: #E67E22">Habilitar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            
        </table>
        {{$clases->links()}}
    </div>
</div>
<script>
    document.querySelectorAll('.delete-task-button').forEach(button => {
        button.addEventListener('click', function(event){
            event.preventDefault();
            if(confirm('¿Estas seguro de realizar esta acción? , si lo haces todas las tareas de esta clase tambien se veran afectadas')){
                this.closest('form').submit();
            }
        });
    });
</script>
@endsection
