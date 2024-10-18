<?php use App\Http\Controllers\GrupoDocenteController as GDC; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registro de Asistencias</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <td colspan="5" style="font-size: 25px; font-weight: bold">PAUL MULLER</td>
                <td colspan="2"></td>
                <td style="text-align: center"><img src="../public/empresa/logo_paulmuller.jpeg" alt="" width="80" height="80"></td>
            </tr>
            <tr>
                <td colspan="5" style="font-size: 15px; font-weight: bold">Registro de Asistencia</td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold">Curso:</td>
                <td colspan="4">{{ $grupo->nomCur }}</td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold">Docente:</td>
                <td colspan="4">{{ $grupo->nomDoc }}</td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold">Grupo / Módulo:</td>
                <td colspan="4">{{ $grupo->nombreGrupo }} / {{ $nroModulo }}</td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold">Fecha Inicio:</td>
                <td colspan="4">{{ date('d/m/Y', strtotime($st)) }}</td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold">Fecha Final:</td>
                <td colspan="4">{{ date('d/m/Y', strtotime($st2)) }}</td>
            </tr>
        </thead>
    </table>
    <table>
        <thead>
            <tr>
                <th style="border: 1px solid #0059D1; background: #0059D1; color: #ffffff; text-align: center">N°</th>
                <th style="border: 1px solid #0059D1; background: #0059D1; color: #ffffff">Estudiante</th>
                @foreach ($registros as $r)
                    <th style="border: 1px solid #0059D1; background: #0059D1; color: #ffffff; text-align: center">
                        {{ date('d/m', strtotime($r->fecha)) }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @php($cont = 1)
            @foreach ($estudiantes as $e)
                <tr>
                    <td style="border: 1px solid #0059D1; text-align: center">{{ $cont++ }}</td>
                    <td style="border: 1px solid #0059D1;">{{ $e->nomEst }}</td>
                    @foreach ($registros as $r)
                        @php($a = GDC::obtenerAsistencia($e->idEstudiante, $r->idAsistencia))
                        @php($a = !empty($a) ? $a->estado[0] : $a)
                        <th style="border: 1px solid #0059D1; text-align: center; color: {{$a == 'F' ? '#dc3545' : '#000000' }}">
                            {{ $a }}
                        </th>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>