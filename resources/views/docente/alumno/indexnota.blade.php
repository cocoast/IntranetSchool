@extends('admin.template.main')
@section('tittle', 'Ver Notas Alumno'. ' '. $alumno->nombre .' '.$alumno->apellido)
@section('content')
<a href="{{route('docentes.curso.index') }}" class="btn btn-success"> Volver a Curso</a>
<h1>Ver Notas Alumno {!!$alumno->nombre!!} {!!$alumno->apellido!!}</h1>
<hr>
<a href="{{route('docente.reportes.index',$alumno->id) }}" class="btn btn-info"> Reportes</a>
<hr>
<table class="table table-striped" >
	<thead>
		<tr>
			<th>Asignatura</th>
			<th>1 Semestre</th>
			<th>2 Semestre</th>
		</tr>
	</thead>
<tbody>

	@foreach($asignaturas AS $asignatura)

	<tr>
		<th>{!!explode(' N',$asignatura->nombre)[0]!!}</th>
		<td>
		<table class="table table-bordered">
		@foreach(App\Nota::where('alumno_id',$alumno->id)->where('asignatura_id',$asignatura->id)->where('fecha','>=',$establecimiento->s1inicio)->where('fecha','<=',$establecimiento->s1fin)->orderBy('fecha','ASC')->get() AS $nota)
		@if($nota->nota<40)<td title="contenido:{{$nota->observacion}} fecha:{{$nota->fecha}}"><font color="#FF0000">{!!$nota->nota!!}</font></td>@endif
		@if($nota->nota>40)<td title="contenido:{{$nota->observacion}}  fecha:{{$nota->fecha}}"><font color="#0000FF">{!!$nota->nota!!}</font></td>@endif
		@endforeach
		</table>
	</td>
	<td>
		<table class="table table-bordered">
		@foreach(App\Nota::where('alumno_id',$alumno->id)->where('asignatura_id',$asignatura->id)->where('fecha','>=',$establecimiento->s2inicio)->where('fecha','<=',$establecimiento->s2fin)->orderBy('fecha','ASC')->get() AS $nota)
		@if($nota->nota<40)<td title="contenido:{{$nota->observacion}} fecha:{{$nota->fecha}}"><font color="#FF0000">{!!$nota->nota!!}</font></td>@endif
		@if($nota->nota>40)<td title="contenido:{{$nota->observacion}} fecha:{{$nota->fecha}}"><font color="#0000FF">{!!$nota->nota!!}</font></td>@endif
		@endforeach
		</table>
	</td>	
	
	</tr>

	@endforeach


</tbody>



</table>



@endsection