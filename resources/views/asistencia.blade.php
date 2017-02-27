<!doctype html>
 <html>

   <head>
      <meta charset="utf-8"/>   
      <title>Título de la web</title>
      <link rel="stylesheet" type="text/css" href="css/reporte.css">
   </head>

   <body>
   <div>
   	<img class="logo-icon" src="{{asset('img/logo.png')}}">
   </div>
   <h1>{!!$establecimiento->nombre!!}</h1>
	<h4>{!!$establecimiento->direccion!!}</h4>
	<h4>{!!$establecimiento->telefono!!}</h4>
	<h2>Certificado Anual de Inasistencia</h2> 
	<div>
<p>Con fecha <strong>{!!$date!!}</strong>, el Establecimiento de Educacion <strong>{!!$establecimiento->nombre!!}</strong>, Confiere el presente CERTIFICADO DE INASISTENCIA a el estudiante:<strong> {!!$alumno->nombre!!} {!!$alumno->apellido!!} </strong>, del curso <strong>{!!$alumno->curso->nombre!!} </strong>, para ser usado en lo que estime comveniente.</p>
</div>
   <table class="asistencia">
   <thead>
   <tr>
   		<th>Fecha</th>
   		<th>Mes</th>
   		<th>Dia</th>
   		<th>Asistencia</th>	
   	</tr>
   	</thead>
	<tbody>
	@foreach($asistencias AS $asistencia)
	@if($asistencia->asistencia==0)
	<tr>
	<td role="alert">{{$asistencia->fecha}}</td>
	<!--Meses Del Año-->
	@if(explode('-',$asistencia->fecha)[1]==1)
		<td>Enero</td>
	@endif
	@if(explode('-',$asistencia->fecha)[1]==2)
		<td>Febrero</td>
	@endif
	@if(explode('-',$asistencia->fecha)[1]==3)
		<td>Marzo</td>
	@endif
	@if(explode('-',$asistencia->fecha)[1]==4)
		<td>Abril</td>
	@endif
	@if(explode('-',$asistencia->fecha)[1]==5)
		<td>Mayo</td>
	@endif
	@if(explode('-',$asistencia->fecha)[1]==6)
		<td>Junio</td>
	@endif
	@if(explode('-',$asistencia->fecha)[1]==7)
		<td>Julio</td>
	@endif
	@if(explode('-',$asistencia->fecha)[1]==8)
		<td>Agosto</td>
	@endif
	@if(explode('-',$asistencia->fecha)[1]==9)
		<td>Septiembre</td>
	@endif
	@if(explode('-',$asistencia->fecha)[1]==10)
		<td>Octubre</td>
	@endif
	@if(explode('-',$asistencia->fecha)[1]==11)
		<td>Noviembre</td>
	@endif
	@if(explode('-',$asistencia->fecha)[1]==12)
		<td>Diciembre</td>
	@endif
	<!--Dias de la Semana-->
	@if(jddayofweek(cal_to_jd(CAL_GREGORIAN,explode('-',$asistencia->fecha)[1],explode('-',$asistencia->fecha)[2],explode('-',$asistencia->fecha)[0]),0)==1)
		<td role="alert">Lunes</td>
	@endif
	@if(jddayofweek(cal_to_jd(CAL_GREGORIAN,explode('-',$asistencia->fecha)[1],explode('-',$asistencia->fecha)[2],explode('-',$asistencia->fecha)[0]),0)==2)
		<td role="alert">Martes</td>
	@endif
	@if(jddayofweek(cal_to_jd(CAL_GREGORIAN,explode('-',$asistencia->fecha)[1],explode('-',$asistencia->fecha)[2],explode('-',$asistencia->fecha)[0]),0)==3)
		<td role="alert">Miercoles</td>
	@endif
	@if(jddayofweek(cal_to_jd(CAL_GREGORIAN,explode('-',$asistencia->fecha)[1],explode('-',$asistencia->fecha)[2],explode('-',$asistencia->fecha)[0]),0)==4)
		<td role="alert">Jueves</td>
	@endif
	@if(jddayofweek(cal_to_jd(CAL_GREGORIAN,explode('-',$asistencia->fecha)[1],explode('-',$asistencia->fecha)[2],explode('-',$asistencia->fecha)[0]),0)==5)
		<td role="alert">Viernes</td>
	@endif
	@if(jddayofweek(cal_to_jd(CAL_GREGORIAN,explode('-',$asistencia->fecha)[1],explode('-',$asistencia->fecha)[2],explode('-',$asistencia->fecha)[0]),0)==6)
		<td role="alert">Sabado</td>
	@endif
	@if(jddayofweek(cal_to_jd(CAL_GREGORIAN,explode('-',$asistencia->fecha)[1],explode('-',$asistencia->fecha)[2],explode('-',$asistencia->fecha)[0]),0)==0)
		<td role="alert">Domingo</td>
	@endif
		
		<td role="alert">Ausente</td>
		
	</tr>
	@endif
	@endforeach
	</tbody>
</table>
<div >
	<table class="firma">
	<tr>
		<td>_____________</td>
		<td>_____________</td>
	</tr>
	<tr>
		<td>{!!$establecimiento->director!!}</td>
		<td>{!!$alumno->curso->docente->nombre!!} {!!$alumno->curso->docente->apellido!!}</td>
	</tr>
	<tr>
		<td>{!!$establecimiento->rutdirec!!}</td>
		<td>{!!$alumno->curso->docente->rut!!}</td>
	</tr>
	</table>
</div>
</body>

 </html>