@extends('admin.template.main')
@section('tittle', 'Lista de Notas')
@section('content')
<a href="{{route('alumno.asignaturas.index')}}" class="btn btn-success"> Volver a Asignaturas</a>
<hr>
<h2>Notas del alumno: {{$alumno->nombre}} {{$alumno->apellido}} en la Asignatura: {{explode(' N'.$curso->nivel,$asignatura->nombre)[0]}}</h2>
<hr>
<table class="table table-responsive table-hover"> 
	<thead>
		<th style="text-align: left; width: 40%;">CONTENIDO</th>
		<th style="text-align: left; width: 20%;">FECHA</th>
		<th style="text-align: left width:10%;">SEMESTRE</th>
		<th style="text-align: left width:30%;">NOTA</th>
		</thead>
	<tbody>
	@foreach($notas AS $nota)
	<tr>
		<td>{{$nota->observacion}}</td>
		<td>{{explode('-',$nota->fecha)[2].'-'.explode('-',$nota->fecha)[1].'-'.explode('-',$nota->fecha)[0]}}</td>
		<td>
		@if($nota->fecha<$establecimiento->s1fin&&$nota->fecha>$establecimiento->s1inicio)1
		@endif
		@if($nota->fecha<$establecimiento->s2fin&&$nota->fecha>$establecimiento->s2inicio)2
		@endif</td>
		@if($nota->nota<40)<td><font color="#FF0000">{!!$nota->nota!!}</font></td>@endif
		@if($nota->nota>=40)<td><font color="#0000FF">{!!$nota->nota!!}</font></td>@endif
	</tr>
	@endforeach
	</tbody>
</table>
@endsection