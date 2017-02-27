@extends('apoderado.main')
@section('tittle', 'Lista de Asignaturas')
@section('content')
<hr>
<h1>Asignaturas</h1>
<a style="float:  right;" href="{{route('apoderado.alumno.cursoanotaciones',$alumno->id.'-'.$curso->id)}}" class="btn btn-danger btn-lg"> <span class="glyphicon glyphicon-pencil"> Anotaciones Curso</span></a>

<table class="table table-striped table-responsive">
	<thead>
		<th>NOMBRE</th>
		<th>DOCENTE</th>
		<th style="text-align: center">NOTAS</th>
		<th style="text-align: center">E. PROXIMAS</th>
		<th style="text-align: center">ANOTACIONES</th>
		</thead>
	<tbody>
	 @foreach ($asignaturas as $asignatura) 
	 <tr>
<td>{{explode(' N'.$curso->nivel,$asignatura->nombre)[0]}}</td>
<td>{{$asignatura->docente->nombre}} {{$asignatura->docente->apellido}}</td>
<td style="text-align: center">
<a href="{{route('apoderado.alumno.asignaturas.notas',$alumno->id.'-'.$asignatura->id)}}" title="ver Notas" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-book"></span></a>
</td>
<td style="text-align: center"><a href="{{route('apoderado.alumno.asignaturas.proximas',$alumno->id.'-'.$asignatura->id)}}" title="Ver Calendario" class="btn btn-primary btn-lg"> <span class="glyphicon glyphicon-calendar" ></span> </a></td>
<td style="text-align: center"><a href="{{route('apoderado.alumno.asignaturas.anotaciones',$alumno->id.'-'.$asignatura->id)}}" title="Ver Anotaciones" class="btn btn-danger btn-lg"> <span class="glyphicon glyphicon-pencil" ></span> </a></td>
	 </tr>
	  
	@endforeach
	</tbody>
</table>
<div class="text-center">
</div>
@endsection