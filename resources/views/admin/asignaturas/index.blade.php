@extends('admin.template.main')
@section('tittle', 'Lista de Asignaturas')
@section('content')
<!--Cargar Asignaturas desde Excel-->
{!!Form::open(['route'=>'admin.asignaturas.up','method'=>'POST','class'=>'navbar-form ','files'=>true]) !!}
<div class="form-control">
{!!Form::label('asignaturas','Cargar Asignaturas desde Excel')!!}
{!!Form::file('asignaturas') !!}
</div>
<div class="form-group">
		{!!Form::submit('subir',['class'=>'btn btn-primary'])!!}
</div>
{!!Form::close() !!}
<hr>
<!--Fin de Cargar-->
<a href="{{route('admin.asignaturas.create') }}" class="btn btn-info"> Registrar Nuevo Asignatura</a>

<!--Buscador Asignatura-->
{!!Form::open(['route'=>'admin.asignaturas.index','method'=>'GET','class'=>'navbar-form pull-right']) !!}
<div class="input-group">
<span id="search" class="input-group-addon"><span class="glyphicon glyphicon-search"  aria-hidden="true"></span></span>
{!!Form::text('name',null,['class'=>'form-control','placeholder'=> 'Buscar Asignatura...','aria-describedby'=>'search']) !!}
</div>
{!!Form::close() !!}
<!--Fin de buscador-->

<hr>
<table class="table table-striped">
	<thead>
		<th>NOMBRE</th>
		<th>DOCENTE</th>
		</thead>
	<tbody>
	 @foreach ($asignaturas as $asignatura) 
	 <tr>
	 	<td>{{$asignatura->nombre}}</td>
	 	<td>{{$asignatura->docente->nombre}} {{$asignatura->docente->apellido}}</td>
	 	<td>
	 	<a href="{{route('admin.asignaturas.edit',$asignatura->id)}}" class="btn btn-warning" title="Editar Asignatura"><span class="glyphicon glyphicon-wrench"></span></a>
			<a href="{{route('admin.asignaturas.destroy',$asignatura->id)}}" onclick ="return confirm('Eliminar este asignatura?')" class="btn btn-danger"> <span class="glyphicon glyphicon-remove-circle" title="Eliminar Asignatura"></span> </a>
	 	</td>
	 </tr>
	  
	@endforeach
	</tbody>
</table>
<div class="text-center">
	{!!$asignaturas->render()!!}
</div>
@endsection