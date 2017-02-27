@extends('admin.template.main')

@section('tittle','Editar Usuario ' .$user->name)

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
	{!! Form::open(['route'=>['admin.users.update',$user],'method'=>'PUT' ]) !!} 
	<div class="form-group">
		
		{!!Form::label('name','Nombre')!!}
		{!!Form::text('name',$user->name,['class'=>'form-control','placeholder'=>'nombre Completo','requiered'])!!}
	</div>
	<div class="form-group">
		
		{!!Form::label('email','Correo Electronico')!!}
		{!!Form::email('email',$user->email,['class'=>'form-control','placeholder'=>'example@gmail.com','requiered'])!!}
	</div>
	<div class="form-group">
		{!!Form::label('type','TIPO')!!}
		{!!Form::text('type',$user->type,['class'=>'form-control','readonly'=>'readonly','requiered'])!!}

	</div>
	<div class="form-group">
		{!!Form::submit('Editar',['class'=>'btn btn-primary'])!!}
	</div>
	
	

	{!!Form::close() !!}

@endsection
