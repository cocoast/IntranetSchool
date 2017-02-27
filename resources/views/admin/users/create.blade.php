@extends('admin.template.main')

@section('tittle','Crear Usuario')

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
	{!! Form::open(['route'=>'admin.users.store','method'=>'POST' ]) !!} 
	<div class="form-group">
		
		{!!Form::label('name','Nombre')!!}
		{!!Form::text('name',null,['class'=>'form-control','placeholder'=>'nombre Completo','requiered'])!!}
	</div>
	<div class="form-group">
		
		{!!Form::label('email','Correo Electronico')!!}
		{!!Form::email('email',null,['class'=>'form-control','placeholder'=>'example@gmail.com','requiered'])!!}
	</div>
	<div class="form-group">
		
		{!!Form::label('password','Contraseña')!!}
		{!!Form::password('password',['class'=>'form-control','placeholder'=>'*******','requiered'])!!}
	</div>
	<div class="form-group">
		
		{!!Form::label('type','TIPO')!!}
		{!!Form::select('type',['admin'=>'Direccion'],null,['class'=>'form-control','placeholder'=>'Seleccione un tipo...'])!!}
	</div>
	<div class="form-group">
		{!!Form::submit('Registrar',['class'=>'btn btn-primary'])!!}
	</div>
	
	

	{!!Form::close() !!}

@endsection
