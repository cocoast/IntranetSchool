@extends('admin.template.main')
@section('tittle', 'Inicio Docente')
@section('content')
@if($docente->Curso()->get()->count()!=0)
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script type="text/javascript">
			google.charts.load("current", {packages:['corechart']});
			google.charts.setOnLoadCallback(drawChart);
			function drawChart() {
				var data = google.visualization.arrayToDataTable([
					["ASIGNATURA","PROMEDIO CURSO", { role: "style" }],
					@foreach($asignaturas AS $asignatura)
					['{{explode(' N',$asignatura->nombre)[0]}}',{{$promedios[$asignatura->id]}},'#0000FF'],
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
			});
		</script>
<h2>Informacion del Curso</h2>
<br>
<div class="row">
	<div class="col-md-7">
		<h4><u>Promedios del Curso Actual</u></h4>
		<div id="columnchart"  class="chart"></div>
	</div>	
	<div class="col-md-4">
	<h4><u>Proximas Evaluaciones</u></h4>
		<table class="table table-responsive table-hover"> 
			<thead>
				<th style="text-align: left; width: 30%;">ASIGNATURA</th>
				<th style="text-align: left; width: 30%;">FECHA</th>
				<th style="text-align: left width:70%;">CONTENIDO</th>

			</thead>
			<tbody>
				@foreach($proxcurso AS $proxima)
				<tr>
					<td>{{explode(' N'.$proxima->curso->nivel,$proxima->asignatura->nombre)[0]}}</td>
					<td>{{explode('-',$proxima->fecha)[2].'-'.explode('-',$proxima->fecha)[1].'-'.explode('-',$proxima->fecha)[0]}}</td>
					<td>{{$proxima->contenido}}</td>

				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
<hr>
<h2>Información Asignaturas</h2>
<h4>Proximas Evaluaciones</h4>
<br>
<div class="row">
	<div>
		<table class="table table-responsive table-hover"> 
			<thead>
				<th style="text-align: left; width: 20%;">FECHA</th>
				<th style="text-align: left; width: 20%;">ASIGNATURA</th>
				<th style="text-align: left width:60%;">CONTENIDO</th>
			</thead>
			<tbody>
				@foreach($proxProfe AS $proxima)
				<tr>
					<td>{{explode('-',$proxima->fecha)[2].'-'.explode('-',$proxima->fecha)[1].'-'.explode('-',$proxima->fecha)[0]}}</td>
					<td>{{App\Asignatura::find($proxima->asignatura_id)->nombre}}</td>
					<td>{{$proxima->contenido}}</td>

				</tr>
				@endforeach
			</tbody>
		</table></div>
	</div>
@endif		
@if($docente->Curso()->get()->count()==0)
<h2>Información Asignaturas</h2>
<h4>Proximas Evaluaciones</h4>
<br>
<div class="row">
		<div>
			<table class="table table-responsive table-hover"> 
				<thead>
					<th style="text-align: left; width: 10%;">FECHA</th>
					<th style="text-align: left; width: 15%;">ASIGNATURA</th>
					<th style="text-align: left; width: 15%;">CURSO</th>
					<th style="text-align: left width:60%;">CONTENIDO</th>
				</thead>
				<tbody>
					@foreach($proxProfe AS $proxima)
					<tr>
						<td>{{explode('-',$proxima->fecha)[2].'-'.explode('-',$proxima->fecha)[1].'-'.explode('-',$proxima->fecha)[0]}}</td>
						<td>{{App\Asignatura::find($proxima->asignatura_id)->nombre}}</td>
						<td>{{App\Curso::find($proxima->curso_id)->nombre}}</td>

						<td>{{$proxima->contenido}}</td>

					</tr>
					@endforeach
				</tbody>
			</table></div>
		</div>
		@endif		

@endsection
		