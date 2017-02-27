@extends('admin.template.main')
@section('tittle', 'Editar Nota'. ' '. App\Alumno::find($nota->alumno_id)->nombre .' '. App\Alumno::find($nota->alumno_id)->apellido)
@section('content')
<a href="{{route('docente.notas.index') }}" class="btn btn-success"> Volver a Notas</a>
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
<h2>Editar nota Alumno: {{App\Alumno::find($nota->alumno_id)->nombre}} {{App\Alumno::find($nota->alumno_id)->apellido}} de fecha {{$nota->fecha}}</h2>
{!!Form::open(['route'=>['docente.notas.update',$nota],'method'=>'PUT' ])!!}
<div class="form-group">
	{!!Form::label('nota','Ingrese Nota')!!}
	{!! Form::text('nota', $nota->nota, ['class'=>'form-control','placeholder'=>'Ingrese Nota ...']) !!}
</div>
{!!Form::submit('Editar Nota',['class'=>'btn btn-primary'])!!}
{!!Form::close()!!}
@endsection