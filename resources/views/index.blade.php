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
                    <a href="{{route("tasks.create")}}" class="btn btn-primary" style="background-color: #2ECC71 ; border-color: #2ECC71">Crear tarea</a>
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
            <h2 class="text-white">Tareas Creadas</h2>
        </div>
    </div>
    <div class="col-12" style="width: 230px">
        <form method="GET" action="{{ route('tasks.index') }}" class="form-inline">
            @csrf
            <select id="filter" name="filter" class="form-select mt-2" style="background-color: darkgray ; border-color: darkgray" onchange="this.form.submit()">
                <option value="">Elige una opción</option>
                @foreach ($classes as $classe)
                    <option value="{{ $classe->id_class }}" {{ request('filter') == $classe->name_class ? 'selected' : '' }}>{{ $classe->name_class }}</option>
                @endforeach
            </select>
        </form>
    </div>


    @if (Session::get('success'))
        <div class="alert alert-success mt-2">
            <strong>{{Session::get('success')}}</strong><br>
        </div>
    @endif

    <div class="col-12 mt-4">
        <table class="table table-bordered text-white">
            <tr class="text-secondary">
                <th style="color: #fff">Tarea</th>
                <th style="color: #fff">Descripción</th>
                <th style="color: #fff">Fecha</th>
                <th style="color: #fff">Estado</th>
                <th style="color: #fff">Acción</th>
            </tr>
            @foreach ($tasks as $task)
                <tr>
                    <td class="fw-bold">{{$task->Titulo}}</td>
                    <td>{{$task->descripción}}</td>
                    <td>
                        {{$task->tarea_date}}
                    </td>
                    @if ($task->estado == 'Pendiente')
                        <td style="text-align: center ; padding-top: 20px">
                            <span class="badge fs-6" style="background-color: #E67E22">{{$task->estado}}</span>
                        </td>
                    @endif
                    @if ($task->estado == 'Finalizada')
                        <td style="text-align: center ; padding-top: 20px">
                            <span class="badge fs-6" style="background-color: #2ECC71">{{$task->estado}}</span>
                        </td>
                    @endif
                    @if ($task->estado == 'En progreso')
                        <td style="text-align: center ; padding-top: 20px">
                            <span class="badge fs-6" style="background-color: #F1C40F">{{$task->estado}}</span>
                        </td>
                    @endif

                    <td style="display: flex ;  justify-content: center ; align-items: center">
                        <a href="{{route("tasks.edit" , [$task->id])}}" class="btn btn-warning m-2">Editar</a>
                        <a href="{{route("Calificar.edit" , [$task->id])}}" class="btn btn-warning m-2" style="background-color: #1414b8; border-color: #1414b8; color: #fff">Entregados</a>
                        <form action="{{route("tasks.destroy", $task)}}" method="POST" class="d-inline m-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger delete-task-button">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            
        </table>
        {{$tasks->links()}}
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