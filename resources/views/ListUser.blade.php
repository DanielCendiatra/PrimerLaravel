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
    <div class="col-12 mt-4">
        @if ($tipe == '1')
            <h6 class="mb-3 mt-4 text-uppercase">Administradores</h6>
            <hr>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" style="width:100%" id="table_users_ad">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Dirección</th>
                                    <th>Fecha de Nacimiento</th>
                                    <th>Celular</th>
                                    <th>Genero</th>
                                    <th>Editar</th>
                                    <th>Eliminar</th>
                                </tr> 
                            </thead> 
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->name}} {{ $user->lastname}}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->address }}</td>
                                        <td>{{ $user->date}}</td>
                                        <td>{{ $user->phone}}</td>
                                        <td>{{ $user->genero}}</td>
                                        <td>
                                            <div class="col" style="margin-top: 15% ; margin-left: 10%">
                                                <a href="{{route("users.edit" , [$user->id])}}"><button type="button" class="btn btn-outline-warning px-4 d-flex gap-2"><i class="lni lni-highlight-alt mt-1"></i>Editar</button></a>
                                            </div>
                                        </td>
                                        <td>
                                            <form action="{{route("users.destroy", $user->id)}}" method="POST" class="d-inline m-2">
                                                @csrf
                                                @method('DELETE')
                                                    <div class="col" style="margin-left: 10%">
                                                        <button type="button" class="btn btn-outline-danger px-4 d-flex gap-2" data-bs-toggle="modal" data-bs-target="#deleteModal{{$user->id}}"><i class="lni lni-ban mt-1"></i>Eliminar</button>
                                                        <div class="modal fade" id="deleteModal{{$user->id}}" tabindex="-1" aria-labelledby="deleteModalLabel{{$user->id}}" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="deleteModalLabel{{$user->id}}">Confirmación</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">¿Esta seguro de eliminar a este usuario? , Una vez elimines al usuario ya no podrá ingresar al sistema impidiendole hacer cual acción dentro de el.</div>
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
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Dirección</th>
                                    <th>Fecha de Nacimiento</th>
                                    <th>Celular</th>
                                    <th>Genero</th>
                                    <th>Editar</th>
                                    <th>Eliminar</th>
                                </tr> 
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        @endif
        @if ($tipe == '2')
            <h6 class="mb-3 mt-4 text-uppercase">Docentes</h6>
            <hr> 
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" style="width:100%" id="table_users_d">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Dirección</th>
                                    <th>Fecha de Nacimiento</th>
                                    <th>Celular</th>
                                    <th>Genero</th>
                                    <th>Clases</th>
                                    <th>Editar</th>
                                    <th>Eliminar</th>
                                </tr> 
                            </thead> 
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->name}} {{ $user->lastname}}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->address }}</td>
                                        <td>{{ $user->date}}</td>
                                        <td>{{ $user->phone}}</td>
                                        <td>{{ $user->genero}}</td>
                                        <td>{{ $user->classes}}</td>
                                        <td>
                                            <div class="col" style="margin-top: 15%">
                                                <a href="{{route("users.edit" , [$user->id])}}"><button type="button" class="btn btn-outline-warning px-4 d-flex gap-2"><i class="lni lni-highlight-alt mt-1"></i>Editar</button></a>
                                            </div>
                                        </td>
                                        <td>
                                            <form action="{{route("users.destroy", $user->id)}}" method="POST" class="d-inline m-2">
                                                @csrf
                                                @method('DELETE')
                                                <div class="col">
                                                    <button type="button" class="btn btn-outline-danger px-4 d-flex gap-2" data-bs-toggle="modal" data-bs-target="#deleteModal{{$user->id}}"><i class="lni lni-ban mt-1"></i>Eliminar</button>
                                                    <div class="modal fade" id="deleteModal{{$user->id}}" tabindex="-1" aria-labelledby="deleteModalLabel{{$user->id}}" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="deleteModalLabel{{$user->id}}">Confirmación</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">¿Esta seguro de eliminar a este usuario? , Una vez elimines al usuario ya no podrá ingresar al sistema impidiendole hacer cual acción dentro de el.</div>
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
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Dirección</th>
                                    <th>Fecha de Nacimiento</th>
                                    <th>Celular</th>
                                    <th>Genero</th>
                                    <th>Clases</th>
                                    <th>Editar</th>
                                    <th>Eliminar</th>
                                </tr> 
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        @endif
        @if ($tipe == '3')
            <h6 class="mb-3 mt-4 text-uppercase">Alumnos</h6>
            <hr>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" style="width:100%" id="table_users_a">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Dirección</th>
                                    <th>Fecha de Nacimiento</th>
                                    <th>Celular</th>
                                    <th>Genero</th>
                                    <th>Curso</th>
                                    <th>Editar</th>
                                    <th>Eliminar</th>
                                </tr>  
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->name}} {{ $user->lastname}}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->address }}</td>
                                        <td>{{ $user->date}}</td>
                                        <td>{{ $user->phone}}</td>
                                        <td>{{ $user->genero}}</td>
                                        <td>{{ $user->course}}</td>
                                        <td>
                                            <div class="col" style="margin-top: 15% ; margin-left: 5%">
                                                <a href="{{route("users.edit" , [$user->id])}}"><button type="button" class="btn btn-outline-warning px-4 d-flex gap-2"><i class="lni lni-highlight-alt mt-1"></i>Editar</button></a>
                                            </div>
                                        </td>
                                        <td>
                                            <form action="{{route("users.destroy", $user->id)}}" method="POST" class="d-inline m-2">
                                                @csrf
                                                @method('DELETE')
                                                <div class="col" style="margin-left: 5%">
                                                    <button type="button" class="btn btn-outline-danger px-4 d-flex gap-2" data-bs-toggle="modal" data-bs-target="#deleteModal{{$user->id}}"><i class="lni lni-ban mt-1"></i>Eliminar</button>
                                                    <div class="modal fade" id="deleteModal{{$user->id}}" tabindex="-1" aria-labelledby="deleteModalLabel{{$user->id}}" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="deleteModalLabel{{$user->id}}">Confirmación</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">¿Esta seguro de eliminar a este usuario? , Una vez elimines al usuario ya no podrá ingresar al sistema impidiendole hacer cual acción dentro de el.</div>
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
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Dirección</th>
                                    <th>Fecha de Nacimiento</th>
                                    <th>Celular</th>
                                    <th>Genero</th>
                                    <th>Curso</th>
                                    <th>Editar</th>
                                    <th>Eliminar</th>
                                </tr>  
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        @endif
        @if ($tipe == '4')
            <h6 class="mb-3 mt-4 text-uppercase">Usuarios Activos</h6>
            <hr>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" style="width:100%" id="table_users_t">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Fecha Creación</th>
                                    <th>Ultima Actualización</th>
                                    <th>Rol</th>
                                    <th>Editar</th>
                                    <th>Eliminar</th>
                                </tr> 
                            </thead> 
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->name}} {{ $user->lastname}}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->created_at }}</td>
                                        <td>{{ $user->updated_at}}</td>
                                        @if ($user->rol == 'Administrador')
                                            <td><span class="lable-table bg-success-subtle text-success rounded border border-success-subtle font-text2 fw-bold">{{ $user->rol }}</span></td>
                                        @endif
                                        @if ($user->rol == 'Docente')
                                            <td><span class="lable-table bg-warning-subtle text-warning rounded border border-warning-subtle font-text2 fw-bold">{{ $user->rol }}</span></td>
                                        @endif
                                        @if ($user->rol == 'Alumno')
                                            <td><span class="lable-table bg-primary-subtle text-primary rounded border border-primary-subtle font-text2 fw-bold">{{ $user->rol }}</span></td>
                                        @endif
                                        <td>
                                            <div class="col" style="margin-top: 12% ; margin-left: 10%">
                                                <a href="{{route("users.edit" , [$user->id])}}"><button type="button" class="btn btn-outline-warning px-4 d-flex gap-2"><i class="lni lni-highlight-alt mt-1"></i>Editar</button></a>
                                            </div>
                                        </td>
                                        <td>
                                            <form action="{{route("users.destroy", $user->id)}}" method="POST" class="d-inline m-2">
                                                @csrf
                                                @method('DELETE')
                                                <div class="col" style="margin-left: 10%">
                                                    <button type="button" class="btn btn-outline-danger px-4 d-flex gap-2" data-bs-toggle="modal" data-bs-target="#deleteModal{{$user->id}}"><i class="lni lni-ban mt-1"></i>Eliminar</button>
                                                    <div class="modal fade" id="deleteModal{{$user->id}}" tabindex="-1" aria-labelledby="deleteModalLabel{{$user->id}}" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="deleteModalLabel{{$user->id}}">Confirmación</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">¿Esta seguro de eliminar a este usuario? , Una vez elimines al usuario ya no podrá ingresar al sistema impidiendole hacer cual acción dentro de el.</div>
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
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Fecha Creación</th>
                                    <th>Ultima Actualización</th>
                                    <th>Rol</th>
                                    <th>Editar</th>
                                    <th>Eliminar</th>
                                </tr> 
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        @endif
        @if ($tipe == '5')
            <h6 class="mb-3 mt-4 text-uppercase">Usuarios Eliminados</h6>
            <hr>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" style="width:100%" id="table_users_e">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Genero</th>
                                    <th>Fecha Creación</th>
                                    <th>Fecha de eliminación</th>
                                    <th>Rol</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>  
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->name}} {{ $user->lastname}}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->genero }}</td>
                                        <td>{{ $user->created_at }}</td>
                                        <td>{{ $user->deleted_at}}</td>
                                        @if ($user->rol == 'Administrador')
                                            <td><span class="lable-table bg-success-subtle text-success rounded border border-success-subtle font-text2 fw-bold">{{ $user->rol }}</span></td>
                                        @endif
                                        @if ($user->rol == 'Docente')
                                            <td><span class="lable-table bg-warning-subtle text-warning rounded border border-warning-subtle font-text2 fw-bold">{{ $user->rol }}</span></td>
                                        @endif
                                        @if ($user->rol == 'Alumno')
                                            <td><span class="lable-table bg-primary-subtle text-primary rounded border border-primary-subtle font-text2 fw-bold">{{ $user->rol }}</span></td>
                                        @endif
                                        <td>
                                            <form action="{{route("users.restore", $user->id)}}" method="POST" class="d-inline m-2">
                                                @csrf
                                                @method('PATCH')
                                                <div class="col" class="col" style="margin-bottom: 10% ; margin-top: 10% ; margin-left: 20%">
                                                    <button type="button" class="btn btn-outline-primary px-4 raised d-flex gap-2"  data-bs-toggle="modal" data-bs-target="#restoreModal{{$user->id}}"><i class="lni lni-consulting fs-5" style="margin-top: 2px"></i>Restaurar</button>
                                                    <div class="modal fade" id="restoreModal{{$user->id}}" tabindex="-1" aria-labelledby="restoreModalLabel{{$user->id}}" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="restoreModalLabel{{$user->id}}">Confirmación</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">¿Esta seguro de habilitar a este usuario? , una vez restaures a este usuario, podra volver a ingresar al sistema y podra nuevamente realizar las acciones que tenga permitidas segun su rol; en caso de ser un alumno se volveran a habilitar sus tareas</div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                                    <button type="submit" class="btn btn-primary">Restaurar</button>
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
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Genero</th>
                                    <th>Fecha Creación</th>
                                    <th>Fecha de eliminación</th>
                                    <th>Rol</th>
                                    <th>Acciones</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
@section('scripts')  

  <script src="{{ URL::asset('build/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ URL::asset('build/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script>
		$(document).ready(function() {
			var table = $('#table_users_ad').DataTable( {
				lengthChange: false,
				buttons: [ 'copy', 'excel', 'pdf', 'print']
			} );
		 
			table.buttons().container()
				.appendTo( '#table_users_ad_wrapper .col-md-6:eq(0)' );
		} );
	</script>
    <script>
		$(document).ready(function() {
			var table = $('#table_users_d').DataTable( {
				lengthChange: false,
				buttons: [ 'copy', 'excel', 'pdf', 'print']
			} );
		 
			table.buttons().container()
				.appendTo( '#table_users_d_wrapper .col-md-6:eq(0)' );
		} );
	</script>
    <script>
		$(document).ready(function() {
			var table = $('#table_users_a').DataTable( {
				lengthChange: false,
				buttons: [ 'copy', 'excel', 'pdf', 'print']
			} );
		 
			table.buttons().container()
				.appendTo( '#table_users_a_wrapper .col-md-6:eq(0)' );
		} );
	</script>
    <script>
		$(document).ready(function() {
			var table = $('#table_users_e').DataTable( {
				lengthChange: false,
				buttons: [ 'copy', 'excel', 'pdf', 'print']
			} );
		 
			table.buttons().container()
				.appendTo( '#table_users_e_wrapper .col-md-6:eq(0)' );
		} );
	</script>
    <script>
		$(document).ready(function() {
			var table = $('#table_users_t').DataTable( {
				lengthChange: false,
				buttons: [ 'copy', 'excel', 'pdf', 'print']
			} );
		 
			table.buttons().container()
				.appendTo( '#table_users_t_wrapper .col-md-6:eq(0)' );
		} );
	</script>
@endsection 
