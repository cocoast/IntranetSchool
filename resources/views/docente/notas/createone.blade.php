@extends('admin.template.main')
@section('tittle', 'Agregar Nota'. ' '. $alumno->nombre.' '.$alumno->apellido)
@section('content')
<a href="{{route('docentes.asignaturas.index') }}" class="btn btn-success"> Volver a Notas</a>
@if(count($errors)>0)
<div class="alert alert-danger alert-dismissible" role="alert">
	<button type="button" data-dismiss="alert"  aria-label="Close" class="close"><span aria-hidden="true"> &times;</span></button>
	<ul>
		@foreach($errors->all() as $error)
		<li>{!!$error!!}</li>
		@endforeach
	</ul>
</div>
@endif
<h2>Agregar nota Alumno: {{$alumno->nombre}} {{$alumno->apellido}} con fecha {{$fecha}}</h2>
{!!Form::open(['route'=>'docente.notas.storeone','method'=>'POST' ])!!}
<div class="form-group">	
	{!!Form::label('nota','Ingrese Nota')!!}
	{!! Form::text('nota', null, ['class'=>'form-control','placeholder'=>'Ingrese Nota ...']) !!}
	{!!Form::hidden('alumno',$alumno->id)!!}
	{!!Form::hidden('observacion',$observacion)!!}
	{!!Form::hidden('fecha',$fecha)!!}
	{!!Form::hidden('asignatura',$asignatura->id)!!}
</div>
{!!Form::submit(' Nota',['class'=>'btn btn-primary'])!!}
{!!Form::close()!!}
@endsection