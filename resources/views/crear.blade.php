@extends('Layout.master')

@section('css')
	<link href="{{ URL::asset('build/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('build/css/extra-icons.css') }}">
@endsection
@section('content')
<div class="row">
    
    <h6 class="mb-3 mt-4 text-uppercase">Crear Tarea</h6>
    <hr>
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

    <div class="col-12 col-xl-12">
        <div class="card">
            <div class="card-body p-4">
                <h5 class="mb-4">Información</h5>
                <form action="{{route("tasks.store")}}" method="POST">
                    @csrf
                    <div class="col-md-12 mb-2">
                        <label for="Titulo" class="form-label mt-2">Tarea</label>
                        <div class="position-relative input-icon">
                            <input type="text" name="Titulo" class="form-control" id="Titulo" placeholder="Ingrese el nombre de la tarea">
                            <span class="position-absolute top-50 translate-middle-y"><i class="fadeIn animated bx bx-pin fs-5"></i></i></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="descripción" class="form-label">Descripción</label>
                        <textarea  class="form-control" name="descripción" id="descripción" placeholder="Descripción..." rows="3"></textarea>
                    </div>
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr);  grid-gap: 10px">
                        <div class="col-md-12 mb-2">
                            <label for="tarea_date" class="form-label mt-2">Fecha limite</label>
                            <div class="position-relative input-icon">
                                <input type="date" name="tarea_date" class="form-control date-format" id="tarea_date" placeholder="Ingrese la fecha de entrega limite">
                                <span class="position-absolute top-50 translate-middle-y"><i class="material-icons-outlined fs-5">event</i></span>
                            </div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="class" class="form-label mt-2">Clase</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fadeIn animated bx bx-trophy"></i></span>
                                <select name="class" class="form-select" id="class">
                                    <option value="">-- Elige la clase --</option>
                                    @foreach ($classes as $classe)
                                        <option value="{{$classe->id_class}}">{{$classe->name_class}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="course" class="form-label mt-2">Curso</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fadeIn animated bx bx-group"></i></span>
                                <select name="course" class="form-select" id="course">
                                    <option value="">-- Elige el curso --</option>
                                    @foreach ($courses as $course)
                                        <option value="{{$course->id_course}}">{{$course->name_course}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-11 mb-2 mt-4" style="display: flex ; justify-content:center ; align-items:center">
                        <div class="d-md-flex d-grid align-items-center gap-3">
                            <button type="button" class="btn btn-outline-success px-4 raised d-flex gap-2"  data-bs-toggle="modal" data-bs-target="#restoreModal"><i class="lni lni-cloud-check mt-1 fs-6"></i>Crear Tarea</button>
                            <div class="modal fade" id="restoreModal" tabindex="-1" aria-labelledby="restoreModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="restoreModalLabel">Confirmación</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">¿Estas seguro de crear esta actividad?</div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-primary">Crear</button>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')  

  	<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
	<script>
		$(".date-format").flatpickr({
			altInput: true,
			altFormat: "F j, Y",
			dateFormat: "Y-m-d",
		});
	</script>
@endsection 