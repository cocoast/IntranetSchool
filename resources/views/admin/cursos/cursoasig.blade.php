@extends('admin.template.main')
@section('tittle', 'Seleccionar Asignaturas de curso')
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
{!! Form::open(['route'=>'admin.cursos.storeca','method'=>'POST' ]) !!} 
<div class="form-group">
	{!!Form::label('curso','Nombre Curso')!!}
	{!!Form::text('curso',$curso->nombre,['class'=>'form-control','requiered','readonly'=>'readonly'])!!}
	{!!Form::hidden('curso_id',$curso->id)!!}
</div>
<div class="form-group">
	{!!Form::label('asignaturas','Asignaturas (use tecla ctrl para seleccionar mas de una asignatura)')!!}
	{!!Form::select('asignaturas[]',$asignaturas,$my_tags,['class'=>'form-control','multiple','requiered','size'=>'20x2']) !!}
	
	
</div>

<div class="form-group">
		{!!Form::submit('Registrar',['class'=>'btn btn-primary'])!!}
</div>
{!!Form::close()!!}


@endsection