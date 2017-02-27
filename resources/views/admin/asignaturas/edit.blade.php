@extends('admin.template.main')
@section('tittle','Editar Asignatura '. $asignatura->nombre)

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
{!! Form::open(['route'=>['admin.asignaturas.update',$asignatura],'method'=>'PUT' ]) !!} 
<div class="form-group">
	{!!Form::label('nombre','Nombres')!!}
	{!!Form::text('nombre',$asignatura->nombre,['class'=>'form-control','requiered'])!!}
</div>
<div class="form-group">
	{!!Form::label('docente_id','Docente ID')!!}
	{!!Form::select('docente_id',$docentes,$asignatura->docente_id) !!}
</div>
<div class="form-group">
		{!!Form::submit('Editar',['class'=>'btn btn-primary'])!!}
</div>
{!!Form::close()!!}
@endsection