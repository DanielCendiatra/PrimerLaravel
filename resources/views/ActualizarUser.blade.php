@extends('Layout.base')

@section('content')
<div class="row">

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
                <a href="{{route('users.index')}}" class="btn btn-primary" style="background-color: #1414b8 ; border-color: #1414b8 ; margin-right: 20px">Volver</a>
            </div>
            <div>
                <a href="{{route('classes.index')}}" class="btn btn-primary" style="background-color: #1414b8 ; border-color: #1414b8 ; margin-right: 20px">Clases</a>
            </div>
            <div>
                <a href="{{route('courses.index')}}" class="btn btn-primary" style="background-color: #1414b8 ; border-color: #1414b8 ; margin-right: 20px">Cursos</a>
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

    <form action="{{route("users.update", $id)}}" method="POST" style="margin-top: 150px">
        @csrf
        @method('PUT')
        @if ($tipe->rol == 'Alumno')
            <div class="row">
                <h2>Actualizar Usuario</h2>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                    <div class="form-group">
                        <strong>Nombre:</strong>
                        <input type="text" name="name" class="form-control mt-2" placeholder="name" value="{{$tipe->name}}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                    <div class="form-group">
                        <strong>Correo:</strong>
                        <input type="email" name="correo" class="form-control mt-2" placeholder="correo" value="{{$tipe->email}}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 mt-2">
                    <div class="form-group">
                        <strong>Contraseña:</strong>
                        <input type="password" name="password" class="form-control mt-2" placeholder="Dejar vacío si no desea cambiar">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 mt-2">
                    <div class="form-group">
                        <strong>Curso:</strong>
                        <select name="course" class="form-select mt-2" id="" value={{$tipe->course}}>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id_course }}" {{ $course->id_course == $tipe->idcourse ? 'selected' : '' }}>{{ $course->name_course }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-2">
                    <button type="submit" class="btn btn-primary mt-4" style="background-color: #1414b8; border-color:#1414b8">Actualizar</button>
                </div>
            </div>
        @endif
        @if ($tipe->rol == 'Administrador' || $tipe->rol == 'Docente')
            <div class="row">
                <h2>Actualizar Usuario</h2>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                    <div class="form-group">
                        <strong>Nombre:</strong>
                        <input type="text" name="name" class="form-control mt-2" placeholder="name" value="{{$tipe->name}}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 mt-2">
                    <div class="form-group">
                        <strong>Correo:</strong>
                        <input type="email" name="correo" class="form-control mt-2" placeholder="correo" value="{{$tipe->email}}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 mt-2">
                    <div class="form-group">
                        <strong>Contraseña:</strong>
                        <input type="password" name="password" class="form-control mt-2" placeholder="Dejar vacío si no desea cambiar">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-2">
                    <button type="submit" class="btn btn-primary mt-4" style="background-color: #1414b8; border-color:#1414b8">Actualizar</button>
                </div>
            </div>
        @endif
    </form>
</div>
@endsection