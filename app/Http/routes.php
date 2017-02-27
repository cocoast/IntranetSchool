<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
	GET
	POST:Para almacenar datos de un formulario
	PUT: editar algo
	DELETE: para borrar 
	RESOURCE
*/
	Route::get('/', ['as'=>'admin.index',function() {
		return view('welcome');
	}]);
	Route::get('pdf',function(){
		$pdf=PDF::loadView('vista');
		return $pdf->download('archivo.pdf');
	});

	Route::group(['prefix'=>'admin','middleware'=>'auth'],function(){

		Route::get('/',['as'=>'admin.index',function(){
			return view ('welcome');
		}]);
/*
*
*admin
*
*/
Route::group(['middleware'=>'admin'],function(){
	
	Route::get('inicio',['as'=>'admin.inicio',function(){
		return view ('admin.inicio');
	}]);

	Route::resource('users','UsersController');
	Route::get('users/{id}/destroy',[
		'uses'	=>'UsersController@destroy',
		'as'	=>'admin.users.destroy'
		]);

	Route::resource('alumnos','AlumnosController');
	Route::get('alumnos/{id}/destroy',[
		'uses'	=>'AlumnosController@destroy',
		'as'	=>'admin.alumnos.destroy'
		]);
	Route::get('alumnos/{id}/ghost',[
		'uses'	=>'AlumnosController@ghost',
		'as'	=>'admin.alumno.ghost'
		]);
	Route::get('alumnos/{id}/indexghost',[
		'uses'	=>'AlumnosController@listghost',
		'as'	=>'admin.alumno.listghost'
		]);
	Route::resource('antiguo','AntiguoController');
	Route::get('antiguo/{id}/rendimiento',[
		'uses'	=>'AntiguoController@listarAdmin',
		'as'	=>'admin.antiguo.asignaturas'
		]);
	//CERRAR AÑO ACADEMICO
	Route::get('close',[
		'uses'	=>'EstablecimientoController@closeYear',
		'as'	=>'admin.close'
		]);

	Route::resource('apoderados','ApoderadosController');
	Route::get('apoderados/{id}/destroy',[
		'uses'	=>'ApoderadosController@destroy',
		'as'	=>'admin.apoderados.destroy'
		]);

	Route::resource('docentes','DocentesController');
	Route::get('docentes/{id}/destroy',[
		'uses'	=>'DocentesController@destroy',
		'as'	=>'admin.docentes.destroy'
		]);
	Route::resource('cursos','CursosController');
	Route::get('cursos/{id}/destroy',[
		'uses'	=>'CursosController@destroy',
		'as'	=>'admin.cursos.destroy'
		]);
	Route::resource('asignaturas','AsignaturasController');
	Route::get('asignaturas/{id}/destroy',[
		'uses'	=>'AsignaturasController@destroy',
		'as'	=>'admin.asignaturas.destroy'
		]);
	Route::post('cursos/asignaturas',[
		'uses'	=>'CursosController@storeca',
		'as'	=>'admin.cursos.storeca'
		]);
	
	//asignatura_curso
	Route::get('cursos/{id}/asignaturas',[
		'uses'	=>'CursosController@cursoAsignaturas',
		'as'	=>'admin.cursos.asignaturas'
		]);
	//establecimiento
	Route::resource('configure','EstablecimientoController');
	//subir Excel
	Route::post('apoderados/up',[
		'uses'	=>'ApoderadosController@upExcel',
		'as'	=>'admin.apoderados.up'
		]);
	Route::post('docentes/up',[
		'uses'	=>'DocentesController@upExcel',
		'as'	=>'admin.docentes.up'
		]);
	Route::post('alumnos/up',[
		'uses'	=>'AlumnosController@upExcel',
		'as'	=>'admin.alumnos.up'
		]);
	Route::post('asignaturas/up',[
		'uses'	=>'AsignaturasController@upExcel',
		'as'	=>'admin.asignaturas.up'
		]);
	Route::post('cursos/up',[
		'uses'	=>'CursosController@upExcel',
		'as'	=>'admin.cursos.up'
		]);

	
});
});
/*
*
*docente
*
*/
Route::group(['prefix'=>'docente','middleware'=>['auth','docente']],function(){
	
	//index
	Route::get('index',[
		'uses'	=>'DocentesController@indexPag',
		'as'	=>'docentes.index'
		]);
	//reunion 
	Route::get('comunicados',[
		'uses'	=>'DocentesController@indexReunion',
		'as'	=>'docentes.reunion.index'
		]);
	Route::get('comunicados/{id}/create',[
		'uses'	=>'DocentesController@createReunion',
		'as'	=>'docentes.reunion.create'
		]);
	Route::get('comunicados/{id}/edit',[
		'uses'	=>'DocentesController@editReunion',
		'as'	=>'docentes.reunion.edit'
		]);
	Route::post('comunicados/store', [
		'uses' 	=>'DocentesController@storeReunion',
		'as'	=>	'docentes.reunion.store'
		]);
	Route::get('comunicados/{id}/destroy',[
		'uses'	=>'DocentesController@destroyReunion',
		'as'	=>'docentes.reunion.destroy'
		]);	
	Route::put('comunicados/{id}',[
		'uses'	=>'DocentesController@updateReunion',
		'as'	=>'docentes.reunion.update'
		]);
	//notas
	Route::resource('notas','NotasController');
	Route::get('notas/{id}/create',[
		'uses'	=>'NotasController@create',
		'as'	=>'docente.notas.creates'
		]);
	Route::get('notas/{notas}/createone/',[
		'uses'	=>'NotasController@createOne',
		'as'	=>'docente.notas.createone'
		]);
	Route::post('notas/storeone/',[
		'uses'	=>'NotasController@storeOne',
		'as'	=>'docente.notas.storeone'
		]);	
	Route::get('notas/{id}/index',[
		'uses'	=>'NotasController@index',
		'as'	=>'docente.notas.index'
		]);
	Route::get('notas/{id}/destroy',[
		'uses'	=>'NotasController@destroy',
		'as'	=>'docentes.notas.destroy'
		]);	
	//curso
	Route::get('curso/',[
		'uses'	=>'DocentesController@listcurso',
		'as'	=>'docentes.curso.index'
		]);
	Route::get('antiguo/{id}/rendimiento',[
		'uses'	=>'AntiguoController@listarDocente',
		'as'	=>'docente.alumno.antiguo'
		]);
	Route::get('curso/{id}/futurasevaluaciones',[
		'uses'	=>'ProximasController@indexCurso',
		'as'	=>'docentes.curso.proximasindex'
		]);

	Route::get('curso/asignaturas',[
		'uses'	=>'DocentesController@crearasistencia',
		'as'	=>'docente.curso.crasistencia'
		]);
	//asignaturas
	Route::get('asignaturas/',[
		'uses'	=>'DocentesController@listasignaturas',
		'as'	=>'docentes.asignaturas.index'
		]);
	//asistencia
	Route::resource('asistencia','AsistenciaController');
	Route::get('asistencia/{id}/index',[
		'uses'	=>'AsistenciaController@index',
		'as'	=>'docente.asistencia.index'
		]);	
	//anotaciones
	Route::resource('anotaciones','AnotacionesController');
	Route::get('anotaciones/{id}/index',[
		'uses'	=>'AnotacionesController@index',
		'as'	=>'docente.anotaciones.index'
		]);
	Route::get('anotaciones/{id}/create',[
		'uses'	=>'AnotacionesController@create',
		'as'	=>'docente.anotaciones.create'
		]);
	Route::get('anotaciones/{id}/destroy',[
		'uses'	=>'AnotacionesController@destroy',
		'as'	=>'docente.anotaciones.destroy'
		]);
	//anotaciones Curso
	Route::resource('anotacionescurso','AnotacionesCursoController');
	Route::get('anotacionescurso/{id}/indexcurso',[
		'uses'	=>'AnotacionesCursoController@index',
		'as'	=>'docente.anotaciones.indexCurso'
		]);
	Route::get('anotacionescurso/{id}/create',[
		'uses'	=>'AnotacionesCursoController@create',
		'as'	=>'docente.anotaciones.createCurso'
		]);
	Route::get('anotacionescurso/{id}/destroy',[
		'uses'	=>'AnotacionesCursoController@destroy',
		'as'	=>'docente.anotaciones.destroyCurso'
		]);
	Route::get('alumno/notas/{id}',[
		'uses'	=>'AlumnosController@verNotas',
		'as'	=>'docente.alumno.notas'
		]);
	Route::get('notas/cursos/{id}',[
		'uses'	=>'DocentesController@verNotasCurso',
		'as'	=>'curso.view.notas'
		]);
	Route::get('notas/curso/{asignaturaid}',[
		'as'	=>'docente.curso.indexnotas',function(){
			return view('docente.curso.indexnotas');
		}]);

	//evaluacionesproximas
	Route::resource('proximas','ProximasController');
	Route::get('proximas/{id}/index',[
		'uses'	=>'ProximasController@index',
		'as'	=>'docente.proximas.index'
		]);
	Route::get('proximas/{id}/create',[
		'uses'	=>'ProximasController@create',
		'as'	=>'docente.proximas.create'
		]);
	Route::get('proximas/{id}/destroy',[
		'uses'	=>'ProximasController@destroy',
		'as'	=>'docente.proximas.destroy'
		]);

	//pdf 

	//asistencia
	Route::get('asistencia/pdf/{id}',[
		'uses'	=>'AsistenciaController@pdfAsistencias',
		'as'	=>'docente.asistencia.pdf'
		]);
	//index reportes
	Route::get('alumno/{id}/reportes',[
		'uses'	=>'NotasController@indexrepo',
		'as'	=>'docente.reportes.index'
		]);

	//notas por alumno
	Route::get('notas/alumno/pdf/{id}',[
		'uses'	=>'NotasController@pdfNotas',
		'as'	=>'docente.alumno.pdf'
		]);
	//notaspor curso
	Route::get('notas/curso/pdf/{id}',[
		'uses'	=>'NotasController@pdfNotasCurso',
		'as'	=>'docente.curso.pdf'
		]);
	//notas1semestre
	Route::get('notas/alumno/1s/pdf/{id}',[
		'uses'	=>'NotasController@notassemestral1',
		'as'	=>'docente.alumno.s1.pdf'
		]);
	//notas2semestre
	Route::get('notas/alumno/2s/pdf/{id}',[
		'uses'	=>'NotasController@notassemestral2',
		'as'	=>'docente.alumno.s2.pdf'
		]);
	//notasAnual
	Route::get('notas/alumno/anual/pdf/{id}',[
		'uses'	=>'NotasController@notasAnual',
		'as'	=>'docente.alumno.anual.pdf'
		]);
	//Certificado Anual
	Route::get('notas/alumno/canual/pdf/{id}',[
		'uses'	=>'NotasController@certificadoAnual',
		'as'	=>'docente.alumno.canual.pdf'
		]);
	
});
/*
*Alumno
*/
Route::group(['prefix'=>'alumno','middleware'=>['auth','alumno']],function(){
	Route::get('asignaturas/',[
		'uses'	=>'AlumnosController@listAsignaturas',
		'as'	=>'alumno.asignaturas.index'
		]);
	Route::get('asignaturas/{id}/notas',[
		'uses'	=>'AlumnosController@asignaturaNotas',
		'as'	=>'alumno.asignaturas.notas'
		]);
	Route::get('asignaturas/{id}/anotaciones',[
		'uses'	=>'AlumnosController@asignaturaAnotaciones',
		'as'	=>'alumno.asignaturas.Anotaciones'
		]);
	Route::get('asignaturas/{id}/proximas',[
		'uses'	=>'AlumnosController@asignaturaProximas',
		'as'	=>'alumno.asignaturas.proximas'
		]);
	Route::get('curso/anotaciones',[
		'uses'	=>'AlumnosController@listCursoanotaciones',
		'as'	=>'alumno.cursoanotaciones.index'
		]);
	Route::get('curso/proximas30',[
		'uses'	=>'AlumnosController@proximas30',
		'as'	=>'alumno.curso.proximas'
		]);
	Route::get('alumno',[
		'uses'	=>'AlumnosController@Alumno',
		'as'	=>'alumno.alumno.index'
		]);
	
});
/*
*
*Apoderado
*/
Route::group(['prefix'=>'apoderado','middleware'=>['auth','apoderado']],function(){
	Route::get('apoderado/{id}/alumno',[
		'uses'	=>'ApoderadosController@Alumno',
		'as'	=>'apoderado.alumno.search'
		]);
	Route::get('apoderado/alumno/{id}/asignaturas',[
		'uses'	=>'ApoderadosController@asignaturasAlumno',
		'as'	=>'apoderado.alumno.asignaturas'
		]);
	Route::get('apoderado/alumno/{id}/proximas',[
		'uses'	=>'ApoderadosController@proximasAlumno',
		'as'	=>'apoderado.alumno.proximas'
		]);
	Route::get('apoderado/alumno/{id}/asignaturas/notas',[
		'uses'	=>'ApoderadosController@notasAlumno',
		'as'	=>'apoderado.alumno.asignaturas.notas'
		]);
	Route::get('apoderado/alumno/{id}/asignaturas/proximas',[
		'uses'	=>'ApoderadosController@asignaturaproximaAlumno',
		'as'	=>'apoderado.alumno.asignaturas.proximas'
		]);
	Route::get('apoderado/alumno/{id}/asignaturas/anotaciones',[
		'uses'	=>'ApoderadosController@anotacionesAlumno',
		'as'	=>'apoderado.alumno.asignaturas.anotaciones'
		]);
	Route::get('apoderado/alumno/{id}/curso/anotaciones',[
		'uses'	=>'ApoderadosController@anotacionesCurso',
		'as'	=>'apoderado.alumno.cursoanotaciones'
		]);
});

// Authentication routes...
Route::get('admin/auth/login', [
	'uses' 	=>'Auth\AuthController@getLogin',
	'as'	=>	'admin.auth.login'
	]);
Route::post('admin/auth/login', [
	'uses' 	=>'Auth\AuthController@postLogin',
	'as'	=>	'admin.auth.login'
	]);

Route::get('admin/auth/logout', [
	'uses' 	=>'Auth\AuthController@getLogout',
	'as'	=>	'admin.auth.logout'
	]);

