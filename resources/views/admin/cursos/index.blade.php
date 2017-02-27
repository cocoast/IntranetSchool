@extends('admin.template.main')
@section('tittle', 'Lista de Cursos')
@section('content')
<!--Cargar cursos desde Excel-->
{!!Form::open(['route'=>'admin.cursos.up','method'=>'POST','class'=>'navbar-form ','files'=>true]) !!}
<div class="form-control">
	{!!Form::label('cursos','Cargar Cursos desde Excel')!!}
	{!!Form::file('cursos') !!}
</div>
<div class="form-group">
	{!!Form::submit('subir',['class'=>'btn btn-primary'])!!}
</div>
{!!Form::close() !!}
<hr>
<!--Fin de Cargar-->
<a href="{{route('admin.cursos.create') }}" class="btn btn-info"> Registrar Nuevo Curso</a>
<table class="table table-striped">
	<thead>
		<th>NOMBRE</th>
		<th>NIVEL</th>
		<th>DOCENTE</th>
	</thead>
	<tbody>
		@foreach ($cursos as $curso) 
		@if($curso->nombre!='Ghost')
		<tr>
			<td>{{$curso->nombre}}</td>
			<td>@if($curso->nivel==2)Basica @else Media @endif</td>
			<td>{{$curso->docente->nombre}} {{$curso->docente->apellido}}</td>
			<td>
				<a href="{{route('admin.cursos.edit',$curso->id)}}" class="btn btn-warning" title="editar"><span class="glyphicon glyphicon-wrench"></span></a>
				<a href="{{route('admin.cursos.destroy',$curso->id)}}" title="eliminar" onclick ="return confirm('Eliminar este Curso?')" class="btn btn-danger"> <span class="glyphicon glyphicon-remove-circle" ></span> </a>
				<a href="{{route('admin.cursos.asignaturas',$curso->id)}}" class="btn btn-success" title="Relacionar Cursos Y Asignaturas"><span class="glyphicon glyphicon-book"></span></a>
			</td>
		</tr>
		@endif	  
		@endforeach
	</tbody>
</table>
<div class="text-center">
	{!!$cursos->render()!!}
</div>
@endsection