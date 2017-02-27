@extends('admin.template.main')
@section('tittle', 'Lista de Apoderados')
@section('content')
<!--Cargar Apoderos desde Excel-->
{!!Form::open(['route'=>'admin.apoderados.up','method'=>'POST','class'=>'navbar-form ','files'=>true]) !!}
<div class="form-control">
{!!Form::label('apoderados','Cargar Apoderados desde Excel')!!}
{!!Form::file('apoderados') !!}
</div>
<div class="form-group">
		{!!Form::submit('subir',['class'=>'btn btn-primary'])!!}
</div>
{!!Form::close() !!}
<hr>
<!--Fin de Cargar-->
<a href="{{route('admin.apoderados.create') }}" class="btn btn-info"> Registrar Nuevo Apoderado</a>
<!--Buscador Apoderados-->
{!!Form::open(['route'=>'admin.apoderados.index','method'=>'GET','class'=>'navbar-form pull-right']) !!}
<div class="input-group">
<span id="search" class="input-group-addon buscar"><span class="glyphicon glyphicon-search"  aria-hidden="true"></span></span>
{!!Form::text('name',null,['class'=>'form-control','placeholder'=> 'Buscar Apoderado...','aria-describedby'=>'search']) !!}
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
		</thead>
	<tbody>
	 @foreach ($apoderados as $apoderado) 
	 <tr>
	 	<td>{{$apoderado->nombre}}</td>
	 	<td>{{$apoderado->apellido}}</td>
	 	<td>{{$apoderado->rut}}</td>
	 	<td>{{$apoderado->mail}}</td>
	 	<td>{{$apoderado->telefono}}</td>
	 	<td>
	 		<a href="{{route('admin.apoderados.edit',$apoderado->id)}}" class="btn btn-warning"><span class="glyphicon glyphicon-wrench"></span></a>
			<a href="{{route('admin.apoderados.destroy',$apoderado->id)}}" onclick ="return confirm('Eliminar este Docente?')" class="btn btn-danger"> <span class="glyphicon glyphicon-remove-circle" ></span> </a>
	 	</td>
	 </tr>
	  
	@endforeach
	</tbody>
	</table>
	<div class="text-center">
	{!!$apoderados->render()!!}
	</div>
@endsection