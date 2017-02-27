@extends('admin.template.main')
@section('tittle', 'Agregar Notas Curso'. ' '.$curso->nombre )
@section('content')

<a href="{{route('docentes.asignaturas.index') }}" class="btn btn-info"> Volver a Asignaturas</a>
@if(count($errors)>0)
<div class="alert alert-danger alert-dismissible" role="alert">
	<button type="button" data-dismiss="alert"  aria-label="Close" class="close"><span aria-hidden="true"> &times;</span></button>
	<ul>
		@foreach($errors->all() as $error)
		@if(strpos($error,'nota')===false)
		<li>{!!$error!!} </li>
		@else
		<?php
		$nota=explode(' ',$error)[2];
		$id=explode('-',$nota)[1];
		$mensaje=explode('El campo nota-'.$id,$error)[1];
		$al=App\Alumno::find($id);
		?>
		<li>{!!'La nota del alumno: '.$al->apellido.' '.$al->nombre.', '.$mensaje!!}</li>
		@endif
		@endforeach
	</ul>
</div>
@endif
<h1 class='text-right'>Agregar Notas {{$asignatura->nombre}} Curso  {{$curso->nombre}} </h1>
<hr>
{!!Form::open(['route'=>'docente.notas.store','method'=>'POST' ,'id'=>'nota'])!!}
<div class='form-inline'>
	{!!Form::label('fecha','Fecha de evaluación:')!!}
	{!!Form::date('fecha',null,['class'=>'form-control','step'=>'1','min'=>'2015-03-01','requiered'])!!}
	{!!Form::label('observacion','Descripcion de la evaluación:')!!}
	{!!Form::text('observacion',null,['class'=>'form-control','placeholder'=>'Pertenece a...','requiered'])!!}
</div>
<div class='form-group'>
	{!!Form::hidden('asignatura',$asignatura->id,null)!!}
	{!!Form::hidden('curso',$curso->id,null)!!}
</div>
<div class="form-group">
	<table class="table table-striped">
		<thead>
			<th>#</th>
			<th>Apellido</th>
			<th>Nombre</th>
			<th>rut</th>
			<th style="width: 70px;">Nota</th>
		</thead>
		<tbody>
			<?php
			$cont=1;
			?>
			@foreach($alumnos AS $alumno)
			<tr>
				<td>{{$cont}}</td>
				<td>{{$alumno->apellido}}</td>
				<td>{{$alumno->nombre}}</td>
				<td>{{$alumno->rut}}</td>
				<td>   
					{!!Form::text('nota'.'-'.$alumno->id,null,['class'=>'form-control','placeholder'=>'70','requiered','id'=>'nota'.'-'.$alumno->id])!!}
					{!!Form::hidden('alumno'.'-'.$alumno->id,$alumno->id,null)!!}

				</td>
			</tr>
			<?php
			$cont++;
			?>
			@endforeach
		</tbody>
	</table>
</div>
{!!Form::submit('Registrar Notas Curso',['class'=>'btn btn-primary','onclick'=>'return confirm("Esta Seguro que desea subir estas Notas ?")'])!!}
{!!Form::close()!!}
</div>
@endsection

