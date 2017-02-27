@extends('admin.template.main')
@section('tittle', 'Lista de Asignaturas')
@section('content')
<hr>
<h1>Asignaturas</h1>
<div class="row"><a style="float:  right;" href="{{route('alumno.cursoanotaciones.index')}}" class="btn btn-danger btn-lg"> <span class="glyphicon glyphicon-pencil"></span> <span>Anotaciones Curso</span></a></div>

<hr>
<div class="row">
	<table class="table table-responsive table-hover" style="max-width: 80%;"> 
		<thead>
			<th>NOMBRE</th>
			<th>DOCENTE</th>
			<th style="text-align: center">NOTAS</th>
			<th style="text-align: center">EVALUACIONES PROXIMAS</th>
			<th style="text-align: center">ANOTACIONES</th>
		</thead>
		<tbody>
			@foreach ($asignaturas as $asignatura) 
			<tr>
				<td>{{explode(' N'.$curso->nivel,$asignatura->nombre)[0]}}</td>
				<td>{{$asignatura->docente->nombre}} {{$asignatura->docente->apellido}}</td>
				<td style="text-align: center"><a href="{{route('alumno.asignaturas.notas',$asignatura->id)}}" title="ver Notas" class="btn btn-success"><span class="glyphicon glyphicon-book"></span></a></td>
				<td style="text-align: center"><a href="{{route('alumno.asignaturas.proximas',$asignatura->id)}}" title="Ver Calendario" class="btn btn-primary "> <span class="glyphicon glyphicon-calendar" ></span> </a></td>
				<td style="text-align: center"><a href="{{route('alumno.asignaturas.Anotaciones',$asignatura->id)}}" title="Ver Anotaciones" class="btn btn-danger "> <span class="glyphicon glyphicon-pencil" ></span> </a></td>
			</tr>

			@endforeach
		</tbody>
	</table>
</div>

<div class="text-center">
</div>
@endsection