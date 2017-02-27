@extends('admin.template.main')
@section('tittle', 'Lista de Docentes')
@section('content')
<!--Cargar Docentes desde Excel-->
{!!Form::open(['route'=>'admin.docentes.up','method'=>'POST','class'=>'navbar-form ','files'=>true]) !!}
<div class="form-control">
{!!Form::label('docentes','Cargar Docentes desde Excel')!!}
{!!Form::file('docentes',['accept'=>'.xls']) !!}
</div>
<div class="form-group">
		{!!Form::submit('subir',['class'=>'btn btn-primary'])!!}
</div>
{!!Form::close() !!}
<hr>
<!--Fin de Cargar-->
<a href="{{route('admin.docentes.create') }}" class="btn btn-info"> Registrar Nuevo Docente</a>
<!--Buscador Docentes-->
{!!Form::open(['route'=>'admin.docentes.index','method'=>'GET','class'=>'navbar-form pull-right']) !!}
<div class="input-group">
<span id="search" class="input-group-addon buscar"><span class="glyphicon glyphicon-search"  aria-hidden="true"></span></span>
{!!Form::text('name',null,['class'=>'form-control','placeholder'=> 'Buscar Docente...','aria-describedby'=>'search']) !!}
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
	 @foreach ($docentes as $docente) 
	  @if($docente->nombre!='Ghost')
	 <tr>
	
	 	<td>{{$docente->nombre}}</td>
	 	<td>{{$docente->apellido}}</td>
	 	<td>{{$docente->rut}}</td>
	 	<td>{{$docente->mail}}</td>
	 	<td>{{$docente->telefono}}</td>
	 	<td>
	 		<a href="{{route('admin.docentes.edit',$docente->id)}}" class="btn btn-warning"><span class="glyphicon glyphicon-wrench" title="Editar Docente"></span></a>
			<a href="{{route('admin.docentes.destroy',$docente->id)}}" onclick ="return confirm('Eliminar este Docente?')" class="btn btn-danger" title="Eliminar Docente"> <span class="glyphicon glyphicon-remove-circle" ></span> </a>
	 	</td>
	 </tr>
	  	@endif
	@endforeach
	</tbody>
	</table>
	<div class="text-center">
		{!!$docentes->render()!!}
	</div>
@endsection