@extends('admin.template.main')

@section('tittle','Login')
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
		{!! Form::open(['route' =>'admin.auth.login','method'=>'POST']) !!}
	<div class="form-group">
		{!!Form::label('email','Correo Electronico')	!!} 
		{!!Form::text('email',null,['class'=>'form-control','placeholder'=>'example@gmail.com'])!!}</div>
	
	<div class="form-group">
		{!!Form::label('password','Password')	!!} 
		{!!Form::password('password',['class'=>'form-control','placeholder'=>'******'])!!}
	</div>
	
	<div class="form-group">
		{!!Form::submit('Acceder',['class'=>'btn btn-primary'])	!!}
	</div>
	
		{!!Form::close()!!}
@endsection