@extends('Layout.base')

@section('content')
<div class="row">

    <header style="background-color: #F1C40F; width: 100%; position: fixed; top: 0; left: 0; display: flex; justify-content: space-between; align-items: center; padding: 0 5%; height: 100px; z-index: 1000" id="cabecera">
        <div class="iden_per">
            <div>
                <div class="item">
                    <p style="color: black;  font-size: 25px; margin-top: 2%"><strong>{{Auth::user()->name}}</strong></p>
                </div>
            </div>
        </div>
        <ul style="display: flex; align-items: center; margin-top: 1%">
            <div>
                <a href="{{route('tasks.index')}}" class="btn btn-primary" style="background-color: #1414b8; border-color:#1414b8">Volver</a>
            </div>
            <form action="{{route("logout")}}" method="POST" class="d-inline" style="margin-left: 20px">
                @csrf
                <button type="submit" class="btn btn-danger">Cerrar Sesion</button>
            </form>
        </ul>
    </header><b><br><br><br><b><br><br><br>

    @if ($errors->any())
        <div class="alert alert-danger mt-2">
            <strong>¡ohh.. Lo sentimos!</strong> No podemos enviar la informaciòn:<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{route("tasks.update", $task)}}" method="POST" style="margin-top: 150px">
        @csrf
        @method('PUT')
        <div class="row">
            <h2>Actualizar Tarea</h2>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                <div class="form-group">
                    <strong>Tarea:</strong>
                    <input type="text" name="Titulo" class="form-control mt-2" placeholder="Tarea" value="{{$task->Titulo}}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                <div class="form-group">
                    <strong>Descripción:</strong>
                    <textarea class="form-control mt-2" style="height:150px" name="descripción" placeholder="Descripción..." >{{$task->descripción}}</textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 mt-2">
                <div class="form-group">
                    <strong>Fecha límite:</strong>
                    <input type="date" name="tarea_date" class="form-control mt-2" id="" value={{$task->tarea_date}}>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 mt-2">
                <div class="form-group">
                    <strong>Curso:</strong>
                    <select name="course" class="form-select mt-2" id="" value={{$task->course}}>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id_course }}" {{ $course->id_course == $task->course ? 'selected' : '' }}>{{ $course->name_course }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-2">
                <button type="submit" class="btn btn-primary mt-4" style="background-color: #1414b8; border-color:#1414b8">Actualizar</button>
            </div>
        </div>
    </form>
</div>
@endsection