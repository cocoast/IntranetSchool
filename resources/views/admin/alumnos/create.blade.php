@extends('admin.template.main')
@section('tittle','Crear Alumno')

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
<h1>Datos del Alumno</h1>
{!! Form::open(['route'=>'admin.alumnos.store','method'=>'POST' ]) !!} 
<div class="form-group">
	{!!Form::label('nombre','Nombres')!!}
	{!!Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Nombres Alumno','requiered'])!!}
</div>
<div class="form-group">
	{!!Form::label('apellido','Apellidos')!!}
	{!!Form::text('apellido',null,['class'=>'form-control','placeholder'=>'Apellidos Alumno','requiered'])!!}
</div>
<div class="form-group">
	{!!Form::label('rut','RUT ')!!}
	{!!Form::text('rut',null,['class'=>'form-control','placeholder'=>'12345678-9','requiered'])!!}
</div>
<div class="form-group">
	{!!Form::label('mail','Email')!!}
	{!!Form::email('mail',null,['class'=>'form-control','placeholder'=>'alumno@example.com','requiered'])!!}
</div>
<div class="form-group">
	{!!Form::label('telefono','Telefono')!!}
	{!!Form::text('telefono',null,['class'=>'form-control','placeholder'=>'652345678','requiered'])!!}
</div>
<div class="form-group">
	{!!Form::label('direccion','Direccion')!!}
	{!!Form::text('direccion',null,['class'=>'form-control','placeholder'=>'Avenida Siempre Viva N° 742','requiered'])!!}
</div>
<div class="form-group">
	{!!Form::label('curso_id','Curso')!!}
	{!!Form::select('curso_id',$cursos,null, ['placeholder' => 'Seleccion Curso...','class'=>'form-control']) !!}

</div>
<div class="form-group">
	{!!Form::label('apoderado_id','Apoderado')!!}
	{!!Form::select('apoderado_id',$apoderados,null, ['placeholder' => 'Seleccion Apoderado...','class'=>'form-control']) !!}

</div>
<div class="form-group">
		{!!Form::submit('Registrar',['class'=>'btn btn-primary'])!!}
</div>
{!!Form::close()!!}



@endsection
	

	
