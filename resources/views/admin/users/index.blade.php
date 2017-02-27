@extends('admin.template.main')
@section('tittle', 'Lista de Usuarios')
@section('content')
<!--Buscador Usuarios-->
{!!Form::open(['route'=>'admin.users.index','method'=>'GET','class'=>'navbar-form pull-right']) !!}
<div class="input-group">
<span id="search" class="input-group-addon buscar"><span class="glyphicon glyphicon-search"  aria-hidden="true"></span></span>
{!!Form::text('name',null,['class'=>'form-control','placeholder'=> 'Buscar Usuario...','aria-describedby'=>'search']) !!}
</div>
{!!Form::close() !!}
<!--Fin de buscador-->
<a href="{{route('admin.users.create') }}" class="btn btn-info"> Registrar Nuevo Usuario</a>
<table class="table table-striped">
	<thead>
		<th>ID</th>
		<th>NOMBRE</th>
		<th>CORREO</th>
		<th>TIPO</th>
	</thead>
	<tbody>
	@foreach($users as $user)
		<tr>
			<td>{{$user->id}}</td>
			<td>{{$user->name}}</td>
			<td>{{$user->email}}</td>
			<td>
				@if($user->type=="admin" ||$user->type=="utp"||$user->type=="matricula")
					<span class="label label-danger">{{$user->type}}</span>
				@endif
				@if($user->type=="alumno")
					<span class="label label-primary">{{$user->type}}</span>
				@endif
				@if($user->type=="docente")
					<span class="label label-warning">{{$user->type}}</span>
				@endif
				@if($user->type=="apoderado")
					<span class="label label-info">{{$user->type}}</span>
				@endif
			</td>
			<td>
			<a href="{{route('admin.users.edit',$user->id)}}" class="btn btn-warning"><span class="glyphicon glyphicon-wrench"></span></a>
			<a href="{{route('admin.users.destroy',$user->id)}}" onclick ="return confirm('Eliminar este usuario?')" class="btn btn-danger"> <span class="glyphicon glyphicon-remove-circle" ></span> </a>
			</td>
		</tr>
	@endforeach		
	</tbody>
</table>
<div class="text-center">
	{!! $users->render()!!}
</div>
@endsection