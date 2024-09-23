@extends('Layout.master')

@section('css')
	<link href="{{ URL::asset('build/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ URL::asset('build/css/extra-icons.css') }}">
@endsection 
@section('content')
<div class="row">
    @if (Session::get('success'))
        <div class="alert alert-border-success alert-dismissible fade show mx-3" style="width: 97%">
            <div class="d-flex align-items-center">
                <div class="font-35 text-success"><span class="material-icons-outlined fs-2">check_circle</span>
                </div>
                <div class="ms-3">
                    <h6 class="mb-0 text-success">Felicidades</h6>
                    <div class=""><strong>{{Session::get('success')}}</strong><br></div>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (Session::get('error'))
        <div class="alert alert-border-danger alert-dismissible fade show">
            <div class="d-flex align-items-center">
                <div class="font-35 text-danger"><span class="material-icons-outlined fs-2">report_gmailerrorred</span>
                </div>
                <div class="ms-3">
                    <h6 class="mb-0 text-danger">Error</h6>
                    <div class=""><strong>{{Session::get('error')}}</strong></div>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <h6 class="mb-3 mt-4 text-uppercase">Tareas Existentes</h6>
    <hr>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" style="width:100%" id="taskes_admin">
                    <thead>
                        <tr>
                            <th>Tarea</th>
                            <th>Descripción</th>
                            <th>Fecha</th>
                            <th>Materia</th>
                            <th>Curso</th>
                            <th>Estado</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                            <tr>
                                <td>{{$task->Titulo}}</td>
                                <td>{{$task->descripción}}</td>
                                <td>{{$task->tarea_date}}</td>
                                <td>{{$task->class}}</td>
                                <td>{{$task->course}}</td>
                                @if ($task->estado == 'Finalizada')
                                    <td style="text-align: center ; padding-top: 20px">
                                        <span class="lable-table bg-warning-subtle text-warning rounded border border-warning-subtle font-text2 fw-bold">{{$task->estado}}<i class="bi bi-info-circle ms-2"></i></span>
                                    </td>
                                @endif
                                @if ($task->estado == 'En progreso')
                                    <td style="text-align: center ; padding-top: 20px">
                                        <span class="lable-table bg-primary-subtle text-primary rounded border border-primary-subtle font-text2 fw-bold">{{$task->estado}}<i class="bi bi-check2 ms-2"></i></span>
                                    </td>
                                @endif
                                <td>
                                    <form action="{{route("tasks.destroy", $task)}}" method="POST" class="d-inline m-2">
                                        @csrf
                                        @method('DELETE')
                                        <div class="col mx-2">
                                            <button type="button" class="btn btn-outline-danger px-4 raised d-flex gap-2" data-bs-toggle="modal" data-bs-target="#deleteModal{{$task->id}}"><i class="material-icons-outlined">delete</i>Eliminar</button>
                                            <div class="modal fade" id="deleteModal{{$task->id}}" tabindex="-1" aria-labelledby="deleteModalLabel{{$task->id}}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteModalLabel{{$task->id}}">Confirmación</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">¿Esta seguro de eliminar esta tarea? , una vez se elimine la tarea las entregas de esta no contaran y los alumnos no podran entregarla.</div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                            <button type="submit" class="btn btn-primary">Eliminar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Tarea</th>
                            <th>Descripción</th>
                            <th>Fecha</th>
                            <th>Materia</th>
                            <th>Curso</th>
                            <th>Estado</th>
                            <th>Acción</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="col-12 mt-4" style="width: 500px">
        <canvas id="tasksChart" width="500" height="400">
    </div>
</div>
@endsection
@section('scripts')  
    <script src="{{ URL::asset('build/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ URL::asset('build/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
	<script>
		$(document).ready(function() {
			$('#taskes_admin').DataTable();
		  } );
	</script>
@endsection 
