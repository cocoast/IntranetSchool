@extends('admin.template.main')
@section('tittle', 'Ver Anotaciones Alumno'. ' '. $alumno->nombre .' '.$alumno->apellido)
@section('content')
<a href="{{route('docentes.curso.index') }}" class="btn btn-success"> Volver a Curso</a>
<a href="{{route('docente.anotaciones.create',$alumno->id) }}" class="btn btn-info"> Registrar Nueva Anotacion</a>
<hr>
<h1 class="text-right">Anotaciones de {{$alumno->nombre}} {{$alumno->apellido}}</h1>
<hr>
@foreach($anotaciones as $anotacion)
<div class="jumbotron">
<div class="pull-right">
<a href="{{route('docente.anotacionescurso.edit',$anotacion->id)}}" title="Editar" class="btn btn-warning"><span class="glyphicon glyphicon-wrench"></span></a>

<a href="{{route('docente.anotaciones.destroyCurso',$anotacion->id)}}" title="Eliminar" onclick ="return confirm('Eliminar Anotacion?')" class="btn btn-danger"> <span class="glyphicon glyphicon-remove-circle" ></span> </a>
</div>
<div class="container">
<h2 class="text-justify">{{$anotacion->fecha}}</h2>
<h3 class="text-justify">{{$anotacion->asignatura->nombre}}</h3>
@if($anotacion->tipo==0)
<p class="text-justify" title="Anotacion Negativa"><font color="#FF0000">{{$anotacion->anotacion}}</font></p>
@endif
@if($anotacion->tipo==1)
<p class="text-justify" title="Anotacion Positiva"><font color="#0000FF">{{$anotacion->anotacion}}</font></p>
@endif

</div>
 </div>
 @endforeach
@endsection