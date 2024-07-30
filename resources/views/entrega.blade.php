@extends('Layout.base')

@section('content')
<div class="row">
    <div>
        <header style="background-color: #f1c40e; width: 100%; position: fixed; top: 0; left: 0; display: flex; justify-content: space-between; align-items: center; padding: 0 5%; height: 100px; z-index: 1000" id="cabecera">
            <div class="iden_per">
                <div>
                    <div class="item">
                        <p style="color: black; font-size: 25px; margin-top: 2%"><strong>{{ Auth::user()->name }}</strong></p>
                    </div>
                </div>
            </div>
            <ul style="display: flex; align-items: center; margin-top: 1%">
                <form action="{{ route("logout") }}" method="POST" class="d-inline" style="margin-left: 20px">
                    @csrf
                    <button type="submit" class="btn btn-danger">Cerrar Sesion</button>
                </form>
            </ul>
        </header>
    </div><br><br><br><br><br><br>
    <div class="col-12">
        <div>
            <h2 class="text-white">Tareas del Estudiante</h2>
        </div>
    </div>

    @if (Session::get('success'))
        <div class="alert alert-success mt-2">
            <strong>{{ Session::get('success') }}</strong><br>
        </div>
    @endif

    <!-- Barra de búsqueda y filtros -->
    <div class="col-12 mt-4">
        <form method="GET" action="{{ route('tasks.index') }}" class="form-inline">
            <div class="form-group mx-sm-3 mb-4">
                <label for="filter" class="sr-only mb-2">Filtrar por</label>
                <select class="form-control" id="filter" name="filter">
                    <option value="blanco" {{ request('filter') == 'blanco' ? 'selected' : '' }}>Seleccione una Opción</option>
                    <option value="name" {{ request('filter') == 'name' ? 'selected' : '' }}>Nombre</option>
                    <option value="date" {{ request('filter') == 'date' ? 'selected' : '' }}>Fecha</option>
                    <option value="estado" {{ request('filter') == 'estado' ? 'selected' : '' }}>Estado</option>
                    <option value="note" {{ request('filter') == 'note' ? 'selected' : '' }}>Nota</option>
                    <option value="class" {{ request('filter') == 'class' ? 'selected' : '' }}>Clase</option>
                </select>
            </div>
            <div class="form-group mx-sm-3 mb-4">
                <label for="search" class="sr-only mb-2">Buscar</label>
                <input type="text" class="form-control" id="search" name="search" placeholder="Buscar" value="{{ request('search') }}">
            </div>
            <button type="submit" class="btn btn-primary mb-4" style="margin-left: 50% ; background-color: #1414b8; border-color: #1414b8; color: #fff">Buscar</button>
        </form>
    </div>

    <div class="col-12 mt-4">
        <table class="table table-bordered text-white">
            <tr class="text-secondary">
                <th style="color: #fff">Tarea</th>
                <th style="color: #fff">Descripción</th>
                <th style="color: #fff">Fecha</th>
                <th style="color: #fff">Nota</th>
                <th style="color: #fff">Estado</th>
                <th style="color: #fff">Acción</th>
            </tr>
            @foreach ($tasks as $task)
                <tr>
                    <td class="fw-bold">{{ $task->Titulo }}</td>
                    <td>{{ $task->descripción }}</td>
                    <td>{{ $task->tarea_date }}</td>
                    <td>{{ $task->student_task_nota}}</td>

                    @if ($task->student_task_estado == 'Vacia')
                        <td>
                            <span class="badge fs-6" style="background-color: #E67E22">{{ $task->student_task_estado }}</span>
                        </td>
                    @endif
                    @if ($task->student_task_estado == 'Entregada')
                        <td>
                            <span class="badge fs-6" style="background-color: #2ECC71">{{ $task->student_task_estado }}</span>
                        </td>
                    @endif
                    @if ($task->student_task_estado == 'Calificada')
                        <td>
                            <span class="badge fs-6" style="background-color: #F1C40F">{{ $task->student_task_estado }}</span>
                        </td>
                    @endif

                    <td>
                        <form action="{{ route('tasks.entregar', $task->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-warning" style="background-color: #1414b8; border-color: #1414b8; color: #fff">Entregar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            
        </table>
        {{ $tasks->links() }}
    </div>
</div>
@endsection
