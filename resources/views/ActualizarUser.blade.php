@extends('Layout.master')

@section('css')
	<link href="{{ URL::asset('build/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('build/css/extra-icons.css') }}">
@endsection
@section('content')
<div class="row">
    <h6 class="mb-3 mt-4 text-uppercase">Actualizar Usuario</h6>
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
                <form action="{{route("users.update", $id)}}" method="POST" style="display: grid; grid-template-columns: repeat(2, 1fr);  grid-gap: 10px;">
                    @csrf
                    @method('PUT')
                    <div class="col-md-11 mb-2">
                        <label for="name" class="form-label mt-2">Nombres</label>
                        <div class="position-relative input-icon">
                            <input type="text" name="name" class="form-control" id="name" placeholder="Ingrese sus nombres" value="{{$tipe->name}}">
                            <span class="position-absolute top-50 translate-middle-y"><i class="material-icons-outlined fs-5">person_outline</i></span>
                        </div>
                    </div>
                    <div class="col-md-11 mb-2">
                        <label for="lastname" class="form-label mt-2">Apellidos</label>
                        <div class="position-relative input-icon">
                            <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Ingrese sus apellidos" value="{{$tipe->lastname}}">
                            <span class="position-absolute top-50 translate-middle-y"><i class="fadeIn animated bx bx-user-plus fs-5"></i></span>
                        </div>
                    </div>
                    <div class="col-md-11 mb-2">
                        <label for="phone" class="form-label mt-2">Celular</label>
                        <div class="position-relative input-icon">
                            <input type="tel" name="phone" class="form-control" id="phone" placeholder="Ingrese su numero de celular" value="{{$tipe->phone}}">
                            <span class="position-absolute top-50 translate-middle-y"><i class="material-icons-outlined fs-5">call</i></span>
                        </div>
                    </div>
                    <div class="col-md-11 mb-2">
                        <label for="correo" class="form-label mt-2">Correo</label>
                        <div class="position-relative input-icon">
                            <input type="email" name="correo" class="form-control" id="correo" placeholder="Ingrese su correo" value="{{$tipe->email}}">
                            <span class="position-absolute top-50 translate-middle-y"><i class="material-icons-outlined fs-5">email</i></span>
                        </div>
                    </div>
                    <div class="col-md-11 mb-2">
                        <label for="password" class="form-label mt-2">Contraseña</label>
                        <div class="position-relative input-icon">
                            <input type="password" name="password" class="form-control" id="password" placeholder="Dejar vacío si no desea cambiar">
                            <span class="position-absolute top-50 translate-middle-y"><i class="material-icons-outlined fs-5">lock_open</i></span>
                        </div>
                    </div>
                    <div class="col-md-11 mb-2">
                        <label for="address" class="form-label mt-2">Dirección</label>
                        <div class="position-relative input-icon">
                            <input type="text" name="address" class="form-control" id="address" placeholder="Ingrese su dirección" value="{{$tipe->address}}">
                            <span class="position-absolute top-50 translate-middle-y"><i class="material-icons-outlined fs-5">location_on</i></span>
                        </div>
                    </div>
                    <div class="col-md-11 mb-2">
                        <label for="date" class="form-label mt-2">Fecha de Nacimiento</label>
                        <div class="position-relative input-icon">
                            <input type="date" name="date" class="form-control date-format" id="date" placeholder="Fecha de Nacimiento" value="{{$tipe->date}}">
                            <span class="position-absolute top-50 translate-middle-y"><i class="material-icons-outlined fs-5">event</i></span>
                        </div>
                    </div>
                    @if ($tipe->rol == 'Alumno')
                        <div class="col-md-11 mb-2">
                            <label for="course" class="form-label mt-2">Curso</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fadeIn animated bx bx-group"></i></span>
                                <select name="course" class="form-select" id="course" value={{$tipe->course}}>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id_course }}" {{ $course->id_course == $tipe->idcourse ? 'selected' : '' }}>{{ $course->name_course }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                    <div class="col-md-7 mb-2">
                        <label for="gen" class="form-label mt-2">Genero</label>
                        <div class="input-icon" style="display: grid; grid-template-columns: repeat(3, 1fr);  grid-gap: 10px">
                            <span class=" top-50" style="width: 60px"><i class="fadeIn animated bx bx-female-sign fs-5"></i><i class="fadeIn animated bx bx-male-sign fs-5"></i></span>
                            <div class="position-relative input-icon">
                                <input class="form-check-input" type="radio" name="genero" id="Masculino" value="Masculino" {{$tipe->genero == 'Masculino' ? 'checked' : ''}}>
                                <label class="form-check-label" for="Masculino">
                                    <i class="fadeIn animated bx bx-male"></i>Masculino
                                </label>
                            </div>
                            <div class="form-check form-check-warning">
                                <input class="form-check-input" type="radio" name="genero" id="Femenino" value="Femenino" {{$tipe->genero == 'Femenino' ? 'checked' : ''}}>
                                <label class="form-check-label" for="Femenino">
                                    <i class="fadeIn animated bx bx-female"></i>Femenino
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-11 mb-2 mt-4">
                        <div class="d-md-flex d-grid align-items-center gap-3">
                            <button type="button" class="btn btn-outline-primary px-4 raised d-flex gap-2"  data-bs-toggle="modal" data-bs-target="#restoreModal{{$id}}"><i class="lni lni-spinner mt-1"></i>Actualizar</button>
                            <div class="modal fade" id="restoreModal{{$id}}" tabindex="-1" aria-labelledby="restoreModalLabel{{$id}}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="restoreModalLabel{{$id}}">Confirmación</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">¿Esta seguro de actualizar la información de este Usuario? , La información sera actualizada inmediatamente.</div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-primary">Actualizar</button>
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