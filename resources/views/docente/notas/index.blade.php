@extends('admin.template.main')
@section('tittle', 'Ver Notas Curso'. ' '.$curso->nombre )
@section('content')
<a href="{{route('docentes.asignaturas.index') }}" class="btn btn-success"> Volver a Asignaturas</a>
<h1 class='text-right'>Ver Notas {{$asignatura->nombre}} Curso  {{$curso->nombre}} </h1>
<div class="form-group">
	<table class="table table-striped">
		<thead>
			<th>Nombre</th>
			<th>Apellido</th>
			<th>Rut</th>
			<?php
			$fechas=App\Nota::select('fecha')->orderBy('fecha','ASC')->where('asignatura_id',$asignatura->id)->distinct()->get();
			?>			 
			@foreach($fechas AS $fecha)

			<th style="text-align: center;"><font size="1">@if($fecha->fecha<$establecimiento->s1fin) S 1<br>{{explode('-',$fecha->fecha)[2].'-'.explode('-',$fecha->fecha)[1].'-'.explode('-',$fecha->fecha)[0]}}@endif @if($fecha->fecha>$establecimiento->s2inicio) S 2 <br>{{explode('-',$fecha->fecha)[2].'-'.explode('-',$fecha->fecha)[1].'-'.explode('-',$fecha->fecha)[0]}}@endif</font></th>
			@endforeach
		</thead>
		<tbody>
			@foreach($alumnos AS $alumno)
			<tr>
				<td>{{$alumno->nombre}}</td>
				<td>{{$alumno->apellido}}</td>
				<td>{{$alumno->rut}}</td>
				<?php			
				$notas=App\Nota::where('alumno_id',$alumno->id)->where('asignatura_id',$asignatura->id)->orderBy('fecha','ASC')->get();

				?>	
				@foreach($fechas as $fecha)

				@if(App\Nota::where('fecha',$fecha->fecha)->where('alumno_id',$alumno->id)->where('asignatura_id',$asignatura->id)->exists())
				<?php
				$nota=App\Nota::where('fecha',$fecha->fecha)->where('alumno_id',$alumno->id)->where('asignatura_id',$asignatura->id)->first();
				?>
				@if($nota->nota<40)
				<td class="alert alert-danger" role="alert" title="contenido:{{$nota->observacion}}">{{$nota->nota}}
					<a href="{{route('docente.notas.edit',$nota->id)}}" title="Editar Nota" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>
				</td>
				@else
				<td class="alert alert-primary" role="alert" title="contenido:{{$nota->observacion}}" >{{$nota->nota}}
					<a href="{{route('docente.notas.edit',$nota->id)}}" title="Editar Nota" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>
				</td>
				@endif
				@endif
				@if(!App\Nota::where('fecha',$fecha->fecha)->where('alumno_id',$alumno->id)->where('asignatura_id',$asignatura->id)->exists())
				<?php
				$var=$fecha->fecha.'+'.$alumno->id.'+'.$asignatura->id;
				?>
				<td class="alert alert-primary" style="text-align: center;" role="alert" ><a href="{{route('docente.notas.createone',$var)}}" title="Agregar Nota" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-plus"></span></a></td>				
				@endif				
			
				@endforeach
			
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
</div>
@endsection