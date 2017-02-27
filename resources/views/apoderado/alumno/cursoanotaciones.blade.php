@extends('apoderado.main')
@section('tittle', 'Lista de Anotaciones')
@section('content')
<a href="{{route('apoderado.alumno.asignaturas',$alumno->id)}}" class="btn btn-success"> Volver a Asignaturas</a>
<hr>
<h2>Anotaciones de Curso: {{$curso->nombre}}</h2>
<hr>
<table class="table table-responsive table-hover"> 
	<thead>
		<th style="text-align: left; width: 10%;">TIPO</th>
		<th style="text-align: left; width: 20%;">FECHA</th>
		<th style="text-align: left width:10%;">SEMESTRE</th>
		<th style="text-align: left width:60%;">ANOTACION</th>
		</thead>
	<tbody>
	@foreach($anotaciones AS $anotacion)
	<tr>
		@if($anotacion->tipo==0)
		<td><font color="#FF0000">Negativa</font></td>
		<td><font color="#FF0000">{{explode('-',$anotacion->fecha)[2].'-'.explode('-',$anotacion->fecha)[1].'-'.explode('-',$anotacion->fecha)[0]}}</font></td>
		<td><font color="#FF0000">@if($anotacion->fecha<$establecimiento->s1fin&&$anotacion->fecha>$establecimiento->s1inicio)1
		@endif
		@if($anotacion->fecha<$establecimiento->s2fin&&$anotacion->fecha>$establecimiento->s2inicio)2
		@endif
		</font></td>
		<td><font color="#FF0000">{{$anotacion->anotacion}}</font></td>
		@else
		<td><font color="#0000FF">Positiva</font></td>
		<td><font color="#0000FF">{{explode('-',$anotacion->fecha)[2].'-'.explode('-',$anotacion->fecha)[1].'-'.explode('-',$anotacion->fecha)[0]}}</font></td>
		<td><font color="#0000FF">@if($anotacion->fecha<$establecimiento->s1fin&&$anotacion->fecha>$establecimiento->s1inicio)1
		@endif
		@if($anotacion->fecha<$establecimiento->s2fin&&$anotacion->fecha>$establecimiento->s2inicio)2
		@endif
		</font></td>
		<td><font color="#0000FF">{{$anotacion->anotacion}}</font></td>
		@endif
		
	</tr>
	@endforeach
	</tbody>
</table>
@endsection