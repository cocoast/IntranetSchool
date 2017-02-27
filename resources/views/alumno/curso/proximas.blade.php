@extends('admin.template.main')
@section('tittle', 'Lista de Proximas Evaluaciones')
@section('content')
<a href="{{route('alumno.asignaturas.index')}}" class="btn btn-success"> Volver a Asignaturas</a>
<hr>
<h2>Proximas Evaluaciones curso: {{$curso->nombre}}</h2>
<hr>
<table class="table table-responsive table-hover"> 
	<thead>
		<th style="text-align: left width:80%;">ASIGNATURA</th>
		<th style="text-align: left; width: 20%;">FECHA</th>
		<th style="text-align: left width:80%;">CONTENIDO</th>
		</thead>
	<tbody>
	@foreach($proximas AS $proxima)
	<tr>
		<td>{{explode(' N'.$curso->nivel,$proxima->asignatura->nombre)[0]}}</td>
		<td>{{explode('-',$proxima->fecha)[2].'-'.explode('-',$proxima->fecha)[1].'-'.explode('-',$proxima->fecha)[0]}}</td>
		<td>{{$proxima->contenido}}</td>
		
	</tr>
	@endforeach
	</tbody>
</table>
@endsection