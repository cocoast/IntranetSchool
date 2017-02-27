<!doctype html>
 <html>

   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
      <title>Avance de Notas Anual</title>
      <link rel="stylesheet" type="text/css" href="css/bootstrap-font.css">
      <link rel="stylesheet" type="text/css" href="css/reporte.css">
   </head>
   <body>
<img class="imglogo" src="{{asset('img/logo.png')}}">  
<div class="text-center ">
<h1><u>{!!$establecimiento->nombre!!}</u></h1>
<h4>Direccion: {!!$establecimiento->direccion!!}</h4>
<h4>Telefono: {!!$establecimiento->telefono!!}</h4>
</div>
	<div class="parrafo-titulo">
		<h2><u>Informe de Notas Segundo Semestre</u></h2> 
		<p>Nombre Alumno(a): <strong>{!!$alumno->nombre!!} {!!$alumno->apellido!!} </strong></p>
		<p>Docente: <strong>{{$alumno->curso->docente->nombre}} {{$alumno->curso->docente->apellido }}</strong></p>
		<p>Curso: <strong>{!!$alumno->curso->nombre!!} </strong>.</p>
	</div>	
<table class="table table-striped table-bordered table-hover table-condensed" style="height: 10px;">
	<thead>
		<tr>
			<th style="text-align: left; width: 200px;">Asignatura</th>
				<th style="text-align: left; width: 200px; padding: 5px 10px;">
		@for($i=0;$i<$masnotas;$i++)N{{$i+1}}&nbsp;@endfor		
			</th>
			<th style="text-align: center;background-color: rgb(227, 255, 224); ">Promedio</th>
		</tr>
	</thead>
<tbody >
	@foreach($asignaturas AS $asignatura)
	<tr>
		<th style="text-align: left; padding: 5px 10px" >{!!explode(' N',$asignatura->nombre)[0]!!}</th>
		<td style="max-height: 10px;">
		<table class="table "  name="semestre" >
		<tbody>
		@foreach($notas As $nota)
		@if($nota->asignatura_id==$asignatura->id)
		{!!$nota->nota!!}&nbsp;
				@endif
		@endforeach
		</tbody>
	</tr>
		</table>
	</td>
	<td style="text-align: center;background-color: rgb(227, 255, 224); width: 50px;">
	@if($promedios2[$asignatura->id]!=0)
	{{$promedios2[$asignatura->id]}}
	@endif
	</td>
		<?php
	$contnotas+=1;
	?>
	@if($contnotas==$asignaturas->count())
	<tr>
		<th>Promedio Final </th>
		<td>&nbsp; </td>
		<th style="text-align: center;background-color: rgb(227, 255, 224);">{{round(array_sum($promedios2)/count($promedios2))}} </th>
	</tr>
	@endif
	@endforeach
	</td>
</tbody>
</table>
<div class="row">
<div><h4>Anotaciones Negativas o Atrasos: <strong>{{$negativas}}</strong></h4></div>
<div><h4>Anotaciones Positivas o Felicitaciones: <strong>{{$positivas}}</strong></h4></div>
<div><h4>Asistencia Acumulada a la fecha: <strong>{{$asistencia}}%</h4></strong></div>
</div>
<div >
	<table class="firma">
	<tr>
		<td>______________________</td>
	</tr>
	<tr>
		<td>{!!$alumno->curso->docente->nombre!!} {!!$alumno->curso->docente->apellido!!}</td>
		</tr>
		<tr>
		<td>{{$rutdocente}}</td>
	</tr>
	</table>
	<p class="fecha">Puerto Montt, {{$date}}</p>
</div>
</body>

 </html>