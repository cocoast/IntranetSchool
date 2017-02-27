@extends('admin.template.main')
@section('tittle', 'Inicio Docente')
@section('content')
<a href="{{route('docentes.reunion.create') }}" class="btn btn-info"> Nuevo Comunicado</a>
<hr>
<table class="table table-striped table-bordered table-hover table-condensed ">
	<thead>
		<th style="width: 100px;">Fecha</th>
		<th style="text-align: center;">Comunicado</th>
	</thead>
	<tbody>
	@foreach($comunicados as $comunicado)
		<tr>
			<td>{{explode('-',$comunicado->fecha)[2]}}-{{explode('-',$comunicado->fecha)[1]}}-{{explode('-',$comunicado->fecha)[0]}}</td>
			<td>{{$comunicado->contenido}}</td>
			<td><a href="{{route('docentes.reunion.edit',$comunicado->id)}}" class="btn btn-warning"><span class="glyphicon glyphicon-wrench"></span></a>
				<a href="{{route('docentes.reunion.destroy',$comunicado->id)}}" onclick ="return confirm('Eliminar Comunicado?')" class="btn btn-danger"> <span class="glyphicon glyphicon-remove-circle" ></span> </a>
			</td>
		</tr>
		@endforeach
	</tbody>




</table>
@endsection