<!doctype html>
 <html>

   <head>
      <meta charset="utf-8"/>   
      <title>Avance de Notas Anual</title>
      <link rel="stylesheet" type="text/css" href="css/reporte.css">
   </head>
   <body>
 
 	@foreach ($alumnos as $alumno) {
   	{!!$arraypdf[$alumno->id]->date!!}
   	

 @endforeach
 
 </body>
 </html> 
  
  