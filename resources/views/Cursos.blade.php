@extends('Layout.master')

@section('css')
	<link href="{{ URL::asset('build/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ URL::asset('build/css/extra-icons.css') }}">
@endsection 
@section('content')
<div class="row">
    <div class="col-12 mt-4 mb-4" style="display: flex; align-items:center">
        <form method="POST" action="{{ route('courses.store') }}" class="form-inline">
            @csrf
            <div class="form-group mx-sm-1 mb-4">
                <label for="name_course" class="sr-only mb-2">Nombre</label>
                <input type="text" class="form-control" id="name_course" name="name_course" placeholder="Nombre">
            </div>
            <button type="submit" class="btn btn-outline-success px-4 raised d-flex gap-2 mt-4" style="margin-left: 3%" ><i class="lni lni-cloud-check mt-1"></i>Crear Curso</button>
        </form>
    </div>
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
    <h6 class="mb-3 mt-4 text-uppercase">Cursos Existentes</h6>
    <hr>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" style="width:100%" id="table_courses_A">
                    <thead>
                        <tr>
                            <th>Curso</th>
                            <th>Creada</th>
                            <th>Cantidad estudiantes</th>
                            <th>Tareas en Proceso</th>
                            <th>Tareas Finalizadas</th>
                            <th>Actualizar</th>
                            <th>Estudiantes</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($couses as $couse)
                            <tr>
                                <form action="{{route("courses.update", [$couse->id_course])}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <td>
                                        <input type="text" name="name_course" class="form-control" placeholder="Nombre" value="{{$couse->name_course}}" style="background: transparent ; border: none ; outline: none ; color:#fff ; width: 100px">
                                    </td>
                                    <td>{{$couse->created_at}}</td>
                                    <td>
                                        {{$couse->total}}
                                    </td>
                                    <td>{{$couse->progress_tasks}}</td>
                                    <td>{{$couse->finaly_tasks}}</td>
                                    <td>
                                        <div class="col" style="margin-top: 10% ; margin-left: 10%">
                                            <button type="submit"  class="btn btn-outline-primary px-4 raised d-flex gap-2" ><i class="lni lni-spinner-arrow mt-1"></i>Actualizar</button>
                                        </div>  
                                    </td>
                                </form>
                                <td>
                                    <div class="col" style="margin-top: 8% ; margin-left: 10%">
                                        <a href="{{route("courses.show" , $couse->id_course)}}"><button type="button" class="btn btn-outline-warning px-4 raised d-flex gap-2"><i class="material-icons-outlined">account_circle</i>Ver Estudiantes</button></a>
                                    </div>   
                                </td>
                                <td>
                                    <form action="{{route("courses.destroy", $couse->id_course)}}" method="POST" class="d-inline m-2">
                                        @csrf
                                        @method('DELETE')
                                        <div class="col" style="margin-left: 10%">
                                            <button type="button" class="btn btn-outline-danger px-4 raised d-flex gap-2" data-bs-toggle="modal" data-bs-target="#deleteModal{{$couse->id_course}}"><i class="material-icons-outlined">delete</i>Eliminar</button>
                                            <div class="modal fade" id="deleteModal{{$couse->id_course}}" tabindex="-1" aria-labelledby="deleteModalLabel{{$couse->id_course}}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteModalLabel{{$couse->id_course}}">Confirmación</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">¿Esta seguro de eliminar este curso? , una vez se elimine el curso ningun alumno podra unirse al curso, asi mismo no se podran asignar nuevas tareas para el curso y las ya existentes tambien seran eliminadas.</div>
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
                            <th>Curso</th>
                            <th>Creada</th>
                            <th>Cantidad estudiantes</th>
                            <th>Tareas en Proceso</th>
                            <th>Tareas Finalizadas</th>
                            <th>Actualizar</th>
                            <th>Estudiantes</th>
                            <th>Eliminar</th>
                        </tr>
                    </tfoot>
                </table>
                
            </div>
        </div>
    </div>
    <h6 class="mb-3 text-uppercase">Cursos Eliminados</h6>
    <hr>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" style="width:100%" id="table_courses_E">
                    <thead>
                        <tr>
                            <th>Curso</th>
                            <th>Creada</th>
                            <th>Cantidad estudiantes</th>
                            <th>Habilitar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($deletecouses as $deletecouse)
                            <tr>
                                <td>{{$deletecouse->name_course}}</td>
                                <td>{{$deletecouse->created_at}}</td>
                                <td>{{$deletecouse->total}}</td>
                                <td style="display: flex ;  justify-content: center ; align-items: center">
                                    <form action="{{route("courses.restore", $deletecouse->id_course)}}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="col" style="margin-bottom: 10% ; margin-top: 10%">
                                            <button type="button" class="btn btn-outline-secondary px-4 raised d-flex gap-2"  data-bs-toggle="modal" data-bs-target="#restoreModal{{$deletecouse->id_course}}"><i class="lni lni-grow mt-1"></i>Habilitar</button>
                                            <div class="modal fade" id="restoreModal{{$deletecouse->id_course}}" tabindex="-1" aria-labelledby="restoreModalLabel{{$deletecouse->id_course}}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="restoreModalLabel{{$deletecouse->id_course}}">Confirmación</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">¿Esta seguro de habilitar este curso? , una vez se habilite el curso nuevos alumnos podran unirse y podran volver a crearse actividades para este.</div>
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
                            <th>Curso</th>
                            <th>Creada</th>
                            <th>Cantidad estudiantes</th>
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
			$('#table_courses_A').DataTable();
		  } );
	</script>
    <script>
		$(document).ready(function() {
			$('#table_courses_E').DataTable();
		  } );
	</script>
@endsection 