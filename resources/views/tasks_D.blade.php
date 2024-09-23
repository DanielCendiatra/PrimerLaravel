@extends('Layout.master')
@section('css')
	<link href="{{ URL::asset('build/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ URL::asset('build/css/extra-icons.css') }}">
@endsection 
@section('content')
<div class="row">
    <h3 class="mb-3 mt-4 text-uppercase">Tareas Creadas</h3>
    <hr>
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
    <div class="col-12" style="width: 230px">
        <form method="GET" action="{{ route('tasksclassview') }}" class="form-inline">
            @csrf
            <select id="filter" name="filter" class="form-select mt-2" style="background-color: darkgray ; border-color: darkgray" onchange="this.form.submit()">
                <option value="">Elige una opción</option>
                @foreach ($classes as $classe)
                    <option value="{{ $classe->id_class }}" {{ request('filter') == $classe->name_class ? 'selected' : '' }}>{{ $classe->name_class }}</option>
                @endforeach
            </select>
        </form>
    </div>
    <h6 class="mb-3 mt-4 text-uppercase">Tareas Activas</h6>
    <hr>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" style="width:100%" id="table_tareas_ac">
                    <thead>
                        <tr>
                            <th>Tarea</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Editar</th>
                            <th>Calificar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                            <tr>
                                <td>{{$task->Titulo}}</td>
                                <td>{{$task->descripción}}</td>
                                @if ($task->estado == 'Finalizada')
                                    <td style="text-align: center ; padding-top: 2%">
                                        <span class="lable-table bg-warning-subtle text-warning rounded border border-warning-subtle font-text2 fw-bold">{{$task->estado}}<i class="bi bi-info-circle ms-2"></i></span>
                                    </td>
                                @endif
                                @if ($task->estado == 'En progreso')
                                    <td style="text-align: center ; padding-top: 2%">
                                        <span class="lable-table bg-primary-subtle text-primary rounded border border-primary-subtle font-text2 fw-bold">{{$task->estado}}<i class="bi bi-check2 ms-2"></i></span>
                                    </td>
                                @endif
                                <td>
                                    {{$task->tarea_date}}
                                </td>
                                <td>
                                    <div class="col" style="margin-top: 15% ; margin-left: 5%">
                                        <a href="{{route("tasks.edit" , [$task->id])}}"><button type="button" class="btn btn-outline-warning px-4 raised d-flex gap-2"><i class="lni lni-eraser mt-1"></i>Editar</button></a>
                                    </div>
                                </td>
                                <td>
                                    <div class="col" style="margin-top: 12% ; margin-left: 5%">
                                        <a href="{{route("Calificar.edit" , [$task->id])}}"><button type="button"  class="btn btn-outline-primary px-4 raised d-flex gap-2" ><i class="lni lni-package mt-1"></i>Entregados</button></a>
                                    </div>
                                </td>
                                <td>
                                    <form action="{{route("tasks.destroy", $task)}}" method="POST" class="d-inline m-2">
                                        @csrf
                                        @method('DELETE')
                                        <div class="col" style="margin-left: 5%">
                                            <button type="button" class="btn btn-outline-danger px-4 raised d-flex gap-2" data-bs-toggle="modal" data-bs-target="#deleteModal{{$task->id}}"><i class="material-icons-outlined">delete</i>Eliminar</button>
                                            <div class="modal fade" id="deleteModal{{$task->id}}" tabindex="-1" aria-labelledby="deleteModalLabel{{$task->id}}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteModalLabel{{$task->id}}">Confirmación</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">¿Estas seguro de eliminar esta tarea? , Si la tarea es eliminada ningun alumno podra entregarla y las entrgas ya hechas se deshabilitaran</div>
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
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Editar</th>
                            <th>Calificar</th>
                            <th>Eliminar</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <h6 class="mb-3 mt-4 text-uppercase">Tareas Eliminadas</h6>
    <hr>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" style="width:100%" id="table_tareas_el">
                    <thead>
                        <tr>
                            <th>Tarea</th>
                            <th>Descripción</th>
                            <th>Fecha</th>
                            <th>Ultimo Estado</th>
                            <th>Habilitar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($deletasks as $deletask)
                            <tr>
                                <td>{{$deletask->Titulo}}</td>
                                <td>{{$deletask->descripción}}</td>
                                <td>
                                    {{$deletask->tarea_date}}
                                </td>
                                @if ($deletask->estado == 'Finalizada')
                                    <td style="text-align: center ; padding-top: 2%">
                                        <span class="lable-table bg-warning-subtle text-warning rounded border border-warning-subtle font-text2 fw-bold">{{$deletask->estado}}<i class="bi bi-info-circle ms-2"></i></span>
                                    </td>
                                @endif
                                @if ($deletask->estado == 'En progreso')
                                    <td style="text-align: center ; padding-top: 2%">
                                        <span class="lable-table bg-primary-subtle text-primary rounded border border-primary-subtle font-text2 fw-bold">{{$deletask->estado}}<i class="bi bi-check2 ms-2"></i></span>
                                    </td>
                                @endif
                                <td style="display: flex ;  justify-content: center ; align-items: center">
                                    <form action="{{route("tasks.restore", $deletask->id)}}" method="POST" class="d-inline m-2">
                                        @csrf
                                        @method('PATCH')
                                        <div class="col" style="margin-bottom: 10% ; margin-top: 10%">
                                            <button type="button" class="btn btn-outline-secondary px-4 raised d-flex gap-2"  data-bs-toggle="modal" data-bs-target="#restoreModal{{$deletask->id}}"><i class="lni lni-pulse mt-1"></i>Habilitar</button>
                                            <div class="modal fade" id="restoreModal{{$deletask->id}}" tabindex="-1" aria-labelledby="restoreModalLabel{{$deletask->id}}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="restoreModalLabel{{$deletask->id}}">Confirmación</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">¿Estas seguro de restaurar esta tarea? , una vez sea restaurada los alumnos podran volver a entregar tareas.</div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                            <button type="submit" class="btn btn-primary">Habilitar</button>
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
                            <th>Ultimo Estado</th>
                            <th>Habilitar</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')  
    <script src="{{ URL::asset('build/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ URL::asset('build/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
	<script>
		$(document).ready(function() {
			$('#table_tareas_ac').DataTable();
		  } );
	</script>
    <script>
		$(document).ready(function() {
			$('#table_tareas_el').DataTable();
		  } );
	</script>
@endsection 