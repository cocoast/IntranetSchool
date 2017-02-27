<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@yield ('tittle','Default')</title>
	<link rel="stylesheet" href="{{asset('plugins/bootstrap/css/bootstrap.css')}}">
	<link rel="stylesheet" href="{{asset('css/admin.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('css/dropzone.css')}}">
	

</head>
<body>
	@include('admin.template.partials.navapoderado')
	@include('flash::message')
	<section>
		@yield('content')
	</section>
	<footer class="admin-footer">
		<nav class="navbar navbar-default">
			<div class="collapse navbar-collapse">
				<p class="navbar-text"> Todos los derechos reservados &copy 2016</p>
				<p class="navbar-text navbar-center"> <b>IntraPoser </b></p>
			</div>
		</nav> 
	</footer>
	<script src="{{asset('plugins/jquery/jquery-3.1.1.js')}}"></script>
	<script src="{{asset('plugins/bootstrap/js/bootstrap.js')}}"></script>
	<script src="{{asset('js/fixed.js')}}"></script>
	
	
</body>
</html>
