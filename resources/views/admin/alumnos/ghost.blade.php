@extends('admin.template.main')
@section('tittle', 'Lista de Alumnos Antiguos')
@section('content')

<!--Buscador Alumnos-->
{!!Form::open(['route'=>'admin.alumno.listghost','method'=>'GET','class'=>'navbar-form pull-right']) !!}
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
	
	</thead>
	<tbody>
		@foreach ($alumnos as $alumno) 
	
		<tr>
			<td>{{$alumno->nombre}}</td>
			<td>{{$alumno->apellido}}</td>
			<td>{{$alumno->rut}}</td>
			<td>
				<a href="{{route('admin.antiguo.asignaturas',$alumno->id)}}" class="btn btn-success"> <span class="glyphicon glyphicon-hourglass" ></span> <span><strong>Rendimiento Historico</strong></span></a>
			</td>
		</tr>
	
		@endforeach
	</tbody>
</table>
<div class="text-center">
	{!!$alumnos->render()!!}
</div>
@endsection