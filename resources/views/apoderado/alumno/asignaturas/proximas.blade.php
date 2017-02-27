@extends('apoderado.main')
@section('tittle', 'Lista de Proximas Evaluaciones')
@section('content')
<a href="{{route('apoderado.alumno.asignaturas',$alumno->id)}}" class="btn btn-success"> Volver a Asignaturas</a>
<hr>
<h2>Proximas Evaluaciones de la Asignatura: {{explode(' N',$asignatura->nombre)[0]}}</h2>
<hr>
<table class="table table-responsive table-hover"> 
	<thead>
		<th style="text-align: left; width: 20%;">FECHA</th>
		<th style="text-align: left width:80%;">CONTENIDO</th>
		</thead>
	<tbody>
	@foreach($proximas AS $proxima)
	<tr>

		<td>{{explode('-',$proxima->fecha)[2].'-'.explode('-',$proxima->fecha)[1].'-'.explode('-',$proxima->fecha)[0]}}</td>
		<td>{{$proxima->contenido}}</td>
		
	</tr>
	@endforeach
	</tbody>
</table>
@endsection