@extends('admin.template.main')
@section('tittle', 'Lista Asistencia'.' '.$alumno->nombre .' '. $alumno->apellido)
<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Asistencia', 'Anual'],
          ['Asistencias', {{$asistio}}],
          ['Inasistencias', {{$inasistencias}}]
         
        ]);

        var options = { 
          title: 'Reporte Anual de Asistencia'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
  </head>
@section('content')
<a href="{{route('docentes.curso.index') }}" class="btn btn-success"> Volver a Curso</a>
<h1 class="text-right">Asistencia {{$alumno->nombre}}  {{$alumno->apellido}}</h1>
<hr>
{!!Form::open(['route'=>array('docente.asistencia.index',$alumno->id),'method'=>'GET','class'=>'navbar-form pull-right']) !!}
<div class="input-group">
<span id="search" class="input-group-addon buscar"><span class="glyphicon glyphicon-search"  aria-hidden="true"></span></span>
{!!Form::select('name',array('-01-'=>'Enero','-02'=>'Febrero','-03-'=>'Marzo','-04-'=>'Abril','-05-'=>'Mayo','-06-'=>'Junio','-07-'=>'Julio','-08-'=>'Agosto','-09-'=>'Septiembre','-10-'=>'Octubre','-11-'=>'Noviembre','-12-'=>'Diciembre'),null,['class'=>'form-control','placeholder'=>'Seleccione un Mes...']) !!}
{!!Form::submit('Buscar',['class'=>'btn btn-primary'])!!}

</div>
{!!Form::close() !!}
<!--GRaficos -->
 <div id="piechart" style="width: 850px; height: 350px;"></div>
 <!--GRaficos -->
<hr>
<table class="table table-striped">
<TBODY>
	@foreach($asistencias AS $asistencia)
	@if($asistencia->asistencia==0)
	<tr>
	<!--Meses Del Año-->
	@if(explode('-',$asistencia->fecha)[1]==3)
		<td class="alert alert-danger">Marzo</td>
	@endif
	@if(explode('-',$asistencia->fecha)[1]==4)
		<td class="alert alert-danger">Abril</td>
	@endif
	@if(explode('-',$asistencia->fecha)[1]==5)
		<td class="alert alert-danger">Mayo</td>
	@endif
	@if(explode('-',$asistencia->fecha)[1]==6)
		<td class="alert alert-danger">Junio</td>
	@endif
	@if(explode('-',$asistencia->fecha)[1]==7)
		<td class="alert alert-danger">Julio</td>
	@endif
	@if(explode('-',$asistencia->fecha)[1]==8)
		<td class="alert alert-danger">Agosto</td>
	@endif
	@if(explode('-',$asistencia->fecha)[1]==9)
		<td class="alert alert-danger">Septiembre</td>
	@endif
	@if(explode('-',$asistencia->fecha)[1]==10)
		<td class="alert alert-danger">Octubre</td>
	@endif
	@if(explode('-',$asistencia->fecha)[1]==11)
		<td class="alert alert-danger">Noviembre</td>
	@endif
	@if(explode('-',$asistencia->fecha)[1]==12)
		<td class="alert alert-danger">Diciembre</td>
	@endif
	<!--Dias de la Semana-->
	@if(jddayofweek(cal_to_jd(CAL_GREGORIAN,explode('-',$asistencia->fecha)[1],explode('-',$asistencia->fecha)[2],explode('-',$asistencia->fecha)[0]),0)==1)
		<td class="alert alert-danger" role="alert">Lunes</td>
	@endif
	@if(jddayofweek(cal_to_jd(CAL_GREGORIAN,explode('-',$asistencia->fecha)[1],explode('-',$asistencia->fecha)[2],explode('-',$asistencia->fecha)[0]),0)==2)
		<td class="alert alert-danger" role="alert">Martes</td>
	@endif
	@if(jddayofweek(cal_to_jd(CAL_GREGORIAN,explode('-',$asistencia->fecha)[1],explode('-',$asistencia->fecha)[2],explode('-',$asistencia->fecha)[0]),0)==3)
		<td class="alert alert-danger" role="alert">Miercoles</td>
	@endif
	@if(jddayofweek(cal_to_jd(CAL_GREGORIAN,explode('-',$asistencia->fecha)[1],explode('-',$asistencia->fecha)[2],explode('-',$asistencia->fecha)[0]),0)==4)
		<td class="alert alert-danger" role="alert">Jueves</td>
	@endif
	@if(jddayofweek(cal_to_jd(CAL_GREGORIAN,explode('-',$asistencia->fecha)[1],explode('-',$asistencia->fecha)[2],explode('-',$asistencia->fecha)[0]),0)==5)
		<td class="alert alert-danger" role="alert">Viernes</td>
	@endif
	@if(jddayofweek(cal_to_jd(CAL_GREGORIAN,explode('-',$asistencia->fecha)[1],explode('-',$asistencia->fecha)[2],explode('-',$asistencia->fecha)[0]),0)==6)
		<td class="alert alert-danger" role="alert">Sabado</td>
	@endif
	@if(jddayofweek(cal_to_jd(CAL_GREGORIAN,explode('-',$asistencia->fecha)[1],explode('-',$asistencia->fecha)[2],explode('-',$asistencia->fecha)[0]),0)==0)
		<td class="alert alert-danger" role="alert">Domingo</td>
	@endif
		<td class="alert alert-danger" role="alert">{{explode('-',$asistencia->fecha)[2].'-'.explode('-',$asistencia->fecha)[1].'-'.explode('-',$asistencia->fecha)[0]}}</td>
		<td class="alert alert-danger" role="alert">Ausente</td>
		
	</tr>
	@endif
		
	@endforeach
</TBODY>
	
</table>



@endsection