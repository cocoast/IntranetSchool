@extends('admin.template.main')
@section('tittle','Editar Apoderado '. $apoderado->nombre .' '.$apoderado->apellido)

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
{!! Form::open(['route'=>['admin.apoderados.update',$apoderado],'method'=>'PUT' ]) !!} 
<div class="form-group">
	{!!Form::label('nombre','Nombres')!!}
	{!!Form::text('nombre',$apoderado->nombre,['class'=>'form-control','placeholder'=>'Nombres Apoderado','requiered'])!!}
</div>
<div class="form-group">
	{!!Form::label('apellido','Apellidos')!!}
	{!!Form::text('apellido',$apoderado->apellido,['class'=>'form-control','placeholder'=>'Apellidos Apoderado','requiered'])!!}
</div>
<div class="form-group">
	{!!Form::label('rut','RUT ')!!}
	{!!Form::text('rut',$apoderado->rut,['class'=>'form-control','placeholder'=>'12345678-9','requiered'])!!}
</div>
<div class="form-group">
	{!!Form::label('mail','Email')!!}
	{!!Form::email('mail',$apoderado->mail,['class'=>'form-control','placeholder'=>'apoderado@example.com','requiered'])!!}
</div>
<div class="form-group">
	{!!Form::label('telefono','Telefono')!!}
	{!!Form::text('telefono',$apoderado->telefono,['class'=>'form-control','placeholder'=>'652345678','requiered'])!!}
</div>
<div class="form-group">
		{!!Form::submit('Editar',['class'=>'btn btn-primary'])!!}
</div>
{!!Form::close()!!}
@endsection
	

	
