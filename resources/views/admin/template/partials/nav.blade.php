 @if(Auth::check()&&Auth::user()->type=='admin')
 <!-- Si el Usuario es Administrador-->
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

  <!-- Agrupar los enlaces de navegación, los formularios y cualquier
  otro elemento que se pueda ocultar al minimizar la barra -->
  <div class="collapse navbar-collapse navbar-ex1-collapse">


    <ul class="nav navbar-nav">
     <li ><a href="{{route('admin.index')}}">Inicio</a></li>
      <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">Establecimiento<b class="caret"></b>
      </a>
      <ul class="dropdown-menu">
        <li ><a href="{{route('admin.configure.index')}}">Establecimiento</a></li>
        <li ><a href="{{route('admin.asignaturas.index')}}">Asignaturas</a></li>
        <li ><a href="{{route('admin.cursos.index')}}">Cursos</a></li>
        <li ><a href="{{route('admin.antiguo.index')}}">Alumnos Antiguos</a></li>
        <li ><a onclick ="return confirm('¿Esta seguro que desea cerrar el año Escolar?')" href="{{route('admin.close')}}">Cierre Año Escolar</a></li>
      </ul>
    </li>

    <li ><a href="{{route('admin.users.index')}}">Usuarios</a></li>
    <li ><a href="{{route('admin.alumnos.index')}}">Alumnos</a></li>
    <li ><a href="{{route('admin.apoderados.index')}}">Apoderados</a></li>
    <li ><a href="{{route('admin.docentes.index')}}">Docentes</a></li>


  </ul>
  <ul class="nav navbar-nav navbar-right">
    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{Auth::user()->name}}<b class="caret"></b>
      </a>
      <ul class="dropdown-menu">
      @if(App\Establecimiento::count()==0||App\Establecimiento::find(1)->s1inicio==null)
      <li><a onclick ="return confirm('Debe Configurar Primero Establecimiento antes de salir, ¿desea ir ahora?')" href="{{route('admin.configure.index')}}">Salir</a></li>
      @else
        <li><a onclick ="return confirm('Esta seguro que desea salir')" href="{{route('admin.auth.logout')}}">Salir</a></li>
        @endif
      </ul>
    </li>
  </ul>
  @endif


  <!--Si el usuario es Docente-->
  @if(Auth::check()&&Auth::user()->type=='docente')
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

  <!-- Agrupar los enlaces de navegación, los formularios y cualquier
  otro elemento que se pueda ocultar al minimizar la barra -->
  <div class="collapse navbar-collapse navbar-ex1-collapse">

    <ul class="nav navbar-nav">
      @if(DB::table('curso')->where('docente_id','=',DB::table('docente')->where('mail',Auth::user()->email)->first()->id)->exists())
      <li ><a href="{{route('docentes.index')}}">Información</a></li>
      <li ><a href="{{route('docentes.curso.index')}}">Curso</a></li>
      <li ><a href="{{route('docentes.asignaturas.index')}}">Asignaturas</a></li>
      <li ><a href="{{route('docentes.reunion.index')}}">Comunicados</a></li>     
      @else
      <li ><a href="{{route('docentes.index')}}">Información</a></li>
      <li ><a href="{{route('docentes.asignaturas.index')}}">Asignaturas</a></li>     
      @endif
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
    @endif

    <!--Alumno-->
    @if(Auth::check()&&Auth::user()->type=='alumno') 
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
  <img class="logo-icon" src="{{asset('img/logo.png')}}">
</div>

  <!-- Agrupar los enlaces de navegación, los formularios y cualquier
  otro elemento que se pueda ocultar al minimizar la barra -->
  <div  class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav" >
      <li ><a href="{{route('alumno.alumno.index')}}">Alumno</a></li>
      <li><a href="{{route('alumno.asignaturas.index')}}">Asignaturas</a></li>
      <li ><a href="{{route('alumno.curso.proximas')}}">Proximas Evaluaciones</a></li>   
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
    @endif 

    <!--Si el usuario es Apoderado-->
    @if(Auth::check()&&Auth::user()->type=='apoderado')
    <nav class="navbar navbar-default"  style="max-width: 90%;" role="navigation">
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

  $apoderado=App\Apoderado::where('mail',Auth::user()->email)->first();
  $alumnos=App\Alumno::where('apoderado_id',$apoderado->id)->get();
  ?>
  <img class="logo-icon" src="{{asset($logo)}}">
</div>

  <!-- Agrupar los enlaces de navegación, los formularios y cualquier
  otro elemento que se pueda ocultar al minimizar la barra -->

  <div class="collapse navbar-collapse navbar-ex1-collapse">
    @if($alumnos->count()<2)
    <?php
    $alumno=App\Alumno::where('apoderado_id',$apoderado->id)->first();
    ?>
    <ul class="nav navbar-nav navbar-left">
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"></a>
      </li>
    </ul>
    <ul class="nav navbar-nav">
      <li> <a href="{{route('apoderado.alumno.search',$alumno->id)}}">{{$alumno->nombre}} {{$alumno->apellido}}</a></li>
      <li ><a href="{{route('apoderado.alumno.asignaturas',$alumno->id)}}">Asignaturas</a></li>
      <li ><a href="{{route('apoderado.alumno.proximas',$alumno->id)}}">Proximas Evaluaciones</a></li> 
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
    @endif
    @if($alumnos->count()>=2)       
    <ul class="nav navbar-nav navbar-left">
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Seleccione un Alumno<b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
          @foreach($alumnos AS $alumno)         
          <li><a href="{{route('apoderado.alumno.search',$alumno->id)}}">{{$alumno->nombre}} {{$alumno->apellido}}</a></li>
          @endforeach
        </ul>
      </li>
    </ul>
  </div>
</nav>

@endif



@endif       
@if(!Auth::check())
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

  <!-- Agrupar los enlaces de navegación, los formularios y cualquier
  otro elemento que se pueda ocultar al minimizar la barra -->
  <div class="collapse navbar-collapse navbar-ex1-collapse">

    <ul class="nav navbar-nav navbar-right">
     <li ><a href="{{route('admin.auth.login')}}">Iniciar Sesion</a></li>
   </ul>
   @endif
 </div>





</nav>