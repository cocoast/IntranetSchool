@extends('admin.template.main')
@section('tittle','Crear Alumno')

@section('content')
<a href="{{route('docentes.reunion.index') }}" class="btn btn-info"> Volver a Comunicados</a>
<h3>Nuevo Comunicado</h3>
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
{!! Form::open(['route'=>['docentes.reunion.update',$reunion->id],'method'=>'PUT' ]) !!} 
<div class="form-group">
	{!!Form::label('contenido','Contenido')!!}
	{!!Form::textarea('contenido',$reunion->contenido,['class'=>'form-control','placeholder'=>'Escriba Aqui el contenido del comunidado','requiered'])!!}
</div>

<div class="form-group">
		{!!Form::submit('Editar',['class'=>'btn btn-primary'])!!}
</div>
{!!Form::close()!!}



@endsection
	

	
