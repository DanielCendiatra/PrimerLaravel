@extends('Layout.master')

@section('css')
	<link href="{{ URL::asset('build/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('build/css/extra-icons.css') }}">
@endsection
@section('content')
<div class="row">
    <h3 class="mb-3 mt-4 text-uppercase">Tareas del Alumno</h3>
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
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" style="width:100%" id="table_tareas_A">
                    <thead>
                        <tr>
                            <th>Tarea</th>
                            <th>Descripción</th>
                            <th>Fecha</th>
                            <th>Mareria</th>
                            <th>Nota</th>
                            <th>Estado</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                            <tr>
                                <td>{{ $task->Titulo }}</td>
                                <td>{{ $task->descripción }}</td>
                                <td>{{ $task->tarea_date }}</td>
                                <td>{{ $task->name_class }}</td>
                                <td>{{ $task->student_task_nota}}</td>
                                @if ($task->student_task_estado == 'Entrega Tardia')
                                <td style="padding-top: 25px ; text-align:center">
                                    <span class="lable-table bg-warning-subtle text-warning rounded border border-warning-subtle font-text2 fw-bold">{{$task->student_task_estado}}<i class="bi bi-info-circle ms-2"></i></span>
                                </td>
                            @endif
                            @if ($task->student_task_estado == 'Calificada')
                                <td style="padding-top: 25px ; text-align:center">
                                    <span class="lable-table bg-primary-subtle text-primary rounded border border-primary-subtle font-text2 fw-bold">{{$task->student_task_estado}}<i class="bi bi-check2-all ms-2"></i></span>
                                </td>
                            @endif
                            @if ($task->student_task_estado == 'Entregada')
                                <td style="padding-top: 25px ; text-align:center">
                                    <span class="lable-table bg-success-subtle text-success rounded border border-success-subtle font-text2 fw-bold">{{$task->student_task_estado}}<i class="bi bi-check2 ms-2"></i></span>
                                </td>
                            @endif
                            @if ($task->student_task_estado == 'Vacia')
                                <td style="padding-top: 25px ; text-align:center">
                                    <span class="lable-table bg-danger-subtle text-danger rounded border border-danger-subtle font-text2 fw-bold">{{$task->student_task_estado}}<i class="bi bi-x-lg ms-2"></i></span>
                                </td>
                            @endif
                            <td>
                                <form action="{{ route('tasks.entregar', $task->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="col">
                                        <button type="submit" class="btn btn-outline-primary px-4 d-flex gap-2"><i class="lni lni-telegram-original mt-1"></i>Entregar</button>
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
                            <th>Mareria</th>
                            <th>Nota</th>
                            <th>Estado</th>
                            <th>Acción</th>
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
			$('#table_tareas_A').DataTable();
		  } );
	</script>
@endsection 
