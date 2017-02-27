<!doctype html>
 <html>

   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
      <title>Avance de Notas Anual</title>
      <link rel="stylesheet" type="text/css" href="css/reporte.css">
      
   </head>

   <body>
   <div >
   <br>
   	<img class="logo-icon" src="{{asset('img/logo.png')}}">
   </div>
   <br>
   <h1><u>{!!$establecimiento->nombre!!}</u></h1>
	<h4>Direccion: {!!$establecimiento->direccion!!}</h4>
	<h4>Telefono: {!!$establecimiento->telefono!!}</h4>
	<br>
	<h1>Informe de Notas Parciales</h1> 
	<div>
	<br>
<div style="width: 95%;padding: 20px 20px;">
<p style="text-align: center;"><font size="4"><strong>{!!$alumno->nombre!!} {!!$alumno->apellido!!} </strong>, perteneciente al curso <strong>{!!$alumno->curso->nombre!!} </strong>.</font></p>
</div>
</div>
<div style="padding: 0px 5px;">
<table class="table" >
	<thead>
		<tr>
			<th style="text-align: center; padding: 0px 5px;">Asignatura</th>
			<th style="text-align: center; padding: 0px 5px;">1 Semestre</th>
			<th style="text-align: center; padding: 0px 5px;background-color: rgb(227, 255, 224); ">P1</th>
			<th style="text-align: center; padding: 0px 5px;">2 Semestre</th>
			<th style="text-align: center; padding: 0px 5px;">P2</th>
			<th style="text-align: center; padding: 0px 5px;">Prom <br> Final</th>
		</tr>
	</thead>
<tbody >
	@foreach($asignaturas AS $asignatura)
	<tr>
		<th style="text-align: left; padding: 0px" >{!!explode(' N',$asignatura->nombre)[0]!!}</th>
		<td >
		<table class="table table-inter" name="1semestre" >
		<tbody>
		@foreach($notas As $nota)
		@if($nota->asignatura_id==$asignatura->id && $nota->fecha>=$establecimiento->s1inicio && $nota->fecha<$establecimiento->s1fin)
		<td>{!!$nota->nota!!}</td>
		@endif
		@endforeach
		</tbody>
	</tr>
		</table>
	</td>
	<td style="text-align: center;background-color: rgb(227, 255, 224);">
	@if($promedios[$asignatura->id.'s1']!=0)
	{{$promedios[$asignatura->id.'s1']}}
	@endif
	</td>
	<td style="border:">
		<table class="table table-inter " name="2semestre">
		<tbody>
		@foreach($notas As $nota)
		@if($nota->asignatura_id==$asignatura->id && $nota->fecha>=$establecimiento->s2inicio && $nota->fecha<$establecimiento->s2fin)
		<td>{!!$nota->nota!!}</td>
		@endif
		@endforeach
		</tbody>
		</tr>
		</table>
	</td>	

	<td style="text-align: center;background-color: rgb(227, 255, 224);">
	@if($promedios[$asignatura->id.'s2']!=0)
	{{$promedios [$asignatura->id.'s2']}}
	@endif
	</td>
	<td style="text-align: center;background-color: rgb(227, 255, 224);">
	@if($promedios[$asignatura->id.'final']!=0 && $promedios[$asignatura->id.'s1']!=0&&$promedios[$asignatura->id.'s2']!=0  )
	{{$promedios[$asignatura->id.'final']}}
	@endif
	</td>
	@endforeach
</tbody>
</table>
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
		<?php
		$str=$alumno->curso->docente->rut;
		$large=strlen($str);
		$rut=substr($str,0,$large-1);
		$digito=substr($str,-1);
		?>
		<td>{!!$rut!!}-{{$digito}}</td>
	</tr>
	</table>
	<p class="fecha">Puerto Montt, {{$date}}</p>
</div>
</body>

 </html>