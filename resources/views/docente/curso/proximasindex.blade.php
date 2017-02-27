@extends('admin.template.main')
@section('tittle', 'Proximas Evaluaciones')
@section('content')
<a href="{{route('docentes.curso.index') }}" class="btn btn-success"> Volver a Curso</a>
<hr>
<h1>Futuras Evaluaciones </h1>
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
		<td>{{explode(' N',$proxima->Asignatura->nombre)[0]}}</td>	
		<td>{{$proxima->Curso->nombre}}</td>
		<td>{{$proxima->contenido}}</td>
		<td>{{explode('-',$proxima->fecha)[2].'-'.explode('-',$proxima->fecha)[1].'-'.explode('-',$proxima->fecha)[0]}}</td>
		</tr>
<?php
$cont+=1;
?>
	@endforeach

</TBODY>
</table>


@endsection