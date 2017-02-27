@extends('admin.template.main')
@section('tittle', 'Configuracion Establecimiento')
@section('content')
<hr>
<?php
if(App\Establecimiento::first()){
	$establecimiento=App\Establecimiento::first();
	$route='admin.configure.update';
	$method='PUT';

}
	else{
		$route='admin.configure.store';
		$establecimiento=new App\Establecimiento;
		$method='POST';
}
?>

{!! Form::open(['route'=>$route,'method'=>$method ,'files'=>true]) !!} 
<div class="row">
<div class="col-md-6">
<h1>Datos del Establecimiento</h1>
<div class="form-group">
	{!!Form::label('nombre','Nombre')!!}
	{!!Form::text('nombre',$establecimiento->nombre,['class'=>'form-control','placeholder'=>'Nombre Establecimiento','requiered'])!!}
</div>
<div class="form-group">
	{!!Form::label('direccion','Direccion')!!}
	{!!Form::text('direccion',$establecimiento->direccion,['class'=>'form-control','placeholder'=>'Direccion Establecimiento','requiered'])!!}
</div>
<div class="form-group">
	{!!Form::label('telefono','Telefono ')!!}
	{!!Form::text('telefono',$establecimiento->telefono,['class'=>'form-control','placeholder'=>'Telefono','requiered'])!!}
</div>
<div class="form-group">
	{!!Form::label('mail','Email')!!}
	{!!Form::email('mail',$establecimiento->mail,['class'=>'form-control','placeholder'=>'establecimiento@example.com','requiered'])!!}
</div>
</div>
<div class="col-md-6">
<h1>Datos del Director</h1>
<div class="form-group">
	{!!Form::label('director','Nombre Director')!!}
	{!!Form::text('director',$establecimiento->director,['class'=>'form-control','placeholder'=>'Nombre Apellido','requiered'])!!}
</div>
<div class="form-group">
	{!!Form::label('rutdirec','RUT Director')!!}
	{!!Form::text('rutdirec',$establecimiento->rutdirec,['class'=>'form-control','placeholder'=>'Nombre Apellido','requiered'])!!}
</div>
<div class="form-group">
	{!!Form::label('mail_director','Email Director')!!}
	{!!Form::email('mail_director',$establecimiento->mail_director,['class'=>'form-control','placeholder'=>'director@example.cl','requiered'])!!}
</div>
<div class="form-group">
	{!!Form::label('telefono_director','Telefono Director')!!}
	{!!Form::text('telefono_director',$establecimiento->telefono_director,['class'=>'form-control','placeholder'=>'098765232','requiered'])!!}
</div>
</div>
</div>
<h1>Configuracion del Establecimiento</h1>
<hr>
<div class="row">
<div class="col-md-6">
{!!Form::label('logo','Subir Logo')!!} 
{!!Form::file('logo',['class'=>'form-control','accept'=>'.png']) !!}
</div>
<div class="col-md-6">

{!!Form::label('actual','Logo Actual')!!}
 <img class="logo-icon" src="{{asset($establecimiento->logo)}}">
 </div>
</div>
<hr>
<div class="form-form">
{!!Form::label('s1inicio','Inicio Primer Semestre: ')!!}
{!!Form::date('s1inicio',$establecimiento->s1inicio,['class'=>'form-group','step'=>'1','min'=>'2015-03-01'])!!}
{!!Form::label('s1fin','Fin Primer Semestre: ')!!}
{!!Form::date('s1fin',$establecimiento->s1fin,['class'=>'form-group','step'=>'1','min'=>'2015-03-01'])!!}
</div>
<div class="form-form">
{!!Form::label('s2inicio','Inicio Segundo Semestre: ')!!}
{!!Form::date('s2inicio',$establecimiento->s2inicio,['class'=>'form-group','step'=>'1','min'=>'2015-03-01'])!!}
{!!Form::label('s2fin','Fin Segundo Semestre: ')!!}
{!!Form::date('s2fin',$establecimiento->s2fin,['class'=>'form-group','step'=>'1','min'=>'2015-03-01'])!!}
</div>

<hr>
<div class="form-form">
		{!!Form::submit('Salvar',['class'=>'btn btn-primary'])!!}
</div>
{!!Form::close()!!}
@endsection