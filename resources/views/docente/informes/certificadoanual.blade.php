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
		<h2><u>Certificado Anual de Notas</u></h2> 
		<p>Nombre Alumno(a): <strong>{!!$alumno->nombre!!} {!!$alumno->apellido!!} </strong></p>
		<p>Docente: <strong>{{$alumno->curso->docente->nombre}} {{$alumno->curso->docente->apellido }}</strong></p>
		<p>Curso: <strong>{!!$alumno->curso->nombre!!} </strong>.</p>
	</div>	
<table class="table table-striped table-bordered table-hover table-condensed" style="height: 10px;">
	<thead>
		<tr>
			<th style="text-align: center; width: 200px; padding: 15px 0px;">Asignatura</th>
			<th style="text-align: center; ">Promedio<br>Primer Semestre </th>
			<th style="text-align: center; ">Promedio <br>Segundo Semestre</th>
			<th style="text-align: center; ">Promedio<br>Final</th>
		</tr>
	</thead>
<tbody >
	@foreach($asignaturas AS $asignatura)
	<tr>
		<th style="text-align: left; padding: 5px" >{!!explode(' N',$asignatura->nombre)[0]!!}</th>
	
	<td style="text-align: center; ">
	@if($promedios1[$asignatura->id]!=0)
	{{$promedios1[$asignatura->id]}}
	@endif
	</td>
	<td style="text-align: center;">
	@if($promedios2[$asignatura->id]!=0)
	{{$promedios2[$asignatura->id]}}
	@endif
	</td>
	<td style="text-align: center;">
	@if($profinal[$asignatura->id]!=0)
	{{$profinal[$asignatura->id]}}
	@endif
	</td>
		<?php
	$contnotas+=1;
	?>
	@if($contnotas==$asignaturas->count())
	<tr>
		<th>Promedio Final </th>
		<th style="text-align: center;background-color: rgb(227, 255, 224);">{{round(array_sum($promedios1)/count($promedios1))}}</th>
		<th style="text-align: center;background-color: rgb(227, 255, 224);">{{round(array_sum($promedios2)/count($promedios2))}}</th>
		<th style="text-align: center;background-color: rgb(227, 255, 224);">{{round(array_sum($profinal)/count($profinal))}}</th>
	</tr>
	@endif
	@endforeach
</tbody>
</table>
<div class="row">
<table class="table">
	<tbody>
		<td><p style="line-height: .5;">Anotaciones Negativas: <strong>{{$negativas}}</strong></p></td>
		<td><p style="line-height: .5;">Anotaciones Positivas: <strong>{{$positivas}}</strong></p></td>
		<td><p style="line-height: .5;">Asistencia: <strong>{{$asistencia}}%</p></strong></td>
	</tbody>
</table>



</div>
<div class="row" style="border:solid 1px; height: 60px;">Observacion:</div>

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
