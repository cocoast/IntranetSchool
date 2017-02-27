@extends('admin.template.main')
@section('tittle', 'Inicio Admin')
@section('content')
 @if(Auth::check()&&Auth::user()->type=='alumno')
 <?php
 echo redirect()->route('alumno.alumno.index');
 ?>
 @endif
  @if(Auth::check()&&Auth::user()->type=='docente')
<h3>Bienvenido Profesor: <u>{{Auth::user()->name}}</u></h3>
 <?php
 echo redirect()->route('docentes.index');
 ?>

 @endif

 @if(Auth::check()&&Auth::user()->type=='apoderado')
<h3>Bienvenido: <u>{{Auth::user()->name}}</u></h3>
 <?php
 $apoderado=App\Apoderado::where('mail',Auth::user()->email)->first();
 if(App\Alumno::where('apoderado_id',$apoderado->id)->get()->count()<2)
 echo redirect()->route('apoderado.alumno.search',App\Alumno::where('apoderado_id',$apoderado->id)->first()->id);
 ?>

 @endif

@if(Auth::check()&&Auth::user()->type=='admin')
@if(App\Establecimiento::all()->count()==0)
<?php echo redirect()->route('admin.configure.index');?>
@endif	
<div class="row">
	<div class="col-md-4">
		<h2>Cantidad de Alumnos:</h2>
		</div>
	<div class="col-md-4">	
		<h2>{{App\Alumno::all()->count()}}</h2>
	</div>	
</div>
<div class="row">
	<div class="col-md-4">
		<h2>Cantidad de Cursos:</h2>
		</div>
	<div class="col-md-4">	
		<h2>{{App\Curso::all()->count()}}</h2>
	</div>	
</div>
<div class="row">
	<div class="col-md-4">
		<h2>Cantidad de Docentes:</h2>
		</div>
	<div class="col-md-4">	
		<h2>{{App\Docente::all()->count()}}</h2>
	</div>	
</div>
<div class="row">
	<div class="col-md-4">
		<h2>Cantidad de Asignaturas:</h2>
		</div>
	<div class="col-md-4">	
		<h2>{{App\Asignatura::all()->count()}}</h2>
	</div>	
</div>
@endif

@endsection