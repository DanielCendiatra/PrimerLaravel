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
        </header>
    </div><br><br><br><br><br><br>
    <div class="col-12">
        <div>
            <h2 class="text-white">Usuarios Existentes</h2>
        </div>
    </div>

    @if (Session::get('success'))
        <div class="alert alert-success mt-2">
            <strong>{{Session::get('success')}}</strong><br>
        </div>
    @endif

    <div class="col-12" style="width: 230px">
        <form method="GET" action="{{ route('users.index') }}" class="form-inline">
            @csrf
            <select id="filter" name="filter" class="form-select mt-2" style="background-color: darkgray ; border-color: darkgray" onchange="this.form.submit()">
                <option value="" {{ request('filter') == '' ? 'selected' : '' }}>Elige una opción</option>
                    <option value="Usuarios Activos" {{ request('filter') == 'Usuarios Activos' ? 'selected' : '' }}>Usuarios Activos</option>
                    <option value="Administradores" {{ request('filter') == 'Administradores' ? 'selected' : '' }}>Administradores</option>
                    <option value="Docentes" {{ request('filter') == 'Docentes' ? 'selected' : '' }}>Docentes</option>
                    <option value="Alumnos" {{ request('filter') == 'Alumnos' ? 'selected' : '' }}>Alumnos</option>
                    <option value="Usuarios Eliminados" {{ request('filter') == 'Usuarios Eliminados' ? 'selected' : '' }}>Usuarios Eliminados</option>
            </select>
        </form>
    </div>
    <div class="col-12 mt-4">
        @if ($tipe == '1')
            <table class="table table-bordered text-white">
                <tr class="text-secondary">
                    <th style="color: #fff">Nombre</th>
                    <th style="color: #fff">Correo</th>
                    <th style="color: #fff">Fecha Creación</th>
                    <th style="color: #fff">Ultima Actualización</th>
                    <th style="color: #fff">Acciones</th>
                </tr>  
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name}}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>{{ $user->updated_at}}</td>
                    <td style="display: flex ;  justify-content: center ; align-items: center">
                        <a href="{{route("users.edit" , [$user->id])}}" class="btn btn-warning m-2">Editar</a>
                        <form action="{{route("users.destroy", $user->id)}}" method="POST" class="d-inline m-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger delete-task-button">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
            {{ $users->appends(['filter' => request('filter')])->links() }}
        @endif
        @if ($tipe == '2')
            <table class="table table-bordered text-white">
                <tr class="text-secondary">
                    <th style="color: #fff">Nombre</th>
                    <th style="color: #fff">Correo</th>
                    <th style="color: #fff">Fecha Creación</th>
                    <th style="color: #fff">Ultima Actualización</th>
                    <th style="color: #fff">Clases</th>
                    <th style="color: #fff">Acciones</th>
                </tr>  
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name}}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>{{ $user->updated_at}}</td>
                    <td>{{ $user->classes}}</td>
                    <td style="display: flex ;  justify-content: center ; align-items: center">
                        <a href="{{route("users.edit" , [$user->id])}}" class="btn btn-warning m-2">Editar</a>
                        <form action="{{route("users.destroy", $user->id)}}" method="POST" class="d-inline m-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger delete-task-button">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
            {{ $users->appends(['filter' => request('filter')])->links() }}
        @endif
        @if ($tipe == '3')
            <table class="table table-bordered text-white">
                <tr class="text-secondary">
                    <th style="color: #fff">Nombre</th>
                    <th style="color: #fff">Correo</th>
                    <th style="color: #fff">Fecha Creación</th>
                    <th style="color: #fff">Ultima Actualización</th>
                    <th style="color: #fff">Curso</th>
                    <th style="color: #fff">Acciones</th>
                </tr>  
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name}}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>{{ $user->updated_at}}</td>
                    <td>{{ $user->course}}</td>
                    <td style="display: flex ;  justify-content: center ; align-items: center">
                        <a href="{{route("users.edit" , [$user->id])}}" class="btn btn-warning m-2">Editar</a>
                        <form action="{{route("users.destroy", $user->id)}}" method="POST" class="d-inline m-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger delete-task-button">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
            {{ $users->appends(['filter' => request('filter')])->links() }}
        @endif
        @if ($tipe == '4')
            <table class="table table-bordered text-white">
                <tr class="text-secondary">
                    <th style="color: #fff">Nombre</th>
                    <th style="color: #fff">Correo</th>
                    <th style="color: #fff">Fecha Creación</th>
                    <th style="color: #fff">Ultima Actualización</th>
                    <th style="color: #fff">Rol</th>
                    <th style="color: #fff">Acciones</th>
                </tr>  
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name}}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>{{ $user->updated_at}}</td>
                    @if ($user->rol == 'Administrador')
                        <td>
                            <span class="badge fs-6" style="background-color: #1414b8">{{ $user->rol }}</span>
                        </td>
                    @endif
                    @if ($user->rol == 'Docente')
                        <td>
                            <span class="badge fs-6" style="background-color: #2ECC71">{{ $user->rol }}</span>
                        </td>
                    @endif
                    @if ($user->rol == 'Alumno')
                        <td>
                            <span class="badge fs-6" style="background-color: #E67E22">{{ $user->rol }}</span>
                        </td>
                    @endif
                    <td style="display: flex ;  justify-content: center ; align-items: center">
                        <a href="{{route("users.edit" , [$user->id])}}" class="btn btn-warning m-2">Editar</a>
                        <form action="{{route("users.destroy", $user->id)}}" method="POST" class="d-inline m-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger delete-task-button">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </table>
            {{ $users->appends(['filter' => request('filter')])->links() }}
        @endif
        @if ($tipe == '5')
            <table class="table table-bordered text-white">
                <tr class="text-secondary">
                    <th style="color: #fff">Nombre</th>
                    <th style="color: #fff">Correo</th>
                    <th style="color: #fff">Fecha Creación</th>
                    <th style="color: #fff">Fecha de eliminación</th>
                    <th style="color: #fff">Rol</th>
                    <th style="color: #fff">Acciones</th>
                </tr>  
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name}}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>{{ $user->deleted_at}}</td>
                    @if ($user->rol == 'Administrador')
                        <td>
                            <span class="badge fs-6" style="background-color: #1414b8">{{ $user->rol }}</span>
                        </td>
                    @endif
                    @if ($user->rol == 'Docente')
                        <td>
                            <span class="badge fs-6" style="background-color: #2ECC71">{{ $user->rol }}</span>
                        </td>
                    @endif
                    @if ($user->rol == 'Alumno')
                        <td>
                            <span class="badge fs-6" style="background-color: #E67E22">{{ $user->rol }}</span>
                        </td>
                    @endif
                    <td style="display: flex ;  justify-content: center ; align-items: center">
                        <form action="{{route("users.restore", $user->id)}}" method="POST" class="d-inline m-2">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn delete-task-button" style="background-color: #E67E22 ; border-color:#E67E22">Habilitar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
            {{ $users->appends(['filter' => request('filter')])->links() }}
        @endif
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.querySelectorAll('.delete-task-button').forEach(button => {
        button.addEventListener('click', function(event){
            event.preventDefault();
            if(confirm('¿Estas seguro de habilitar este usuario?')){
                this.closest('form').submit();
            }
        });
    });
</script>
@endsection
