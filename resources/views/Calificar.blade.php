@extends('Layout.master')
@section('css')
	<link href="{{ URL::asset('build/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ URL::asset('build/css/extra-icons.css') }}">
@endsection 
@section('content')
<div class="row">
    <div class="col-12">
        <h3 class="mb-3 mt-4 text-uppercase">{{$task->Titulo}}</h3>
        <hr>
        <p class="text-white mt-4 mx-4">{{$task->descripción}}</p>
        <p class="text-white mt-4 mx-4">Estado: {{$task->estado}}</p>
        <p class="text-white mt-4 mx-4">Fecha de entrega: {{$task->tarea_date}}</p>
        <p class="text-white mt-4 mx-4">Materia: {{$task->classe->name_class}}</p>
        <p class="text-white mt-4 mx-4">Curso: {{$task->courses->name_course}}</p>
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
    @if ($errors->any())
        <div class="alert alert-border-danger alert-dismissible fade show">
            <div class="d-flex align-items-center">
                <div class="font-35 text-danger"><span class="material-icons-outlined fs-2">report_gmailerrorred</span>
                </div>
                <div class="ms-3">
                    <h6 class="mb-0 text-danger"><strong>¡ohh.. Lo sentimos!</strong> No podemos enviar la informaciòn:<br><br></h6>
                    <div class=""><strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </strong></div>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" style="width:100%" id="table_entregas">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Entregado</th>
                            <th>Calificación</th>
                            <th>Estado</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datatasks as $datatask)
                            <tr>
                                <td>{{$datatask->name_student}}</td>
                                <td>{{$datatask->correo_student}}</td>
                                <td>{{$datatask->updated_at}}</td>
                                <form action="{{route("Calificar.update", [$datatask->id_student_task])}}" method="POST" >
                                    @csrf
                                    @method('PUT')
                                    @if ($datatask->estado == 'Calificada')
                                        <td>
                                            <input type="text" name="note" class="form-control" placeholder="0.0" value="{{$datatask->note}}" style="background: transparent ; border: none ; outline: none ; color:#fff ">
                                        </td>   
                                    @elseif ($datatask->estado == 'Vacia' || $datatask->estado == 'Entregada' || $datatask->estado == 'Entrega Tardia')
                                        <td>
                                            <input type="text" name="note" class="form-control" placeholder="0.0" value="0.0" style="background: transparent ; border: none ; outline: none ; color:#fff ">
                                        </td>
                                    @endif
                                    @if ($datatask->estado == 'Entrega Tardia')
                                        <td style="padding-top: 25px ; text-align:center">
                                            <span class="lable-table bg-warning-subtle text-warning rounded border border-warning-subtle font-text2 fw-bold">{{$datatask->estado}}<i class="bi bi-info-circle ms-2"></i></span>
                                        </td>
                                    @endif
                                    @if ($datatask->estado == 'Calificada')
                                        <td style="padding-top: 25px ; text-align:center">
                                            <span class="lable-table bg-primary-subtle text-primary rounded border border-primary-subtle font-text2 fw-bold">{{$datatask->estado}}<i class="bi bi-check2-all ms-2"></i></span>
                                        </td>
                                    @endif
                                    @if ($datatask->estado == 'Entregada')
                                        <td style="padding-top: 25px ; text-align:center">
                                            <span class="lable-table bg-success-subtle text-success rounded border border-success-subtle font-text2 fw-bold">{{$datatask->estado}}<i class="bi bi-check2 ms-2"></i></span>
                                        </td>
                                    @endif
                                    @if ($datatask->estado == 'Vacia')
                                        <td style="padding-top: 25px ; text-align:center">
                                            <span class="lable-table bg-danger-subtle text-danger rounded border border-danger-subtle font-text2 fw-bold">{{$datatask->estado}}<i class="bi bi-x-lg ms-2"></i></span>
                                        </td>
                                    @endif
                                    <td>
                                        <div class="col" class="col" style="margin-bottom: 10% ; margin-top: 10% ; margin-left: 20%">
                                            <button type="button" class="btn btn-outline-primary px-4 raised d-flex gap-2"  data-bs-toggle="modal" data-bs-target="#restoreModal{{$datatask->id_student_task}}"><i class="lni lni-checkbox mt-1"></i>Calificar</button>
                                            <div class="modal fade" id="restoreModal{{$datatask->id_student_task}}" tabindex="-1" aria-labelledby="restoreModalLabel{{$datatask->id_student_task}}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="restoreModalLabel{{$datatask->id_student_task}}">Confirmación</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">¿Estas seguro que quieres guardar esta nota?</div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                            <button type="submit" class="btn btn-primary">Guardar Calificación</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </form>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Entregado</th>
                            <th>Calificación</th>
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
			var table = $('#table_entregas').DataTable( {
				lengthChange: false,
				buttons: [ 'copy', 'excel', 'pdf', 'print']
			} );
		 
			table.buttons().container()
				.appendTo( '#table_entregas_wrapper .col-md-6:eq(0)' );
		} );
	</script>
@endsection 