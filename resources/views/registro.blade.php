@extends('Layout.base')

@section('content')


@if($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div style="background-color:#e5be01 ; width: 500px; padding: 20px; border-radius: 20px; margin-top: 12%; margin-left: 30%; box-shadow: 3px 3px 18px whitesmoke">
    <form method="POST" action="{{ route('validar-registro') }}" style="width: 100%">
        @csrf
        <div style="width: 100%">
            <h2 style="text-align: center; color:black">Registro</h2>
            <div style="margin-left: 40px; margin-rigth: 40px" class="col-md-10 mt-4">
                <label for="name" style="color: black">Nombre</label>
                <input type="text" id="name" name="name" class="form-control mt-3" required>
            </div>
            <div style="margin-left: 40px; margin-rigth: 40px" class="col-md-10 mt-4">
                <label for="email" style="color: black">Email</label>
                <input type="email" id="email" name="email" class="form-control mt-3" required>
            </div>
            <div style="margin-left: 40px; margin-rigth: 40px" class="col-md-10 mt-4">
                <label for="password" style="color: black">Contraseña</label>
                <input type="password" id="password" name="password" class="form-control mt-3" required>
            </div>
            <div style="margin-left: 40px; margin-rigth: 40px" class="col-md-10 mt-4">
                <label for="rol" style="color: black">Rol</label>
                <select name="rol" class="form-select mt-2" id="rol" required>
                    <option value="">-- Elige un rol--</option>
                    <option value="Docente">Docente</option>
                    <option value="Alumno">Alumno</option>
                </select>
            </div>
            <div style="margin-left: 40px; margin-rigth: 40px" class="col-md-10 mt-4" id="extra-field" style="display: none;">
                <label id="extra-field-label" style="color: black"></label>
                <select id="extra-field-select" name="extra_field" class="form-select mt-2">
                    <option value="">-- Elige una opción--</option>
                </select>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-4">
                <button type="submit" class="btn btn-primary" style="background-color: #1414b8; border-color:#1414b8">Registrar</button>
            </div>
        </div>
    </form>
</div>

<script>
    document.getElementById('rol').addEventListener('change', function () {
        var extraField = document.getElementById('extra-field');
        var extraFieldLabel = document.getElementById('extra-field-label');
        var extraFieldSelect = document.getElementById('extra-field-select');

        if (this.value === 'Docente') {
            extraFieldLabel.innerText = 'Clase';
            extraField.style.display = 'block';
            extraFieldSelect.innerHTML = @json($classes).map(c => `<option value="${c.id_class}">${c.name_class}</option>`).join('');
        } else if (this.value === 'Alumno') {
            extraFieldLabel.innerText = 'Curso';
            extraField.style.display = 'block';
            extraFieldSelect.innerHTML = @json($courses).map(c => `<option value="${c.id_course}">${c.name_course}</option>`).join('');
        } else {
            extraField.style.display = 'none';
            extraFieldSelect.innerHTML = '';
        }
    });
</script>
@endsection