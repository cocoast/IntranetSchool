@extends('admin.template.main')
@section('tittle', 'Inicio'.' '.$alumno->nombre .' '. $alumno->apellido)
@section('content')
<div class="row">
<h2>Notas</h2>
	<div class="col-md-4">
		<h4><u>Primer Semestre </u></h4>	
		<div id="columnchart1" class="chart"></div>
	</div>
	@if($promedios['final2']!=0)	
	<div class="col-md-4">
		<h4><u>Segundo Semestre</u></h4>
		<div id="columnchart2" class="chart"></div>
	</div>	
	@endif
	<div class="col-md-4">
		<h4><u>Anual Versus Curso</u></h4>
		<div id="columnchart"  class="chart"></div>
	</div>	
</div>
<br>
<div class="row">
	<h2>Información Relevante</h2>
	<div class="col-md-4">
		<h4>Asistencia</h4>
		<div id="piechart" class="chart" ></div>
	</div>
	<div class="col-sm-3" >
		<h4>Ultimas Inasistencias</h4>
		<table class="table table-striped table-bordered table-hover table-condensed ">
			<thead>
				<tr>
					
					<th>Fecha</th>
					<th>Estado</th>
				</tr>
			</thead>
			<TBODY>
				@foreach($aus AS $asistencia)
				<tr>					
					<td>{{explode('-',$asistencia->fecha)[2].'-'.explode('-',$asistencia->fecha)[1].'-'.explode('-',$asistencia->fecha)[0]}}</td>
					<td>Ausente</td>

				</tr>
				@endforeach
			</TBODY>
		</table>
	</div>
	<div class="col-sm-4">
		<h4>Ultimas notas subidas</h4>
		<table class="table table-striped table-bordered table-hover table-condensed ">
			<thead >
				<tr>
					<th>ASIGNATURA</th>
					<th style="text-align: center;">CONTENIDOS</th>
					<th style="text-align: center;">NOTA</th>
				</tr>
			</thead>
			<tbody>
				@foreach($notas AS $nota)
				<tr>
					<td>
						{{explode(' N'.$curso->nivel,$nota->asignatura->nombre)[0]}}
					</td>
					<td style="text-align: center;">
						{{$nota->observacion}}
					</td>
					<td style="text-align: center;">
						{{$nota->nota}}
					</td>
				</tr>
			</tbody>
			@endforeach
		</table>
	</div>		
	
</div>

@endsection
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawChart3);
	function drawChart3() {

		var data = google.visualization.arrayToDataTable([
			['Asistencia', 'Anual'],
			['Presente', {{$presente->count()}}],
			['Ausente', {{$ausente->count()}}]

			]);

		var options = { 
			legend: { position: "left" },
		};

		var chart = new google.visualization.PieChart(document.getElementById('piechart'));

		chart.draw(data, options);
	}

</script>
<script type="text/javascript">
	google.charts.load("current", {packages:['corechart']});
	google.charts.setOnLoadCallback(drawChart);
	function drawChart() {
		var data = google.visualization.arrayToDataTable([
			["ASIGNATURA", "PROMEDIO","PROMEDIO CURSO", { role: "style" }],
			@foreach($asignaturas AS $asignatura)
			['{{explode(' N',$asignatura->nombre)[0]}}',{{$promedios[$asignatura->id.'final']}},{{$promediocurso[$asignatura->id.'final']}},'#0000FF'],
			@endforeach
			]);

		var view = new google.visualization.DataView(data);
		view.setColumns([0, 1,
			{ calc: "stringify",
			sourceColumn: 1,
			type: "string",
			role: "annotation" },
			2]);

		var options = {
			bar: {groupWidth: "95%"},
			legend: { position: "none" },
		};
		var chart = new google.visualization.ColumnChart(document.getElementById("columnchart"));
		chart.draw(view, options);
	}
	$(window).resize(function(){
		drawChart();
		drawChart1();
		drawChart2();
		drawChart3();
	});
</script>
<script type="text/javascript">
	google.charts.load("current", {packages:['corechart']});
	google.charts.setOnLoadCallback(drawChart1);
	function drawChart1() {
		var data = google.visualization.arrayToDataTable([
			["ASIGNATURA", "PROMEDIO", { role: "style" }],
			@foreach($asignaturas AS $asignatura)
			['{{explode(' N',$asignatura->nombre)[0]}}',{{$promedios[$asignatura->id.'s1']}},'#FF8000'],
			@endforeach
			]);

		var view = new google.visualization.DataView(data);
		view.setColumns([0, 1,
			{ calc: "stringify",
			sourceColumn: 1,
			type: "string",
			role: "annotation" },
			2]);

		var options = {
			bar: {groupWidth: "95%"},
			legend: { position: "none" },
		};
		var chart = new google.visualization.ColumnChart(document.getElementById("columnchart1"));
		chart.draw(view, options);
	}
</script>
<script type="text/javascript">
	google.charts.load("current", {packages:['corechart']});
	google.charts.setOnLoadCallback(drawChart2);
	function drawChart2() {
		var data = google.visualization.arrayToDataTable([
			["ASIGNATURA", "PROMEDIO", { role: "style" }],
			@foreach($asignaturas AS $asignatura)
			['{{explode(' N',$asignatura->nombre)[0]}}',{{$promedios[$asignatura->id.'s2']}},'#FF0000'],
			@endforeach
			]);

		var view = new google.visualization.DataView(data);
		view.setColumns([0, 1,
			{ calc: "stringify",
			sourceColumn: 1,
			type: "string",
			role: "annotation" },
			2]);

		var options = {
			bar: {groupWidth: "95%"},
			legend: { position: "none" },
		};
		var chart = new google.visualization.ColumnChart(document.getElementById("columnchart2"));
		chart.draw(view, options);
	}
</script>
