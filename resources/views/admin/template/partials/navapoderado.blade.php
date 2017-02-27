 @if($alumnos->count()>=2)
 <nav class="navbar navbar-default" style="max-width: 90%;" role="navigation">
  <!-- El logotipo y el icono que despliega el menú se agrupan
  para mostrarlos mejor en los dispositivos móviles -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse"
    data-target=".navbar-ex1-collapse">
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
  </button>
  <?php
  if(DB::table('establecimiento')->where('id',1)->exists()){
    $esta=App\Establecimiento::first();
    if($esta->logo!=null)
      $logo=$esta->logo;
    else
      $logo="/img/icon.png";
  }
  else
    $logo="/img/icon.png";
  ?>
  <img class="logo-icon" src="{{asset($logo)}}">
</div>
<div class="collapse navbar-collapse navbar-ex1-collapse">
  <ul class="nav navbar-nav navbar-left">
    <li class="dropdown">
      <a href="{{route('apoderado.alumno.search',$alumno->id)}}">{{$alumno->nombre}} {{$alumno->apellido}}
      </a>
      
    </li>
  </ul>
  <ul class="nav navbar-nav">
    <li ><a href="{{route('apoderado.alumno.asignaturas',$alumno->id)}}">Asignaturas</a></li>
    <li ><a href="{{route('apoderado.alumno.proximas',$alumno->id)}}">Proximas Evaluaciones</a></li> 
    <li><a href="http://certificados.mineduc.cl/mvc/home/index">Certficados Años Anteriores</a></li> 

  </ul>
  <ul class="nav navbar-nav ">
    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">Cambiar de Alumno<b class="caret"></b>
      </a>
      <ul class="dropdown-menu">
        @foreach($alumnos AS $alu)
        @if($alu->id!=$alumno->id)
        <li><a href="{{route('apoderado.alumno.search',$alu->id)}}">{{$alu->nombre}} {{$alu->apellido}}</a></li>
        @endif
        @endforeach
      </ul>
    </li>
  </ul>
  <ul class="nav navbar-nav navbar-right">
    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{Auth::user()->name}}<b class="caret"></b>
      </a>
      <ul class="dropdown-menu">
        <li><a href="{{route('admin.auth.logout')}}">Salir</a></li>
      </ul>
    </li>
  </ul>
</div>
</nav>
@else
<nav class="navbar navbar-default" role="navigation">
  <!-- El logotipo y el icono que despliega el menú se agrupan
  para mostrarlos mejor en los dispositivos móviles -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse"
    data-target=".navbar-ex1-collapse">
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
  </button>
  <?php
  if(DB::table('establecimiento')->where('id',1)->exists()){
    $esta=App\Establecimiento::first();
    if($esta->logo!=null)
      $logo=$esta->logo;
    else
      $logo="/img/icon.png";
  }
  else
    $logo="/img/icon.png";
  ?>
  <img class="logo-icon" src="{{asset($logo)}}">
</div>
<div class="collapse navbar-collapse navbar-ex1-collapse">
  <ul class="nav navbar-nav navbar-left">
    <li class="dropdown">
      <a href="{{route('apoderado.alumno.search',$alumno->id)}}">{{$alumno->nombre}} {{$alumno->apellido}}</a>
    </li>
  </ul>
  <ul class="nav navbar-nav">
    <li ><a href="{{route('apoderado.alumno.asignaturas',$alumno->id)}}">Asignaturas</a></li>
    <li ><a href="{{route('apoderado.alumno.proximas',$alumno->id)}}">Proximas Evaluaciones</a></li>
    <li><a href="http://certificados.mineduc.cl/mvc/home/index">Certficados Años Anteriores</a></li> 

  </ul>

  <ul class="nav navbar-nav navbar-right">
    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{Auth::user()->name}}<b class="caret"></b>
      </a>
      <ul class="dropdown-menu">
        <li><a href="{{route('admin.auth.logout')}}">Salir</a></li>
      </ul>
    </li>
  </ul>
</div>
</nav>
@endif