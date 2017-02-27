@extends('admin.template.main')
@section('tittle', 'Crear Anotaciones Curso'. ' '. $curso->nombre )
@section('content')
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
<h1 class="text-right">Crear anotacion para {{$curso->nombre}}</h1>
{!!Form::open(['route'=>'docente.anotacionescurso.store','method'=>'POST' ])!!}
<div class="form-group">
{!!Form::label('tipo','Tipo de Anotacion')!!}
{!!Form::select('tipo',['1'=>'Positiva','0'=>'Negativa'],null,['class'=>'form-control','placeholder'=>'Seleccione un tipo...'])!!}
</div>
<div class="form-group">
{!!Form::label('fecha','Seleccione Fecha')!!}
{!!Form::date('fecha',\Carbon\Carbon::now(),['class'=>'form-control','step'=>'1','min'=>'2016-03-01'])!!}
</div>
<div class="form-group">
{!!Form::label('asignatura','Seleccione Asignatura')!!}
{!!Form::select('asignatura',$asignaturas,null,['class'=>'form-control','placeholder'=>'Seleccione Asignatura...'])!!}	
</div>
<div class="form-group">
	{!!Form::label('anotacion','Escriba Anotacion')!!}
	{!! Form::textarea('anotacion', null, ['size' => '30x5','class'=>'form-control','placeholder'=>'Escriba anotacion ...']) !!}
</div>
{!!Form::hidden('curso',$curso->id)!!}
{!!Form::submit('Registrar Anotacion',['class'=>'btn btn-primary'])!!}
{!!Form::close()!!}
@endsection