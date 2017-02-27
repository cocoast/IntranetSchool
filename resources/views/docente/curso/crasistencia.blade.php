<?php
setlocale( LC_TIME, 'spanish' );
$month = isset( $_GET[ 'month' ] ) ? $_GET[ 'month' ] : date( 'Y-n' );
$week = 1;
for ( $i=1;$i<=date( 't', strtotime( $month ) );$i++ ) {
	$day_week = date( 'N', strtotime( $month.'-'.$i )  );
	$calendar[ $week ][ $day_week ] = $i;
	if ( $day_week == 7 )
		$week++;
}
?>
@extends('admin.template.main')
@section('tittle', 'Lista Alumnos Curso'. ' '.$curso->nombre)
@section('content')
<a href="{{route('docentes.curso.index') }}" class="btn btn-success"> Volver a Curso</a>
<h1 class='text-right'>Asistencia {{$curso->nombre}}</h1>

<div class="row" style="text-align: center;">
	<h4><u>Fechas en las cuales ya se ingresó Asistencia</u></h4>
		<table class="table table-responsive" border="1" style="max-width:50%; text-align: center;">
			<thead>
				<tr>
					<td colspan="7"><?php echo strftime( '%B %Y', strtotime( $month ) ); ?></td>
				</tr>
				<tr>
					<td>Lunes</td>
					<td>Martes</td>			
					<td>Miércoles</td>			
					<td>Jueves</td>			
					<td>Viernes</td>			
					<td>Sábado</td>			
					<td>Domingo</td>			
				</tr>
			</thead>
			<tbody>
				@foreach ( $calendar as $days )
				<tr>
					@for ( $i=1;$i<=7;$i++ ) 
					<?php
					$fecha=$month.'-'.(isset($days[$i]) ? $days[$i] : '');
					$asistencias=App\Asistencia::where('fecha',$fecha);
					?>
					@if(App\Asistencia::select('fecha')->where('fecha',$fecha)->distinct()->exists())
					<td bgcolor= "#00FF00">
						{{{isset( $days[ $i ] ) ? $days[ $i ] : ''}}} 

					</td>
					@else
					<td>
						{{{isset( $days[ $i ] ) ? $days[ $i ] : ''}}} 

					</td>
					@endif
					@endfor
				</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<td colspan="7">
						<form method="get">
							<strong><u>Seleccione Mes:</u></strong><input style="max-width: 50%;" type="month" name="month" >
							<input type="submit">
						</form>
					</td>
				</tr>
			</tfoot>
		</table>
</div>
<hr>
<div class="row">
	{!!Form::open(['route'=>'docente.asistencia.store','method'=>'POST' ])!!}
	<div class='form-group'>
		{!!Form::label('fecha','Seleccione Fecha que desea Ingresar:')!!}
		{!!Form::date('date',\Carbon\Carbon::now(),['class'=>'form-control','step'=>'1','min'=>'2015-03-01'])!!}
	</div>
	<div class="form-group">
		<table class="table table-striped">
			<thead>
				<th>Nombre</th>
				<th>Apellido</th>
				<th>rut</th>
				<th>Asistencia</th>
			</thead>
			<tbody>
				@foreach($alumnos AS $alumno)
				<tr>
					<td>{{$alumno->nombre}}</td>
					<td>{{$alumno->apellido}}</td>
					<td>{{$alumno->rut}}</td>
					<td>   
						{!!Form::checkbox('check'.'-'.$alumno->id,null,['checked'])!!}
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	{!!Form::submit('Registrar Asistencia',['class'=>'btn btn-primary'])!!}
	{!!Form::close()!!}
</div>

@endsection