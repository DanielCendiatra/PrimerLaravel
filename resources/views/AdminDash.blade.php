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
                    <a href="" class="btn btn-primary" style="background-color: #1414b8 ; border-color: #1414b8 ; margin-right: 20px">Usuarios</a>
                </div>
                <div>
                    <a href="{{route('classes.index')}}" class="btn btn-primary" style="background-color: #1414b8 ; border-color: #1414b8 ; margin-right: 20px">Clases</a>
                </div>
                <div>
                    <a href="{{route('courses.index')}}" class="btn btn-primary" style="background-color: #1414b8 ; border-color: #1414b8">Cursos</a>
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
            <h2 class="text-white">Tareas Existentes</h2>
        </div>
    </div>

    @if (Session::get('success'))
        <div class="alert alert-success mt-2">
            <strong>{{Session::get('success')}}</strong><br>
        </div>
    @endif

    <div class="col-12 mt-4">
        <form method="GET" action="{{ route('tasks.index') }}" class="form-inline">
            <div class="form-group mx-sm-3 mb-4">
                <label for="filter" class="sr-only mb-2">Filtrar por</label>
                <select class="form-control" id="filter" name="filter">
                    <option value="blanco" {{ request('filter') == 'blanco' ? 'selected' : '' }}>Seleccione una Opción</option>
                    <option value="name" {{ request('filter') == 'name' ? 'selected' : '' }}>Nombre</option>
                    <option value="date" {{ request('filter') == 'date' ? 'selected' : '' }}>Fecha</option>
                    <option value="estado" {{ request('filter') == 'estado' ? 'selected' : '' }}>Estado</option>
                    <option value="Curso" {{ request('filter') == 'Curso' ? 'selected' : '' }}>Curso</option>
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
                <th style="color: #fff">Materia</th>
                <th style="color: #fff">Curso</th>
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
                    <td>{{$task->class}}</td>
                    <td>{{$task->course}}</td>
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
    <div>
        <h1 class="mb-4 mt-4" style="text-align: center">Estadisticas</h1>
    </div>
    <div class="col-12 mt-4" style="width: 500px">
        <canvas id="tasksChart" width="500" height="400">
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('/tasks/chart-data')
            .then(response => response.json())
            .then(data => {
                const labels = data.map(task => task.class_name);
                const totals = data.map(task => task.total);

                const ctx = document.getElementById('tasksChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Número de tareas en la clase',
                            data: totals,
                            backgroundColor: ['#1414b8', '#F1C40F', '#2ECC71', '#E67E22'],
                            borderColor: ['#1414b8', '#F1C40F', '#2ECC71', '#E67E22'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            x: {
                                ticks: {
                                    color: '#ffffff', // Color de la letra en el eje x
                                    font: {
                                        size: 14 // Tamaño de la letra en el eje x
                                    }
                                }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    color: '#ffffff', // Color de la letra en el eje y
                                    font: {
                                        size: 14 // Tamaño de la letra en el eje y
                                    }
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                labels: {
                                    color: '#ffffff', // Color de la letra en la leyenda
                                    font: {
                                        size: 16 // Tamaño de la letra en la leyenda
                                    }
                                }
                            }
                        },
                        responsive: true,
                        maintainAspectRatio: false // Permitir ajustar el tamaño manualmente
                    }
                });
            });
    });
</script>
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
