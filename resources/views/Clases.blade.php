@extends('Layout.master')
@section('css')
	<link href="{{ URL::asset('build/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ URL::asset('build/css/extra-icons.css') }}">
@endsection 
@section('content')
<div class="row">
    <h3 class="mb-3 mt-4 text-uppercase">Clases</h3>
    <hr>
    <div class="col-12 mt-4">
        <form method="POST" action="{{ route('classes.store') }}" class="form-inline mb-4">
            @csrf
            <div class="form-group mx-sm-3 mb-4">
                <label for="name_class" class="sr-only mb-2">Nombre</label>
                <input type="text" class="form-control" id="name_class" name="name_class" placeholder="Nombre">
            </div>
            <div class="form-group mx-sm-3 mb-4">
                <label for="docente" class="sr-only mb-2">Docente</label>
                <select class="form-control" id="docente" name="docente">
                    <option value="">-- Elige un Docente --</option>
                    @foreach ($teachers as $teacher)
                        <option value="{{$teacher->id}}">{{$teacher->name}}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-outline-success px-4 raised d-flex gap-2 mt-4" style="margin-left: 1%" ><i class="lni lni-circle-plus mt-1"></i>Crear Clase</button>
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
    <h6 class="mb-3 mt-4 text-uppercase">Clases Existentes</h6>
    <hr>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" style="width:100%" id="table_clases_A">
                    <thead>
                        <tr>
                            <th>Clase</th>
                            <th>Docente</th>
                            <th>Correo</th>
                            <th>Creada</th>
                            <th>Numero de Tareas creadas</th>
                            <th>Actualizar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clases as $clase)
                            <tr>
                                <form action="{{route("classes.update", [$clase->id_class])}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <td>
                                        <input type="text" name="name" class="form-control" placeholder="Nombre" value="{{$clase->name_class}}" style="background: transparent ; border: none ; outline: none">
                                    </td>
                                    <td>
                                        <select class="form-control" id="docente" name="docente" style="background: transparent ; border: none ; outline: none">
                                            <option value="">Sin Docente Asignado</option>
                                            @foreach ($teachers as $teacher)
                                                <option value="{{$teacher->id}}" {{ $teacher->id == $clase->teacher_id ? 'selected' : '' }} style="color: black">{{$teacher->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>{{$clase->correo}}</td>
                                    <td>{{$clase->created_at}}</td>
                                    <td>{{$clase->total}}</td>
                                    <td>
                                        <div class="col" style="margin-top: 13% ; margin-left: 3%">
                                            <button type="submit" class="btn btn-outline-warning px-4 raised d-flex gap-2"><i class="lni lni-reload mt-1"></i>Actualizar</button>
                                        </div>
                                    </td>
                                </form>
                                <td>
                                    <form action="{{route("classes.destroy", $clase->id_class)}}" method="POST" class="d-inline m-2">
                                        @csrf
                                        @method('DELETE')
                                        <div style="margin-left: 5%">
                                            <button type="button" class="btn btn-outline-danger px-4 raised d-flex gap-2" data-bs-toggle="modal" data-bs-target="#deleteModal{{$clase->id_class}}"><i class="material-icons-outlined">delete</i>Eliminar</button>
                                            <div class="modal fade" id="deleteModal{{$clase->id_class}}" tabindex="-1" aria-labelledby="deleteModalLabel{{$clase->id_class}}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteModalLabel{{$clase->id_class}}">Confirmación</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">¿Esta seguro de eliminar esta clase? , una vez se elimine la clase no se podra crear nuevas tareas de esta, y las ya existentes quedaran inhabilitadas.</div>
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
                            <th>Clase</th>
                            <th>Docente</th>
                            <th>Correo</th>
                            <th>Creada</th>
                            <th>Numero de Tareas creadas</th>
                            <th>Actualizar</th>
                            <th>Eliminar</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <h6 class="mb-3 mt-4 text-uppercase">Clases Eliminadas</h6>
    <hr>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-white" id="table_clases_E">
                    <thead>
                        <tr>
                            <th>Clase</th>
                            <th>Docente</th>
                            <th>Correo</th>
                            <th>Creada</th>
                            <th>Numero de Tareas creadas</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($deleteclases as $deleteclase)
                            <tr>
                                <td>{{$deleteclase->name_class}}</td>
                                <td>{{$deleteclase->nombre}}</td>
                                <td>{{$deleteclase->correo}}</td>
                                <td>{{$deleteclase->created_at}}</td>
                                <td>{{$deleteclase->total}}</td>
                                <td>
                                    <form action="{{route("classes.restore", $deleteclase->id_class)}}" method="POST" class="d-inline m-2">
                                        @csrf
                                        @method('PATCH')
                                        <div class="col" style="margin-top: 10% ; margin-left: 15%">
                                            <button type="button" class="btn btn-outline-secondary px-4 raised d-flex gap-2"  data-bs-toggle="modal" data-bs-target="#restoreModal{{$deleteclase->id_class}}" ><i class="lni lni-eye mt-1"></i>Habilitar</button>
                                            <div class="modal fade" id="restoreModal{{$deleteclase->id_class}}" tabindex="-1" aria-labelledby="restoreModalLabel{{$deleteclase->id_class}}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="restoreModalLabel{{$deleteclase->id_class}}">Confirmación</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">¿Esta seguro de habilitar esta clase? , una vez se habilite la clase nuevas tareas de esta podran ser creadas asi mismo las que ya existian seran habilitadas para poder ser entregadas.</div>
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
                            <th>Clase</th>
                            <th">Docente</th>
                            <th>Correo</th>
                            <th>Creada</th>
                            <th>Numero de Tareas creadas</th>
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
			$('#table_clases_A').DataTable();
		  } );
	</script>
    <script>
		$(document).ready(function() {
			$('#table_clases_E').DataTable();
		  } );
	</script>
@endsection 