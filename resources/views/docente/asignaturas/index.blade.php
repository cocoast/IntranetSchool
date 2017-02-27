@extends('admin.template.main')
@section('tittle', 'Lista de Asignaturas')
@section('content')
<table class="table table-striped">
<thead> 
	<th>NOMBRE ASIGNATURA</th>
	<TH>CURSO</TH>
	<th>NOTAS</th>
	<th style="text-align: center; width: 50px;">PROXIMAS<BR>EVALUACIONES </th>

</thead>
<TBODY>
	@foreach($asignaturas AS $asignatura)
	@foreach($asignatura->cursos()->lists('curso_id')->toArray() AS $curso)	
	<tr>	
		<td>{{$asignatura->nombre}}</td>
		<td>{{App\Curso::where('id',$curso)->first()->nombre}}</td>
		<td>
		<?php $var=App\Curso::where('id',$curso)->first()->id.'-'.$asignatura->id; ?>
			<a href="{{route('docente.notas.creates',$var)}}" title="Agregar Notas" class="btn btn-success"><span class="glyphicon glyphicon-book"></span> <span>Agregar Notas</span></a>
			<a href="{{route('docente.notas.index',$var)}}" title="Ver Notas" class="btn btn-warning"><span class="glyphicon glyphicon-eye-open"></span> <span>Ver Notas</span></a>	
		</td>
		<td style="text-align: center;"><a href="{{route('docente.proximas.index',$asignatura->id)}}" title="Agregar Proximas Evaluaciones" class="btn btn-info"><span class="glyphicon glyphicon-calendar"></span> <span>Proximas Evaluaciones</span></a></td>
		
	</tr>
	@endforeach
	@endforeach
</TBODY>
	
</table>
<div class="text-center">
	
</div>
@endsection