<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index');
//rutas para la autenticacion del usuario
Auth::routes();

//rutas para facturacion electronica
//PRODUCTOS
Route::get('super/facturacion/productos','usuario\super\facturacion\Producto@index')->name('super/facturacion/productos');
Route::post('super/facturacion/producto/agregar','usuario\super\facturacion\Producto@agregar')->name('super/facturacion/producto/agregar');
Route::post('super/facturacion/producto/actualizar','usuario\super\facturacion\Producto@actualizar')->name('super/facturacion/producto/actualizar');
Route::post('super/facturacion/producto/aplicar','usuario\super\facturacion\Producto@aplicar')->name('super/facturacion/producto/aplicar');
Route::post('super/facturacion/producto/eliminar','usuario\super\facturacion\Producto@eliminar')->name('super/facturacion/producto/eliminar');
Route::post('super/facturacion/producto/restaurar','usuario\super\facturacion\Producto@restaurar')->name('super/facturacion/producto/restaurar');
Route::post('super/facturacion/producto/busqueda/nombrecodigo','usuario\super\facturacion\Producto@busqueda_nombre_codigo')->name('super/facturacion/producto/busqueda/nombrecodigo');
Route::post('super/facturacion/producto/filtrotipo','usuario\super\facturacion\Producto@filtro_tipo')->name('super/facturacion/producto/filtrotipo');
Route::post('super/facturacion/producto/filtrounidad','usuario\super\facturacion\Producto@filtro_unidad')->name('super/facturacion/producto/filtrounidad');
Route::post('super/facturacion/producto/eliminados','usuario\super\facturacion\Producto@eliminados')->name('super/facturacion/producto/eliminados');

//SERIES
Route::get('super/facturacion/series','usuario\super\facturacion\Serie@index')->name('super/facturacion/series');
Route::post('super/facturacion/serie/agregar','usuario\super\facturacion\Serie@agregar')->name('super/facturacion/serie/agregar');
Route::post('super/facturacion/serie/aplicar','usuario\super\facturacion\Serie@aplicar')->name('super/facturacion/serie/aplicar');
Route::post('super/facturacion/serie/eliminar','usuario\super\facturacion\Serie@eliminar')->name('super/facturacion/serie/eliminar');
Route::post('super/facturacion/serie/restaurar','usuario\super\facturacion\Serie@restaurar')->name('super/facturacion/serie/restaurar');
Route::post('super/facturacion/serie/tipodocumento','usuario\super\facturacion\Serie@tipo_documento')->name('super/facturacion/serie/tipodocumento');
Route::post('super/facturacion/serie/actualizar','usuario\super\facturacion\Serie@actualizar')->name('super/facturacion/serie/actualizar');
Route::post('super/facturacion/serie/eliminados','usuario\super\facturacion\Serie@eliminados')->name('super/facturacion/serie/eliminados');
Route::post('super/facturacion/serie/estableceraprincipal','usuario\super\facturacion\Serie@establecer_a_principal')->name('super/facturacion/serie/estableceraprincipal');
Route::post('super/facturacion/serie/prefijo','usuario\super\facturacion\Serie@prefijo')->name('super/facturacion/serie/prefijo');

//COMPROBANTE
Route::get('super/facturacion/comprobante','usuario\super\facturacion\Comprobante@index')->name('super/facturacion/comprobante');
Route::post('super/facturacion/comprobante/basiconecesario','usuario\super\facturacion\Comprobante@basico_necesario')->name('super/facturacion/comprobante/basiconecesario');
Route::post('super/facturacion/comprobante/alumnos','usuario\super\facturacion\Comprobante@alumnos')->name('super/facturacion/comprobante/alumnos');
Route::post('super/facturacion/comprobante/alumno','usuario\super\facturacion\Comprobante@alumno')->name('super/facturacion/comprobante/alumno');
Route::post('super/facturacion/comprobante/posiblesclientes','usuario\super\facturacion\Comprobante@posibles_clientes')->name('super/facturacion/comprobante/posiblesclientes');
Route::get('super/facturacion/comprobante/productos/{q}/{tipo}','usuario\super\facturacion\Comprobante@productos')->name('super/facturacion/comprobante/productos/{q}/{tipo}');
Route::post('super/facturacion/comprobante/producto','usuario\super\facturacion\Comprobante@producto')->name('super/facturacion/comprobante/producto');

//rutas para el chat
Route::get('chat','ChatController@index')->name('chat');
Route::get('chat/contacts','ContactsController@get')->name('chat/contacts');
Route::get('chat/conversation/{id}','ContactsController@getMessagesFor')->name('chat/conversation/{id}');
Route::post('chat/conversation/send','ContactsController@send')->name('chat/conversation/send');

Route::post('chat/group/crear','GroupController@crear')->name('chat/group/crear');
Route::post('chat/group/drop','GroupController@drop')->name('chat/group/drop');
Route::post('chat/group/sendmessage','GroupController@send_message')->name('chat/group/sendmessage');
Route::get('chat/group/conversations/{group_id}','GroupController@conversations')->name('chat/group/conversations/{group_id}');

//ruta para notificaciones de tipo comunicado y anuncio
Route::post('notificacionesdelusuario/comunicado/marcarcomoleido', 'Notificacion@marcar_como_leido_tipo_comunicado')->name('notificacionesdelusuario/comunicado/marcarcomoleido');
Route::post('notificacionesdelusuario/anuncio/marcarcomoleido', 'Notificacion@marcar_como_leido_tipo_anuncio')->name('notificacionesdelusuario/anuncio/marcarcomoleido');

//rutas para las herramientas del usuario
//logo fisico
//formas de hacer peticion
/*
	BLADE
	si no es nulo el campo c_logo_fisico
	src="{{url('herramienta/logo/'.$herramienta->c_logo_fisico)}}"

	JAVASCRIPT
	si no es nulo el campo c_logo_fisico
	src = '/herramienta/logo/'+herramienta.c_logo_fisico;
*/
Route::get('herramienta/logo/{fileName}', 'Herramienta@logo_fisico')->name('herramienta/logo/{fileName}');

//devuelve un redirect
Route::post('herramienta/agregar','Herramienta@agregar')->name('herramienta/agregar');

//devuelve json no sirve para blade, valido para peticiones AJAX

//recomendable hacer esto
/*
	Si la peticion se hace desde BLADE
	Auth::user()->herramientas()->get();
		o si no
	@php
		$usuario = App\User::findOrFail(Auth::user()->id);
		$herramientas  = $usuario->herramientas()->get();
	@endphp
*/
Route::get('herramienta/listar','Herramienta@listar')->name('herramienta/listar');

//devuelve un redirect, pero si desea puede ser json
Route::post('herramienta/eliminar','Herramienta@eliminar')->name('herramienta/eliminar');

//devuelve JSON
Route::post('herramienta/buscar','Herramienta@buscar')->name('herramienta/buscar');


//notificaciones del usuario
Route::post('notificacionesdelusuario','Notificacion@listar')->name('notificacionesdelusuario');
Route::post('notificacionesdelusuario/marcarcomoleido', 'Notificacion@marcar_como_leido')->name('notificacionesdelusuario/marcarcomoleido');
Route::post('notificacionesdelusuario/marcartodocomoleido', 'Notificacion@marcar_todo_como_leido')->name('notificacionesdelusuario/marcartodocomoleido');
//para generar un usuario superadministrado del colegio
Route::post('register/generarusuario', 'SuperAdmin@generar_usuario')->name('register/generarusuario');
//para verificar si el colegio ha pagado la plataforma, para usarse
//Route::post('verificaractivo','Pago@verificar')->name('verificaractivo');
Route::post('ruc/buscar','api\Ruc@buscar')->name('ruc/buscar');
Route::post('dni/buscar','api\Dni@buscar')->name('dni/buscar');

//rutas para el superadministrador
Route::get('super/colegio', 'usuario\super\Colegio@index')->name('super/colegio');

Route::post('super/colegio/actualizar', 'usuario\super\Colegio@actualizar_info')->name('super/colegio/actualizar');
Route::post('super/colegio/cambiarlogo', 'usuario\super\Colegio@cambiar_logo')->name('super/colegio/cambiarlogo');
Route::get('super/colegio/logo/{fileName}', 'usuario\super\Colegio@logo')->name('super/colegio/logo/{fileName}');

Route::post('super/usuario/cambiarcontrasena', 'usuario\super\Usuario@cambiar_contrasena')->name('super/usuario/cambiarcontrasena');

Route::get('super/docentes', 'usuario\super\Docente@index')->name('super/docentes');
Route::get('super/docente/{id_docente}', 'usuario\super\Docente@info')->name('super/docentes/{id_docente}');

Route::post('super/docente/agregar', 'usuario\super\Docente@agregar')->name('super/docente/agregar');

Route::post('super/docente/actualizar', 'usuario\super\Docente@actualizar')->name('super/docente/actualizar');
Route::post('super/docente/quitarseccion', 'usuario\super\Docente@quitar_seccion')->name('super/docente/quitarseccion');
Route::post('super/docente/agregarseccion', 'usuario\super\Docente@agregar_seccion')->name('super/docente/agregarseccion');
Route::post('super/docente/quitarcategoria', 'usuario\super\Docente@quitar_categoria')->name('super/docente/quitarcategoria');
Route::post('super/docente/agregarcategoria', 'usuario\super\Docente@agregar_categoria')->name('super/docente/agregarcategoria');
Route::post('super/docente/cambiarfoto', 'usuario\super\Docente@cambiar_foto')->name('super/docente/cambiarfoto');
Route::get('super/docente/foto/{fileName}', 'usuario\super\Docente@foto')->name('super/docente/foto/{fileName}');
Route::post('super/docente/cambiarcontrasena', 'usuario\super\Docente@cambiar_contrasena')->name('super/docente/cambiarcontrasena');
Route::post('super/docente/eliminar', 'usuario\super\Docente@eliminar')->name('super/docente/eliminar');


Route::get('super/alumnos', 'usuario\super\Alumno@index')->name('super/alumnos');
Route::get('super/alumno/{id_alumno}', 'usuario\super\Alumno@info')->name('super/alumno/{id_alumno}');
Route::post('super/alumno/agregar', 'usuario\super\Alumno@agregar')->name('super/alumno/agregar');
Route::get('super/alumno/foto/{fileName}', 'usuario\super\Alumno@foto')->name('super/alumno/foto/{fileName}');
Route::post('super/alumno/cambiarfoto', 'usuario\super\Alumno@cambiar_foto')->name('super/alumno/cambiarfoto');
Route::post('super/alumno/cambiarcontrasena', 'usuario\super\Alumno@cambiar_contrasena')->name('super/alumno/cambiarcontrasena');
Route::post('super/alumno/actualizar', 'usuario\super\Alumno@actualizar')->name('super/alumno/actualizar');
Route::post('super/alumno/actualizarrepresentante', 'usuario\super\Alumno@actualizar_representante')->name('super/alumno/actualizarrepresentante');
Route::post('super/alumno/eliminar', 'usuario\super\Alumno@eliminar')->name('super/alumno/eliminar');

//Route::get('super/grados', 'usuario\super\Grado@index')->name('super/grados');
//Route::post('super/grados/agregar', 'usuario\super\Grado@agregar')->name('super/grados/agregar');
//Route::post('super/grados/actualizar', 'usuario\super\Grado@actualizar')->name('super/grados/actualizar');
//Route::post('super/grados/aplicar', 'usuario\super\Grado@aplicar')->name('super/grados/aplicar');
//Route::post('super/grados/eliminar', 'usuario\super\Grado@eliminar')->name('super/grados/eliminar');

//Route::get('super/secciones', 'usuario\super\Seccion@index')->name('super/secciones');
//Route::post('super/secciones/agregar', 'usuario\super\Seccion@agregar')->name('super/secciones/agregar');
//Route::post('super/secciones/actualizar', 'usuario\super\Seccion@actualizar')->name('super/secciones/actualizar');
//Route::post('super/secciones/eliminar', 'usuario\super\Seccion@eliminar')->name('super/secciones/eliminar');
Route::post('super/gradoseccion/alumnos', 'usuario\super\GradoSeccion@alumnos')->name('super/gradoseccion/alumnos');
Route::post('super/gradoseccion/docentes', 'usuario\super\GradoSeccion@docentes')->name('super/gradoseccion/docentes');

Route::get('super/gradoseccion', 'usuario\super\GradoSeccion@index')->name('super/gradoseccion');
Route::post('super/gradoseccion/agregar', 'usuario\super\GradoSeccion@agregar')->name('super/gradoseccion/agregar');
Route::post('super/gradoseccion/actualizar', 'usuario\super\GradoSeccion@actualizar')->name('super/gradoseccion/actualizar');
Route::post('super/gradoseccion/aplicar', 'usuario\super\GradoSeccion@aplicar')->name('super/gradoseccion/aplicar');
Route::post('super/gradoseccion/eliminar', 'usuario\super\GradoSeccion@eliminar')->name('super/gradoseccion/eliminar');

//
//docentes de un curso
Route::post('super/categoria/docentes', 'usuario\super\Categoria@docentes')->name('super/categoria/docentes');

Route::get('super/categorias/read_asignatura', 'usuario\super\Categoria@read_asignatura')->name('super/categorias/read_asignatura');
Route::post('super/categorias/create_asignatura', 'usuario\super\Categoria@create_asignatura')->name('super/categorias/create_asignatura');
Route::post('super/categorias/update_asignatura', 'usuario\super\Categoria@update_asignatura')->name('super/categorias/update_asignatura');
Route::post('super/categorias/delete_asignatura', 'usuario\super\Categoria@delete_asignatura')->name('super/categorias/delete_asignatura');

Route::post('super/categorias/read_seccion_categoria', 'usuario\super\Categoria@read_seccion_categoria')->name('super/categorias/read_seccion_categoria');
Route::post('super/categorias/create_seccion_categoria', 'usuario\super\Categoria@create_seccion_categoria')->name('super/categorias/create_seccion_categoria');
Route::post('super/categorias/update_seccion_categoria', 'usuario\super\Categoria@update_seccion_categoria')->name('super/categorias/update_seccion_categoria');
Route::post('super/categorias/delete_seccion_categoria', 'usuario\super\Categoria@delete_seccion_categoria')->name('super/categorias/delete_seccion_categoria');

//

Route::get('super/categorias', 'usuario\super\Categoria@index')->name('super/categorias');
Route::post('super/categorias/agregar', 'usuario\super\Categoria@agregar')->name('super/categorias/agregar');
Route::post('super/categorias/actualizar', 'usuario\super\Categoria@actualizar')->name('super/categorias/actualizar');
Route::post('super/categorias/aplicar', 'usuario\super\Categoria@aplicar')->name('super/categorias/aplicar');
Route::post('super/categorias/eliminar', 'usuario\super\Categoria@eliminar')->name('super/categorias/eliminar');
Route::post('super/categorias/quitarcategoria', 'usuario\super\Categoria@quitar_categoria')->name('super/categorias/quitarcategoria');
Route::post('super/categorias/aplicarseccion', 'usuario\super\Seccion@aplicar')->name('super/categorias/aplicarseccion');
Route::post('super/categorias/agregarcategoriaaseccion', 'usuario\super\Seccion@agregar_categoria')->name('super/categorias/agregarcategoriaaseccion');

// AGREGANDO RUTAS SUPER ADMIN
Route::get('super/videoconferencia', 'usuario\super\Videoconferencia@index')->name('super/videoconferencia');
Route::get('super/comunicados', 'usuario\super\Comunicado@index')->name('super/comunicados');
Route::post('super/comunicados/agregar', 'usuario\super\Comunicado@agregar')->name('super/comunicados/agregar');
Route::get('comunicado/ver/{id_comunicado}', 'usuario\super\Comunicado@info')->name('comunicado/ver/{id_comunicado}');
Route::get('comunicado/archivo/{id_comunicado}', 'usuario\super\Comunicado@descargar_archivo')->name('comunicado/archivo/{id_comunicado}');

// CURSOS *********************************************************

Route::get('alumno/cursos', 'usuario\alumno\Cursos@index')->name('alumno/cursos');
Route::get('alumno/cursos/curso/{id_curso}', 'usuario\alumno\Cursos@curso')->name('alumno/cursos/curso/{id_curso}');
Route::get('alumno/cursos/descargar_archivo/{id_archivo}', 'usuario\alumno\Cursos@descargar_archivo')->name('alumno/cursos/descargar_archivo/{id_archivo}');

Route::post('docente/seccion/cursos', 'usuario\docente\Cursos@cursos_de_secciones')->name('docente/seccion/cursos');
Route::get('docente/cursos', 'usuario\docente\Cursos@index')->name('docente/cursos');
Route::get('docente/cursos/curso/{id_curso}', 'usuario\docente\Cursos@curso')->name('docente/cursos/curso/{id_curso}');
Route::post('docente/cursos/crear_modulo', 'usuario\docente\Cursos@crear_modulo')->name('docente/cursos/crear_modulo');
Route::post('docente/cursos/actualizar_modulo', 'usuario\docente\Cursos@actualizar_modulo')->name('docente/cursos/actualizar_modulo');
Route::post('docente/cursos/eliminar_modulo', 'usuario\docente\Cursos@eliminar_modulo')->name('docente/cursos/eliminar_modulo');
Route::post('docente/cursos/agregar_archivo', 'usuario\docente\Cursos@agregar_archivo')->name('docente/cursos/agregar_archivo');
Route::post('docente/cursos/eliminar_archivo', 'usuario\docente\Cursos@eliminar_archivo')->name('docente/cursos/eliminar_archivo');
Route::get('docente/cursos/descargar_archivo/{id_archivo}', 'usuario\docente\Cursos@descargar_archivo')->name('docente/cursos/descargar_archivo/{id_archivo}');
Route::post('docente/cursos/crear_anuncio', 'usuario\docente\Cursos@crear_anuncio')->name('docente/cursos/crear_anuncio');
Route::post('docente/cursos/eliminar_anuncio', 'usuario\docente\Cursos@eliminar_anuncio')->name('docente/cursos/eliminar_anuncio');
Route::post('docente/cursos/crear_tarea', 'usuario\docente\Cursos@crear_tarea')->name('docente/cursos/crear_tarea');
Route::post('docente/cursos/crear_comentario', 'usuario\docente\Cursos@crear_comentario')->name('docente/cursos/crear_comentario');
Route::get('docente/cursos/comentarios', 'usuario\docente\Cursos@comentarios')->name('docente/cursos/comentarios');

// CURSOS *********************************************************

//rutas para el alumno
Route::get('alumno/calendario', 'usuario\alumno\Calendario@index')->name('alumno/calendario');
Route::get('alumno/tareas', 'usuario\alumno\Tarea@index')->name('alumno/tareas');
Route::get('alumno/docentes', 'usuario\alumno\Docente@index')->name('alumno/docentes');
Route::get('alumno/companieros', 'usuario\alumno\Companiero@index')->name('alumno/companieros');

Route::post('alumno/cambiarcontrasena', 'usuario\alumno\Usuario@cambiar_contrasena')->name('alumno/cambiarcontrasena');
Route::get('alumno/cambiarcontrasena', 'usuario\alumno\Usuario@index')->name('alumno/cambiarcontrasena');

Route::post('alumno/tarea/listar', 'usuario\alumno\Tarea@listar')->name('alumno/tarea/listar');
Route::post('alumno/tarea/respuesta', 'usuario\alumno\Tarea@respuesta')->name('alumno/tarea/respuesta');
Route::post('alumno/tarea/responder', 'usuario\alumno\Tarea@responder')->name('alumno/tarea/responder');
Route::post('alumno/tarea/editarrespuesta', 'usuario\alumno\Tarea@editar_respuesta')->name('alumno/tarea/editarrespuesta');
Route::post('alumno/tarea/comentarpendiente', 'usuario\alumno\Tarea@comentar_pendiente')->name('alumno/tarea/comentarpendiente');
Route::post('alumno/tarea/comentarvencido', 'usuario\alumno\Tarea@comentar_vencido')->name('alumno/tarea/comentarvencido');
Route::post('alumno/tarea/comentarenviado', 'usuario\alumno\Tarea@comentar_enviado')->name('alumno/tarea/comentarenviado');
Route::get('alumno/tareapendiente/{id_tarea}', 'usuario\alumno\Tarea@info_pendiente')->name('alumno/tareapendiente/{id_tarea}');
Route::get('alumno/tareaenviada/{id_tarea}', 'usuario\alumno\Tarea@info_enviado')->name('alumno/tareaenviada/{id_tarea}');
Route::get('alumno/tareavencida/{id_tarea}', 'usuario\alumno\Tarea@info_vencido')->name('alumno/tareavencida/{id_tarea}');
Route::get('alumno/tarea/respuestaarchivo/{id_tarea}/{id_respuesta}', 'usuario\alumno\Tarea@descargar_archivo')->name('alumno/tarea/respuestaarchivo/{id_tarea}/{id_respuesta}');

Route::post('docente/cambiarcontrasena', 'usuario\docente\Usuario@cambiar_contrasena')->name('docente/cambiarcontrasena');
Route::get('docente/cambiarcontrasena', 'usuario\docente\Usuario@index')->name('docente/cambiarcontrasena');

Route::post('docente/docente/aplicar', 'usuario\docente\Docente@aplicar')->name('docente/docente/aplicar');
Route::post('docente/docente/buscar', 'usuario\docente\Docente@buscar')->name('docente/docente/buscar');
Route::post('docente/docente/alumnoscategorias', 'usuario\docente\AsignarTareas@alumnos_categorias')->name('docente/docente/alumnoscategorias');
Route::post('docente/tarea/registrar', 'usuario\docente\AsignarTareas@asignar')->name('docente/tarea/registrar');
Route::post('docente/tarea/aplicar', 'usuario\docente\Tarea@aplicar')->name('docente/tarea/aplicar');
Route::post('docente/tarea/aplicar_info', 'usuario\docente\Tarea@aplicar_info')->name('docente/tarea/aplicar_info');
Route::post('docente/tarea/respuesta', 'usuario\docente\Tarea@respuesta')->name('docente/tarea/respuesta');
Route::post('docente/tarea/calificarrespuesta', 'usuario\docente\Tarea@calificar_respuesta')->name('docente/tarea/calificarrespuesta');
Route::get('docente/tarea/{id_tarea}', 'usuario\docente\Tarea@info')->name('docente/tarea/{id_tarea}');
Route::get('docente/tarea/archivo/{id_tarea}', 'usuario\docente\Tarea@descargar_archivo')->name('docente/tarea/archivo/{id_tarea}');

Route::post('docente/alumno/aplicar', 'usuario\docente\Alumno@aplicar')->name('docente/alumno/aplicar');
Route::post('docente/tarea/comentar', 'usuario\docente\Tarea@comentar')->name('docente/tarea/comentar');

// RUTAS PARA EL DOCENTE
Route::get('docente/docentes', 'usuario\docente\Docente@index')->name('docente/docente');
Route::get('docente/alumnos', 'usuario\docente\Alumno@index')->name('docente/alumno');
Route::get('docente/asignartareas', 'usuario\docente\AsignarTareas@index')->name('docente/asignartareas');
Route::get('docente/estadotareas', 'usuario\docente\EstadoTareas@index')->name('docente/estadotareas');
Route::get('docente/videoclase', 'usuario\docente\Videoclase@index')->name('docente/videoclase');

// Route::view('/', 'starter')->name('starter');
Route::get('large-compact-sidebar/dashboard/dashboard1', function () {
    // set layout sesion(key)
    session(['layout' => 'compact']);
    return view('dashboard.dashboardv1');
})->name('compact');

Route::get('large-sidebar/dashboard/dashboard1', function () {
    // set layout sesion(key)
    session(['layout' => 'normal']);
    return view('dashboard.dashboardv1');
})->name('normal');

Route::get('horizontal-bar/dashboard/dashboard1', function () {
    // set layout sesion(key)
    session(['layout' => 'horizontal']);
    return view('dashboard.dashboardv1');
})->name('horizontal');

Route::get('vertical/dashboard/dashboard1', function () {
    // set layout sesion(key)
    session(['layout' => 'vertical']);
    return view('dashboard.dashboardv1');
})->name('vertical');


Route::view('dashboard/dashboard1', 'dashboard.dashboardv1')->name('dashboard_version_1');
Route::view('dashboard/dashboard2', 'dashboard.dashboardv2')->name('dashboard_version_2');
Route::view('dashboard/dashboard3', 'dashboard.dashboardv3')->name('dashboard_version_3');
Route::view('dashboard/dashboard4', 'dashboard.dashboardv4')->name('dashboard_version_4');

// uiKits
Route::view('uikits/alerts', 'uiKits.alerts')->name('alerts');
Route::view('uikits/accordion', 'uiKits.accordion')->name('accordion');
Route::view('uikits/buttons', 'uiKits.buttons')->name('buttons');
Route::view('uikits/badges', 'uiKits.badges')->name('badges');
Route::view('uikits/bootstrap-tab', 'uiKits.bootstrap-tab')->name('bootstrap-tab');
Route::view('uikits/carousel', 'uiKits.carousel')->name('carousel');
Route::view('uikits/collapsible', 'uiKits.collapsible')->name('collapsible');
Route::view('uikits/lists', 'uiKits.lists')->name('lists');
Route::view('uikits/pagination', 'uiKits.pagination')->name('pagination');
Route::view('uikits/popover', 'uiKits.popover')->name('popover');
Route::view('uikits/progressbar', 'uiKits.progressbar')->name('progressbar');
Route::view('uikits/tables', 'uiKits.tables')->name('tables');
Route::view('uikits/tabs', 'uiKits.tabs')->name('tabs');
Route::view('uikits/tooltip', 'uiKits.tooltip')->name('tooltip');
Route::view('uikits/modals', 'uiKits.modals')->name('modals');
Route::view('uikits/NoUislider', 'uiKits.NoUislider')->name('NoUislider');
Route::view('uikits/cards', 'uiKits.cards')->name('cards');
Route::view('uikits/cards-metrics', 'uiKits.cards-metrics')->name('cards-metrics');
Route::view('uikits/typography', 'uiKits.typography')->name('typography');

// extra kits
Route::view('extrakits/dropDown', 'extraKits.dropDown')->name('dropDown');
Route::view('extrakits/imageCroper', 'extraKits.imageCroper')->name('imageCroper');
Route::view('extrakits/loader', 'extraKits.loader')->name('loader');
Route::view('extrakits/laddaButton', 'extraKits.laddaButton')->name('laddaButton');
Route::view('extrakits/toastr', 'extraKits.toastr')->name('toastr');
Route::view('extrakits/sweetAlert', 'extraKits.sweetAlert')->name('sweetAlert');
Route::view('extrakits/tour', 'extraKits.tour')->name('tour');
Route::view('extrakits/upload', 'extraKits.upload')->name('upload');


// Apps
Route::view('apps/invoice', 'apps.invoice')->name('invoice');
Route::view('apps/inbox', 'apps.inbox')->name('inbox');
Route::view('apps/chat', 'apps.chat')->name('chat');
Route::view('apps/calendar', 'apps.calendar')->name('calendar');
Route::view('apps/task-manager-list', 'apps.task-manager-list')->name('task-manager-list');
Route::view('apps/task-manager', 'apps.task-manager')->name('task-manager');
Route::view('apps/toDo', 'apps.toDo')->name('toDo');
Route::view('apps/ecommerce/products', 'apps.ecommerce.products')->name('ecommerce-products');
Route::view('apps/ecommerce/product-details', 'apps.ecommerce.product-details')->name('ecommerce-product-details');
Route::view('apps/ecommerce/cart', 'apps.ecommerce.cart')->name('ecommerce-cart');
Route::view('apps/ecommerce/checkout', 'apps.ecommerce.checkout')->name('ecommerce-checkout');


Route::view('apps/contacts/lists', 'apps.contacts.lists')->name('contacts-lists');
Route::view('apps/contacts/contact-details', 'apps.contacts.contact-details')->name('contact-details');
Route::view('apps/contacts/grid', 'apps.contacts.grid')->name('contacts-grid');
Route::view('apps/contacts/contact-list-table', 'apps.contacts.contact-list-table')->name('contact-list-table');

// forms
Route::view('forms/basic-action-bar', 'forms.basic-action-bar')->name('basic-action-bar');
Route::view('forms/multi-column-forms', 'forms.multi-column-forms')->name('multi-column-forms');
Route::view('forms/smartWizard', 'forms.smartWizard')->name('smartWizard');
Route::view('forms/tagInput', 'forms.tagInput')->name('tagInput');
Route::view('forms/forms-basic', 'forms.forms-basic')->name('forms-basic');
Route::view('forms/form-layouts', 'forms.form-layouts')->name('form-layouts');
Route::view('forms/form-input-group', 'forms.form-input-group')->name('form-input-group');
Route::view('forms/form-validation', 'forms.form-validation')->name('form-validation');
Route::view('forms/form-editor', 'forms.form-editor')->name('form-editor');

// Charts
Route::view('charts/echarts', 'charts.echarts')->name('echarts');
Route::view('charts/chartjs', 'charts.chartjs')->name('chartjs');
Route::view('charts/apexLineCharts', 'charts.apexLineCharts')->name('apexLineCharts');
Route::view('charts/apexAreaCharts', 'charts.apexAreaCharts')->name('apexAreaCharts');
Route::view('charts/apexBarCharts', 'charts.apexBarCharts')->name('apexBarCharts');
Route::view('charts/apexColumnCharts', 'charts.apexColumnCharts')->name('apexColumnCharts');
Route::view('charts/apexRadialBarCharts', 'charts.apexRadialBarCharts')->name('apexRadialBarCharts');
Route::view('charts/apexRadarCharts', 'charts.apexRadarCharts')->name('apexRadarCharts');
Route::view('charts/apexPieDonutCharts', 'charts.apexPieDonutCharts')->name('apexPieDonutCharts');
Route::view('charts/apexSparklineCharts', 'charts.apexSparklineCharts')->name('apexSparklineCharts');
Route::view('charts/apexScatterCharts', 'charts.apexScatterCharts')->name('apexScatterCharts');
Route::view('charts/apexBubbleCharts', 'charts.apexBubbleCharts')->name('apexBubbleCharts');
Route::view('charts/apexCandleStickCharts', 'charts.apexCandleStickCharts')->name('apexCandleStickCharts');
Route::view('charts/apexMixCharts', 'charts.apexMixCharts')->name('apexMixCharts');

// datatables
Route::view('datatables/basic-tables', 'datatables.basic-tables')->name('basic-tables');

// sessions
Route::view('sessions/signIn', 'sessions.signIn')->name('signIn');
Route::view('sessions/signUp', 'sessions.signUp')->name('signUp');
Route::view('sessions/forgot', 'sessions.forgot')->name('forgot');

// widgets
Route::view('widgets/card', 'widgets.card')->name('widget-card');
Route::view('widgets/statistics', 'widgets.statistics')->name('widget-statistics');
Route::view('widgets/list', 'widgets.list')->name('widget-list');
Route::view('widgets/app', 'widgets.app')->name('widget-app');
Route::view('widgets/weather-app', 'widgets.weather-app')->name('widget-weather-app');

// others
Route::view('others/notFound', 'others.notFound')->name('notFound');
Route::view('others/user-profile', 'others.user-profile')->name('user-profile');
Route::view('others/starter', 'starter')->name('starter');
Route::view('others/faq', 'others.faq')->name('faq');
Route::view('others/pricing-table', 'others.pricing-table')->name('pricing-table');
Route::view('others/search-result', 'others.search-result')->name('search-result');



Route::get('/home', 'HomeController@index')->name('home');
