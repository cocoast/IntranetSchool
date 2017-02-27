@extends('admin.template.main')
@section('tittle','Editar Curso '. $curso->nombre)

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
{!! Form::open(['route'=>['admin.cursos.update',$curso],'method'=>'PUT' ]) !!} 
<div class="form-group">
	{!!Form::label('nombre','Nombre Curso')!!}
	{!!Form::text('nombre',$curso->nombre,['class'=>'form-control','placeholder'=>'1 A','requiered'])!!}
</div>
<div class="form-group">
	{!!Form::label('nivel','Nivel')!!}
	{!!Form::select('nivel',['2'=>'Basica','3'=>'Media'],$curso->nivel)!!}
</div>
<div class="form-group">
	{!!Form::label('docente_id','Docente ID')!!}
	{!!Form::select('docente_id',$docentes,$curso->docente_id) !!}
</div>
<div class="form-group">
		{!!Form::submit('Editar',['class'=>'btn btn-primary'])!!}
</div>
{!!Form::close()!!}
@endsection