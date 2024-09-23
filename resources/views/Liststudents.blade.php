@extends('Layout.master')
@section('css')
	<link href="{{ URL::asset('build/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ URL::asset('build/css/extra-icons.css') }}">
@endsection 
@section('content')
<div class="row">
    <h6 class="mb-3 mt-4 text-uppercase">Alumnos del curso</h6>
    <hr>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" style="width:100%" id="table_list_U">
                    <thead>
                        <tr>
                            <th>Estudiante</th>
                            <th>Correo</th>
                            <th>Tareas Pendientes</th>
                            <th>Tareas Entregadas</th>
                            <th>Tareas con Entrega Tardia</th>
                            <th>Tareas Calificadas</th>
                            <th>Descargar Reporte</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td>{{$student->name_student}}</td>
                                <td>{{$student->correo_student}}</td>
                                <td>{{$student->empty_tasks}}</td>
                                <td>{{$student->delivered_tasks}}</td>
                                <td>{{$student->late_tasks}}</td>
                                <td>{{$student->graded_tasks}}</td>
                                <td>
                                    <div class="col" style="margin-top: 8% ; margin-left: 10% ; margin-bottom:8%">
                                        <a href="{{route("student.report" , [$student->id_student])}}"><button type="button" class="btn btn-outline-info px-4 raised d-flex gap-2"><i class="material-icons-outlined">cloud_download</i>Descargar</button></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Estudiante</th>
                            <th>Correo</th>
                            <th>Tareas Pendientes</th>
                            <th>Tareas Entregadas</th>
                            <th>Tareas con Entrega Tardia</th>
                            <th>Tareas Calificadas</th>
                            <th>Descargar Reporte</th>
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
			$('#table_list_U').DataTable();
		  } );
	</script>
@endsection 