@extends('admin.template.main')
@section('tittle','Crear Docente')

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
{!! Form::open(['route'=>'admin.docentes.store','method'=>'POST' ]) !!} 
<div class="form-group">
	{!!Form::label('nombre','Nombres')!!}
	{!!Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Nombres Docente','requiered'])!!}
</div>
<div class="form-group">
	{!!Form::label('apellido','Apellidos')!!}
	{!!Form::text('apellido',null,['class'=>'form-control','placeholder'=>'Apellidos Docente','requiered'])!!}
</div>
<div class="form-group">
	{!!Form::label('rut','RUT ')!!}
	{!!Form::text('rut',null,['class'=>'form-control','placeholder'=>'12345678-9','requiered'])!!}
</div>
<div class="form-group">
	{!!Form::label('mail','Email')!!}
	{!!Form::email('mail',null,['class'=>'form-control','placeholder'=>'docente@example.com','requiered'])!!}
</div>
<div class="form-group">
	{!!Form::label('telefono','Telefono')!!}
	{!!Form::text('telefono',null,['class'=>'form-control','placeholder'=>'652345678','requiered'])!!}
</div>
<div class="form-group">
		{!!Form::submit('Registrar',['class'=>'btn btn-primary'])!!}
</div>
{!!Form::close()!!}
@endsection
	

	
