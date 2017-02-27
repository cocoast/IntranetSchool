@extends('admin.template.main')
@section('tittle', 'Proximas Evaluaciones')
@section('content')
<a href="{{route('docentes.asignaturas.index') }}" class="btn btn-success"> Volver a Asignaturas</a>
<a href="{{route('docente.proximas.create',$asignatura->id) }}" class="btn btn-info"> Nueva Fecha</a>
<hr>
<table class="table table-striped">
<thead> 
	<th>#</th>
	<th>ASIGNATURA</th>
	<TH>CURSO</TH>
	<th>CONTENIDO</th>
	<th>FECHA</th>
</thead>
<TBODY>
<?php
$cont=1;
?>
	@foreach($proximas AS $proxima)
	<tr>	
		<td>{{$cont}}</td>
		<td>{{$proxima->Asignatura->nombre}}</td>	
		<td>{{$proxima->Curso->nombre}}</td>
		<td>{{$proxima->contenido}}</td>
		<td>{{explode('-',$proxima->fecha)[2].'-'.explode('-',$proxima->fecha)[1].'-'.explode('-',$proxima->fecha)[0]}}</td>
		<td>
			<a href="{{route('docente.proximas.edit',$proxima->id)}}" class="btn btn-warning"><span class="glyphicon glyphicon-wrench" title="Editar"></span></a>
			<a href="{{route('docente.proximas.destroy',$proxima->id)}}" onclick ="return confirm('Eliminar esta Evaluación?')" class="btn btn-danger" title="Eliminar"> <span class="glyphicon glyphicon-remove-circle" ></span> </a>
		</td>
		</tr>
<?php
$cont+=1;
?>
	@endforeach

</TBODY>
</table>


@endsection