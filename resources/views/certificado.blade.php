<!DOCTYPE html>
<html>
<head>
    <title>Certificado de Notas</title>
    <style>
        .titulo{
            text-align: center;
            font-size: 45px;
            margin-top: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 40px;
        }
        th, td {
            padding: 10px;
            border: 1px solid black;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1 class="titulo"><strong>Certificado de Notas</strong> </h1>
    <table>
        <tbody>
            <tr>
                <th>Nombre</th>
                <td>{{ $student->user->name }}</td>
            </tr>
            <tr>
                <th>Correo</th>
                <td>{{ $student->user->email }}</td>
            </tr>
            <tr>
                <th>Curso</th>
                <td>{{ $course_s->name_course }}</td>
            </tr>
        </tbody>
    </table>
    <table>
        <thead>
            <tr>
                <th>Materia</th>
                <th>Promedio</th>
                <th>Numero de tareas no entregadas</th>
                <th>Numero total de tareas en el periodo</th>
                <th>Desempeño</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $entry)
                <tr>
                    <td>{{ $entry['class_name'] }}</td>
                    <td>{{ ($entry['promedio']) }}</td>
                    <td>{{ $entry['tareas_vacias'] }}</td>
                    <td>{{$entry['Ntasks']}}</td>
                    <td>{{ ($entry['desempeño']) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>