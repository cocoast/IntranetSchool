@extends('admin.template.main')
@section('tittle', 'Notas Alumnos Curso'. ' '.$curso->nombre)
@section('content')

<a href="{{route('docentes.curso.index') }}" class="btn btn-success"> Volver a Curso</a>
<hr>
<h4>Notas del Curso: {{$curso->nombre}}</h4>
<div class=" asignatura">
@foreach($idasignaturas AS $id)
<?php
$asignatura=App\Asignatura::find($id->asignatura_id);
$nombre=explode(' N',$asignatura->nombre)[0];
?>
<a href="#{!!$nombre!!}" class="btn btn-info" style="max-width: 10%;" title="{!!$nombre!!}">{!!$nombre!!}</a>
@endforeach
<hr>
</div>
@foreach($idasignaturas AS $id)
<?php
$asignatura=App\Asignatura::find($id->asignatura_id);
$nombre=explode(' N',$asignatura->nombre)[0];
?>

<A name="{!!$nombre!!}" class="pull-right">
<h2>{!!$nombre!!}</h2>
</A>

<table class="table table-striped">
	<thead>
		<th>Nombre</th>
		<th>Apellidos</th>
		<th>Rut</th>
		<th>1 Semestre</th>
		<th>2 Semestre</th>
	</thead>
	<tbody>
		@foreach($alumnos AS $alumno)
		<tr>
			<td>{!!$alumno->apellido!!}</td>
			<td>{!!$alumno->nombre!!}</td>
			<td>{!!$alumno->rut!!}</td>
			<td>
		<table class="table table-bordered">
		@foreach(App\Nota::where('alumno_id',$alumno->id)->where('asignatura_id',$asignatura->id)->where('fecha','>=',$establecimiento->s1inicio)->where('fecha','<=',$establecimiento->s1fin)->orderBy('fecha','ASC')->get() AS $nota)
		@if($nota->nota<40)<td title="contenido:{{$nota->observacion}} fecha:{{$nota->fecha}}" style="max-width: 70px;"><font color="#FF0000">{!!$nota->nota!!}</font></td>@endif
		@if($nota->nota>=40)<td title="contenido:{{$nota->observacion}} fecha:{{$nota->fecha}}" style="max-width: 70px;"><font color="#0000FF">{!!$nota->nota!!}</font></td>@endif

		@endforeach
		</table>
	</td>
	<td>
		<table class="table table-bordered">
		@foreach(App\Nota::where('alumno_id',$alumno->id)->where('asignatura_id',$asignatura->id)->where('fecha','>=',$establecimiento->s2inicio)->where('fecha','<=',$establecimiento->s2fin)->orderBy('fecha','ASC')->get() AS $nota)
		@if($nota->nota<40)<td title="contenido:{{$nota->observacion}} fecha:{{$nota->fecha}}" style="max-width: 70px;"><font color="#FF0000">{!!$nota->nota!!}</font></td>@endif
		@if($nota->nota>=40)<td title="contenido:{{$nota->observacion}} fecha:{{$nota->fecha}}" style="max-width: 70px;"><font color="#0000FF">{!!$nota->nota!!}</font></td>@endif
		@endforeach
		</table>
	</td>	
			</td>
		</tr>
		@endforeach
	</tbody>
</table>

@endforeach
@endsection
