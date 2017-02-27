@extends('admin.template.main')
@section('tittle', 'Crear Proxima Evaluacion')
@section('content')
<a href="{{route('docente.proximas.index',$asignatura->id) }}" class="btn btn-success"> Volver a Futuras Evaluaciones</a>
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
{!!Form::open(['route'=>'docente.proximas.store','method'=>'POST' ]) !!}
<div class="form-group">
{!!Form::label('fecha','Fecha') !!}
{!!Form::date('fecha',\Carbon\Carbon::now(),['class'=>'form-control','step'=>'1','min'=>'2016-03-01'])!!}
</div>
<div class="form-group">
{!!Form::label('contenido','Contenidos') !!}
{!! Form::textarea('contenido', null, ['size' => '30x5','class'=>'form-control','placeholder'=>'Escriba el Contenido ...']) !!}
</div>
<div class="form-group">
{!!Form::label('curso','Cursos')!!}
{!!Form::select('curso',$cursos,null,['class'=>'form-control','placeholder'=>'Seleccione Curso...'])!!}
</div>
{!!Form::hidden('asignatura',$asignatura->id,null)!!}
{!!Form::submit('Registrar Evalaución',['class'=>'btn btn-primary'])!!}
{!!Form::close()!!}
@endsection