@extends('admin.template.main')
@section('tittle', 'Editar Proxima Evaluacion')
@section('content')
<a href="{{route('docente.proximas.index',$asignatura->id) }}" class="btn btn-success"> Volver a Futuras Evaluaciones</a>
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
{!!Form::open(['route'=>['docente.proximas.update',$proxima->id],'method'=>'PUT' ]) !!}
<div class="form-group">
{!!Form::label('fecha','Fecha') !!}
{!!Form::date('fecha',$proxima->fecha,['class'=>'form-control','step'=>'1','min'=>'2016-03-01'])!!}
</div>
<div class="form-group">
{!!Form::label('contenido','Contenidos') !!}
{!! Form::textarea('contenido', $proxima->contenido, ['size' => '30x5','class'=>'form-control','placeholder'=>'Escriba el Contenido ...']) !!}
</div>
{!!Form::hidden('curso',$proxima->curso_id,null)!!}
{!!Form::hidden('asignatura',$proxima->asignatura_id,null)!!}
{!!Form::submit('Editar Evaluación',['class'=>'btn btn-primary'])!!}
{!!Form::close()!!}
@endsection