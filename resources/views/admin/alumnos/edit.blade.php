@extends('admin.template.main')
@section('tittle','Editar Alumno '. $alumno->nombre ." ". $alumno->apellido)

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
{!! Form::open(['route'=>['admin.alumnos.update',$alumno],'method'=>'PUT' ]) !!} 
<div class="form-group">
	{!!Form::label('nombre','Nombres')!!}
	{!!Form::text('nombre',$alumno->nombre,['class'=>'form-control ','placeholder'=>'Nombres Alumno','requiered'])!!}
</div>
<div class="form-group">
	{!!Form::label('apellido','Apellidos')!!}
	{!!Form::text('apellido',$alumno->apellido,['class'=>'form-control','placeholder'=>'Apellidos Alumno','requiered'])!!}
</div>
<div class="form-group">
	{!!Form::label('rut','RUT ')!!}
	{!!Form::text('rut',$alumno->rut,['class'=>'form-control','placeholder'=>'12345678-9','requiered'])!!}
</div>
<div class="form-group">
	{!!Form::label('mail','Email')!!}
	{!!Form::email('mail',$alumno->mail,['class'=>'form-control','placeholder'=>'alumno@example.com','requiered'])!!}
</div>
<div class="form-group">
	{!!Form::label('telefono','Telefono')!!}
	{!!Form::text('telefono',$alumno->telefono,['class'=>'form-control','placeholder'=>'652345678','requiered'])!!}
</div>
<div class="form-group">
	{!!Form::label('direccion','Direccion')!!}
	{!!Form::text('direccion',$alumno->direccion,['class'=>'form-control','placeholder'=>'Avenida Siempre Viva N° 742','requiered'])!!}
</div>
<div class="form-group">
	{!!Form::label('curso_id','Curso')!!}
	{!!Form::select('curso_id',$cursos,$alumno->curso_id, ['placeholder' => 'Seleccion Curso...','class'=>'form-control']) !!}

</div>


<div class="form-group">
	{!!Form::label('apoderado_id','Apoderado')!!}
	{!!Form::select('apoderado_id',$apoderados,$alumno->apoderado_id,['placeholder'=>'Seleccione un Apoderado...','class'=>'form-control']) !!}
	
</div>
<div class="form-group">
		{!!Form::submit('Editar',['class'=>'btn btn-primary'])!!}
</div>
{!!Form::close()!!}



@endsection