@extends('admin.template.main')
@section('tittle', 'Configuracion Establecimiento')
@section('content')
<div class="row">
	<div class="col-sm-6"><div id="log_div"></div></div>
	<div class="col-sm-6"><table class="table">
		<thead>
			<tr>
				<th>Cursos</th>
				<th>Anotaciones</th>
				<th>Asistencia</th>
				<th>Año</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				@foreach($cursos as $curso)
				@foreach($anotaciones as $anotacion)
				@foreach($asistencias as $asistencia)
				<td>{{$curso->nombre_curso}}</td>
				<td> <p>Positivas: {{$anotacion->positivas}}</p> <p>Negativas: {{$anotacion->negativas}}</p> </td>
				<td> <p>Presente: {{$asistencia->asistencia}}</p> <p>Ausente:{{$asistencia->inasistencia}}</p> </td>
				<td>{{$asistencia->ano}}</td>
				@endforeach
				@endforeach
				@endforeach

			</tr>
		</tbody>
	</table> </div>
</div>
@endsection
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
	google.charts.load('current', {'packages':['corechart', 'line']});
	google.charts.setOnLoadCallback(drawChart);

	function drawChart() {

		var data = new google.visualization.DataTable();
		data.addColumn('number', 'Año');
		data.addColumn('number', 'Promedios');

		data.addRows([
			@foreach($promedios AS $key=> $value)
			[{{$key}},{{$value}}],
			@endforeach
			]);
		var logOptions = {
			title: 'Rendimiento Por Promedios General Del Alumno',
			legend: 'none',
			width: 550,
			height: 500,
			hAxis: {
				title: 'Año',
				scaleType: 'log',
				ticks: [
				@foreach($promedios AS $key => $value)
				[{{$key}},
				@endforeach]
				]
			},
			vAxis: {
				title: 'Promedios',
				scaleType: 'log',
				ticks: [10,20,30,40,50,60,70]
			}
		};

		var logChart = new google.visualization.LineChart(document.getElementById('log_div'));
		logChart.draw(data, logOptions);
	}
</script>