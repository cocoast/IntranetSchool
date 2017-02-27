@extends('admin.template.main')
@section('tittle','Editar Docente ' .$docente->nombre ." ". $docente->apellido)

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
{!! Form::open(['route'=>['admin.docentes.update',$docente],'method'=>'PUT' ]) !!} 
<div class="form-group">
	{!!Form::label('nombre','Nombres')!!}
	{!!Form::text('nombre',$docente->nombre,['class'=>'form-control','placeholder'=>'Nombres Docente','requiered'])!!}
</div>
<div class="form-group">
	{!!Form::label('apellido','Apellidos')!!}
	{!!Form::text('apellido',$docente->apellido,['class'=>'form-control','placeholder'=>'Apellidos Docente','requiered'])!!}
</div>
<div class="form-group">
	{!!Form::label('rut','RUT ')!!}
	{!!Form::text('rut',$docente->rut,['class'=>'form-control','placeholder'=>'12345678-9','requiered'])!!}
</div>
<div class="form-group">
	{!!Form::label('mail','Email')!!}
	{!!Form::email('mail',$docente->mail,['class'=>'form-control','placeholder'=>'docente@example.com','requiered'])!!}
</div>
<div class="form-group">
	{!!Form::label('telefono','Telefono')!!}
	{!!Form::text('telefono',$docente->telefono,['class'=>'form-control','placeholder'=>'652345678','requiered'])!!}
</div>
<div class="form-group">
		{!!Form::submit('Editar',['class'=>'btn btn-primary'])!!}
</div>
{!!Form::close()!!}
@endsection
	

	
