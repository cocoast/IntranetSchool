@extends('admin.template.main')
@section('tittle', 'Lista de Alumnos')
@section('content')
<!--Cargar Alumnos desde Excel-->
{!!Form::open(['route'=>'admin.alumnos.up','method'=>'POST','class'=>'navbar-form ','files'=>true]) !!}
<div class="form-control">
	{!!Form::label('alumnos','Cargar Alumnos desde Excel')!!}
	{!!Form::file('alumnos') !!}
</div>
<div class="form-group">
	{!!Form::submit('subir',['class'=>'btn btn-primary'])!!}
</div>
{!!Form::close() !!}
<hr>
<!--Fin de Cargar-->
<a href="{{route('admin.alumnos.create') }}" class="btn btn-info"> Registrar Nuevo Alumno</a>
<!--Buscador Alumnos-->
{!!Form::open(['route'=>'admin.alumnos.index','method'=>'GET','class'=>'navbar-form pull-right']) !!}
<div class="input-group">
	<span id="search" class="input-group-addon buscar"><span class="glyphicon glyphicon-search"  aria-hidden="true"></span></span>
	{!!Form::text('name',null,['class'=>'form-control','placeholder'=> 'Buscar Alumno...','aria-describedby'=>'search']) !!}
</div>
{!!Form::close() !!}
<!--Fin de buscador-->

<hr>
<table class="table table-striped">
	<thead>
		<th>NOMBRE</th>
		<th>APELLIDO</th>
		<th>RUT</th>
		<th>EMAIL</th>
		<th>TELEFONO</th>
		<th>DIRECCION</th>
		<th>CURSO</th>
		<th>APODERADO</th>
	</thead>
	<tbody>
		@foreach ($alumnos as $alumno)
		<tr>
			<td>{{$alumno->nombre}}</td>
			<td>{{$alumno->apellido}}</td>
			<td>{{$alumno->rut}}</td>
			<td>{{$alumno->mail}}</td>
			<td>{{$alumno->telefono}}</td>
			<td>{{$alumno->direccion}}</td>
			<td>{{$alumno->curso->nombre}}</td>
			<td>{{$alumno->apoderado->nombre}} {{$alumno->apoderado->apellido}}</td>
			<td>
				<a href="{{route('admin.alumnos.edit',$alumno->id)}}" class="btn btn-warning"><span class="glyphicon glyphicon-wrench"></span></a>
				<a href="{{route('admin.alumno.ghost',$alumno->id)}}" onclick ="return confirm('Eliminar alumno?')" class="btn btn-danger"> <span class="glyphicon glyphicon-remove-circle" ></span> </a>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
<div class="text-center">
	{!!$alumnos->render()!!}
</div>
@endsection