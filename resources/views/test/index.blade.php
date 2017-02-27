<!DOCTYPE html>
<html>
<head>
	<title> {{$docente -> nombre }}{{ $docente -> apellido}}</title>
	<link rel="stylesheet" type="text/css" href="{{asset('css/general.css')}}">
</head>
<body>
<br><br>
<h1>{{ $docente -> nombre }} {{ $docente -> apellido}}</h1>
<hr>
{{$docente -> rut }} | {{ $docente -> mail}}
<h2>{{$docente->telefono}}</h2>
<h3>
	@foreach($docente->asignaturas as $asig)
	{{ $asig -> nombre}}
	@endforeach
 <br>
 <h4>curso:{{$docente->curso->grado }}{{$docente->curso->letra}}</h4>


</h3>
</body>
</html>

 