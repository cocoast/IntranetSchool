@extends('admin.template.main')
@section('tittle','Crear Asignatura')

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
{!! Form::open(['route'=>'admin.asignaturas.store','method'=>'POST' ]) !!} 
<div class="form-group">
	{!!Form::label('nombre','Nombres')!!}
	{!!Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Nombre Asignatura','requiered'])!!}
</div>
<div class="form-group">
	{!!Form::label('docente_id','Docente ID')!!}
	{!!Form::select('docente_id',$docentes,['placeholder'=>'Seleccione un Docente...']) !!}
</div>
<div class="form-group">
		{!!Form::submit('Registrar',['class'=>'btn btn-primary'])!!}
</div>
{!!Form::close()!!}
@endsection