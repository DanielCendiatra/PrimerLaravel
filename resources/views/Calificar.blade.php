@extends('Layout.base')

@section('content')
<div class="row">
    <div>
        <header style="background-color: #f1c40e; width: 100%; position: fixed; top: 0; left: 0; display: flex; justify-content: space-between; align-items: center; padding: 0 5%; height: 100px; z-index: 1000" id="cabecera">
            <div class="iden_per">
                <div>
                    <div class="item">
                        <p style="color: black;  font-size: 25px; margin-top: 2%"><strong>{{Auth::user()->name}}</strong></p>
                    </div>
                </div>
            </div>
            <ul style="display: flex; align-items: center; margin-top: 1%">
                <div>
                    <a href="{{route("tasks.create")}}" class="btn btn-primary" style="background-color: #2ECC71 ; border-color: #2ECC71">Crear tarea</a>
                </div>
                <div style="margin-left: 20px">
                    <a href="{{route('tasks.index')}}" class="btn btn-primary" style="background-color: #1414b8; border-color:#1414b8">Volver</a>
                </div>
                <form action="{{route("logout")}}" method="POST" class="d-inline" style="margin-left: 20px">
                    @csrf
                    <button type="submit" class="btn btn-danger">Cerrar Sesion</button>
                </form>
            </ul>
        </header>
    </div><br><br><br><br><br><br>

    <div class="col-12">
        <div>
            <h2 class="text-white">{{$task->Titulo}}</h2>
        </div>
        <p class="text-white mt-4">{{$task->descripción}}</p>
        <p class="text-white mt-4">Estado: {{$task->estado}}</p>
        <p class="text-white mt-4">Fecha de entrega: {{$task->tarea_date}}</p>
        <p class="text-white mt-4">Materia: {{$task->classe->name_class}}</p>
        <p class="text-white mt-4">Curso: {{$task->courses->name_course}}</p>
    </div>
    @if (Session::get('success'))
        <div class="alert alert-success mt-2">
            <strong>{{Session::get('success')}}</strong><br>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger mt-2"> 
            <ul> @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach </ul> 
        </div> 
    @endif
    <div class="col-12 mt-4" style="margin-bottom: 120px">
        <table class="table table-bordered text-white" >
            <tr class="text-secondary">
                <th style="color: #fff ; text-align:center">Nombre</th>
                <th style="color: #fff ; text-align:center">Correo</th>
                <th style="color: #fff ; text-align:center">Entregado</th>
                <th style="color: #fff ; text-align:center">Calificación</th>
                <th style="color: #fff ; text-align:center">Estado</th>
                <th style="color: #fff ; text-align:center">Acción</th>
            </tr>
            @foreach ($datatasks as $datatask)
                <tr>
                    <td style="padding-top: 25px ; text-align:center">{{$datatask->name_student}}</td>
                    <td style="padding-top: 25px ; text-align:center">{{$datatask->correo_student}}</td>
                    <td style="padding-top: 25px ; text-align:center">{{$datatask->updated_at}}</td>
                    <form action="{{route("Calificar.update", [$datatask->id_student_task])}}" method="POST" >
                        @csrf
                        @method('PUT')
                        @if ($datatask->estado == 'Calificada')
                            <td style="padding-top: 25px ; text-align:center">
                                <input type="text" name="note" class="form-control" placeholder="0.0" value="{{$datatask->note}}" style="background: transparent ; border: none ; outline: none ; color:#fff ">
                            </td>   
                        @elseif ($datatask->estado == 'Vacia' || $datatask->estado == 'Entregada' || $datatask->estado == 'Entrega Tardia')
                            <td style="padding-top: 25px ; text-align:center">
                                <input type="text" name="note" class="form-control" placeholder="0.0" value="0.0" style="background: transparent ; border: none ; outline: none ; color:#fff ">
                            </td>
                        @endif
                    
                        @if ($datatask->estado == 'Entrega Tardia')
                            <td style="padding-top: 25px ; text-align:center">
                                <span class="badge fs-6" style="background-color: #E67E22">{{$datatask->estado}}</span>
                            </td>
                        @endif
                        @if ($datatask->estado == 'Calificada')
                            <td style="padding-top: 25px ; text-align:center">
                                <span class="badge fs-6" style="background-color: #2ECC71">{{$datatask->estado}}</span>
                            </td>
                        @endif
                        @if ($datatask->estado == 'Entregada')
                            <td style="padding-top: 25px ; text-align:center">
                                <span class="badge fs-6" style="background-color: #F1C40F">{{$datatask->estado}}</span>
                            </td>
                        @endif
                        @if ($datatask->estado == 'Vacia')
                            <td style="padding-top: 25px ; text-align:center">
                                <span class="badge fs-6" style="background-color: darkgrey">{{$datatask->estado}}</span>
                            </td>
                        @endif
                        <td style="text-align:center">
                            <button type="submit" class="btn btn-primary mt-2" style="background-color: #1414b8; border-color:#1414b8">Calificar</button>
                        </td>
                    </form>
                </tr>
            @endforeach
        </table>
        {{ $datatasks->links() }}
    </div>
</div>
@endsection