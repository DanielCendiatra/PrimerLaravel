
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
<div style="background-color: #e5be01; width: 500px; padding: 20px; border-radius: 20px; margin-top: 20%; margin-left: 30%; box-shadow: 3px 3px 18px whitesmoke">
    <form method="POST" action="{{ route('iniciar-sesion') }}" style="width: 100%">
        @csrf
        <div style="width: 100%">
            <h2 style="text-align: center; color:black">Ingreso</h2>
            <div style="margin-left: 40px; margin-rigth: 40px" class="col-md-10 mt-4">
                <div>
                    <label for="email" style="color:black">Email</label>
                    <input type="email" id="email" class="form-control mt-3" name="email" required>
                </div>
            </div>
            <div style="margin-left: 40px; margin-rigth: 40px" class="col-md-10 mt-4">
                <div>
                    <label for="password" style="color:black">Contraseña</label>
                    <input type="password" id="password" class="form-control mt-3" name="password" required>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-4">
                <button type="submit" class="btn btn-primary" style="background-color: #1414b8; border-color:#1414b8">Ingresar</button>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-2">
                <a href="{{route("registro")}}" style="color: #1414b8">Registrarse</a>
            </div>
        </div>
    </form>
</div>


@endsection

 