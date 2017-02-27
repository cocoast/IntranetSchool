<!doctype html>
 <html>

   <head>
      <meta charset="utf-8"/>   
      <title>Título de la web</title>
   </head>

   <body>
   table class="table table-striped">
<TBODY>
	@foreach($asistencias AS $asistencia)
	@if($asistencia->asistencia==0)
	
		<td class="alert alert-danger" role="alert">{{$asistencia->fecha}}</td>
		<td class="alert alert-danger" role="alert">Ausente</td>
		
	</tr>
	@endif
		@if($asistencia->asistencia==1)
	<tr >
	
	
		<td class="alert alert-success" role="alert">{{$asistencia->fecha}}</td>
		<td class="alert alert-success" role="alert">Presente</td>
		
	</tr>
	@endif
	@endforeach
</TBODY>
	
</table>
   </body>

 </html>