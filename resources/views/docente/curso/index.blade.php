@extends('admin.template.main')
@section('tittle', 'Lista Alumnos Curso'. ' '.$curso->nombre)
@section('content')
<h1 class="text-right">Lista de Alumnos curso {{$curso->nombre}}</h1>
<hr>
<table class="table table-striped">
<a href="{{route('curso.view.notas',$curso->id)}}" class="btn btn-success"> Notas del Curso</a>
&nbsp;
<a href="{{route('docente.anotaciones.indexCurso',$curso->id)}}" class="btn btn-danger"> Anotaciones del Curso</a>
&nbsp;
<a href="{{route('docente.curso.crasistencia')}}" class="btn btn-info pull-right"> Ingresar Asistencia</a>
&nbsp;
<a href="{{route('docentes.curso.proximasindex',$curso->id) }}" class="btn btn-info"> Futuras Evaluaciones</a>
<hr>
<hr>
<thead> 
	<th>NOMBRE ALUMNO</th>
	<TH>APELLIDO ALUMNO</TH>
	<TH>RUT ALUMNO</TH>
	
</thead>
<TBODY>
	@foreach($alumnos AS $alumno)
	<tr>
		<td>{{$alumno->apellido}}</td>
		<td>{{$alumno->nombre}}</td>
		<td>{{substr($alumno->rut, 0,-1)}}-{{substr($alumno->rut,-1)}}</td>
		<td>
			<a href="{{route('docente.alumno.notas',$alumno->id)}}" title="Ver Notas" class="btn btn-success"><span class="glyphicon glyphicon-book"></span> <span>Ver Notas</span></a>
			<a href="{{route('docente.anotaciones.index',$alumno->id)}}" title="Anotaciones" class="btn btn-danger"><span class="glyphicon glyphicon-pencil"></span> <span>Anotaciones</span></a>
			<a href="{{route('docente.asistencia.index',$alumno->id)}}" title="Ver Asistencia" class="btn btn-info"><span class="glyphicon glyphicon-blackboard"></span> <span>Asistencia</span></a>
			@if(DB::table('asistencia')->where('alumno_id',$alumno->id)->count()>0)
			<span class="glyphicon glyphicon-dashboard" title="Porcentaje Asistencia">{{intval((DB::table('asistencia')->where('alumno_id',$alumno->id)->where('asistencia',1)->count()/DB::table('asistencia')->where('alumno_id',$alumno->id)->count())*100)}}%</span></a>
			@endif	
			@if(App\Antiguo::where('rut',$alumno->rut)->get()->count()!=0)
			<?php
			$antiguo=App\Antiguo::where('rut',$alumno->rut)->first();
			?>
			<a href="{{route('docente.alumno.antiguo',$antiguo->id)}}" class="btn btn-warning"> <span class="glyphicon glyphicon-hourglass" ></span> <span><strong>Rendimiento Historico</strong></span></a>
			@endif		
		</td>
	</tr>
	@endforeach
</TBODY>
	
</table>
<div class="text-center">
	
</div>
@endsection