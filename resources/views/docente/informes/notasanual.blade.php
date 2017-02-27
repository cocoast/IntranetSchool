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
	<div class="text-center titulo">
		<h2 style="line-height: .5;"><u>{!!$establecimiento->nombre!!}</u></h2>
		<h6 style="line-height: .5;">Direccion: {!!$establecimiento->direccion!!}</h6>
		<h6 style="line-height: .5;">Telefono: {!!$establecimiento->telefono!!}</h6>
		<h3 style="line-height: .5;"><u>Informe de Notas Anual </u></h3> 
	</div>
	<div class="parrafo-titulo">

		<p style="line-height: .5;
		">Nombre Alumno(a): <strong>{!!$alumno->nombre!!} {!!$alumno->apellido!!} </strong></p>
		<p style="line-height: .5;
		">Docente: <strong>{{$alumno->curso->docente->nombre}} {{$alumno->curso->docente->apellido }}</strong></p>
		<p style="line-height: .5;
		">Curso: <strong>{!!$alumno->curso->nombre!!} </strong>.</p>
	</div>	
	<table class="table table-striped table-bordered table-hover table-condensed ">
		<thead>
			<tr>
				<th style="text-align: left; width: 200px;">Asignatura</th>
				<th style="text-align: left; width: 200px; padding: 5px 10px;">
					@for($i=0;$i<$masnotas1;$i++)N{{$i+1}}&nbsp;@endfor		
				</th>
				<th style="text-align: center;background-color: rgb(227, 255, 224); ">Prom</th>
				<th style="text-align: left; width: 200px; padding: 5px 10px;">
					@for($i=0;$i<$masnotas2;$i++)N{{$i+1}}&nbsp;@endfor		
				</th>
				<th style="text-align: center;background-color: rgb(227, 255, 224); ">Prom</th>
				<th style="text-align: center;background-color: rgb(227, 255, 224); width: 50px" >Final</th>
				<th style="width:50px; text-align:  center;background-color: rgb(227, 255, 224); ">PC</th>
			</tr>
		</thead>
		<tbody >
			@foreach($asignaturas AS $asignatura)
			<tr>
				<th style="text-align: left; padding: 5px" >{!!explode(' N',$asignatura->nombre)[0]!!}</th>
				<td style="max-height: 10px;">
					<table class="table "  name="1semestre" >
						<tbody>
							@foreach($notas1 As $nota1)
							@if($nota1->asignatura_id==$asignatura->id)
							{!!$nota1->nota!!}&nbsp;
							@endif
							@endforeach
						</tbody>

					</tr>
				</table>
			</td>
			<td style="text-align: center;background-color: rgb(227, 255, 224); width: 30px;">
				@if($promedios1[$asignatura->id]!=0)
				{{$promedios1[$asignatura->id]}}
				@endif
			</td>
			<!-- Segundo Semestre-->	

			<td style="max-height: 10px;">
				<table class="table "  name="2semestre" >
					<tbody>
						@foreach($notas2 As $nota2)
						@if($nota2->asignatura_id==$asignatura->id)
						{!!$nota2->nota!!}&nbsp;
						@endif
						@endforeach
					</tbody>
				</tr>
			</table>
		</td>
		<td style="text-align: center;background-color: rgb(227, 255, 224); width: 30px;">
			@if($promedios2[$asignatura->id]!=0)
			{{$promedios2[$asignatura->id]}}
			@else 
			<td style="text-align: center;background-color: rgb(227, 255, 224); width: 30px;"></td>	
			@endif
		</td>
		
		<th style="text-align: center;background-color: rgb(227, 255, 224);">{{$profinal[$asignatura->id]}}</th>
		<td style="text-align: center;background-color: rgb(227, 255, 224); ">
		{{$procurso[$asignatura->id]}}
		</td>
		<?php
		$contnotas+=1;
		?>
		@if($contnotas==$asignaturas->count())
		<tr>
			<th>Promedio Final </th>
			<td>&nbsp; </td>
			<th style="text-align: center;background-color: rgb(227, 255, 224);">{{round(array_sum($promedios1)/count($promedios1))}}</th>
			<td>&nbsp;</td>
			<th style="text-align: center;background-color: rgb(227, 255, 224);">{{round(array_sum($promedios2)/count($promedios2))}}</th>
			<th style="text-align: center;background-color: rgb(227, 255, 224);">{{round(array_sum($profinal)/count($profinal))}}</th>
			<th style="text-align: center;background-color: rgb(227, 255, 224);">{{$procurso['final']}}</th>
		</tr>
		@endif
		@endforeach
		</tbody>
</table>
<div>
	<div class="text-left" style="float: left;">
		<p style="line-height: .5;">Anotaciones Negativas o Atrasos: <strong>{{$negativas1}}</strong></p>
		<p style="line-height: .5;">Anotaciones Positivas o Felicitaciones: <strong>{{$positivas1}}</strong></p>
		<p style="line-height: .5;">Asistencia Acumulada a la fecha: <strong>{{$asistencia1}}%</p></strong>
	</div>
	<div class="text-center" style="float: center">
		
		<br>
		<br>
		<p>________________</p>
		<p style="line-height: .5;">{!!$alumno->curso->docente->nombre!!} {!!$alumno->curso->docente->apellido!!}</p>
		<p style="line-height: .5;">{{$rutdocente}}</p>
	</div>
	<div class="text-right" style="float: right;">
		<p style="line-height: .5;">Anotaciones Negativas o Atrasos: <strong>{{$negativas2}}</strong></p>
		<p style="line-height: .5;">Anotaciones Positivas o Felicitaciones: <strong>{{$positivas2}}</strong></p>
		<p style="line-height: .5;">Asistencia Acumulada a la fecha: <strong>{{$asistencia2}}%</p></strong>
	</div>
	<p class="fecha">Puerto Montt, {{$date}}</p>

</body>

</html>