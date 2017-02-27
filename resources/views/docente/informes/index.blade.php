@extends('admin.template.main')
@section('tittle', 'Reportes')
@section('content')
<h1>Reportes Por Alumno</h1>
<br>
<div class="list-group" style="max-width: 80%;">
<a href="{{route('docente.alumno.s1.pdf',$alumno->id) }}" class="list-group-item"> Informe de Notas Primer Semestre</a>
<a href="{{route('docente.alumno.s2.pdf',$alumno->id) }}" class="list-group-item"> Informe de Notas Segundo Semestre</a>
<a href="{{route('docente.alumno.anual.pdf',$alumno->id) }}" class="list-group-item"> Informe de Notas Anual</a>	
<a href="{{route('docente.alumno.canual.pdf',$alumno->id) }}" class="list-group-item"> Certificado de Notas</a>	
<a href="{{route('docentes.curso.index') }}" class="btn btn-success"> Volver a Curso</a>
</div>

@endsection 