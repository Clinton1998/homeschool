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

Route::get('/', function () {
    return view('dashboard.dashboardv2');
});
//rutas para la autenticacion del usuario
Auth::routes();

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
Route::post('super/docente/cambiarfoto', 'usuario\super\Docente@cambiar_foto')->name('super/docente/cambiarfoto');
Route::get('super/docente/foto/{fileName}', 'usuario\super\Docente@foto')->name('super/docente/foto/{fileName}');
Route::post('super/docente/cambiarcontrasena', 'usuario\super\Docente@cambiar_contrasena')->name('super/docente/cambiarcontrasena');
Route::post('super/docente/eliminar', 'usuario\super\Docente@eliminar')->name('super/docente/eliminar');


Route::get('super/alumnos','usuario\super\Alumno@index')->name('super/alumnos');
Route::get('super/alumno/{id_alumno}', 'usuario\super\Alumno@info')->name('super/alumno/{id_alumno}');
Route::post('super/alumno/agregar', 'usuario\super\Alumno@agregar')->name('super/alumno/agregar');
Route::get('super/alumno/foto/{fileName}', 'usuario\super\Alumno@foto')->name('super/alumno/foto/{fileName}');
Route::post('super/alumno/cambiarfoto', 'usuario\super\Alumno@cambiar_foto')->name('super/alumno/cambiarfoto');
Route::post('super/alumno/cambiarcontrasena', 'usuario\super\Alumno@cambiar_contrasena')->name('super/alumno/cambiarcontrasena');
Route::post('super/alumno/actualizar', 'usuario\super\Alumno@actualizar')->name('super/alumno/actualizar');
Route::post('super/alumno/actualizarrepresentante', 'usuario\super\Alumno@actualizar_representante')->name('super/alumno/actualizarrepresentante');
Route::post('super/alumno/eliminar', 'usuario\super\Alumno@eliminar')->name('super/alumno/eliminar');

Route::get('super/grados', 'usuario\super\Grado@index')->name('super/grados');
Route::post('super/grados/agregar', 'usuario\super\Grado@agregar')->name('super/grados/agregar');
Route::post('super/grados/actualizar', 'usuario\super\Grado@actualizar')->name('super/grados/actualizar');
Route::post('super/grados/aplicar', 'usuario\super\Grado@aplicar')->name('super/grados/aplicar');
Route::post('super/grados/eliminar', 'usuario\super\Grado@eliminar')->name('super/grados/eliminar');

Route::get('super/secciones', 'usuario\super\Seccion@index')->name('super/secciones');
Route::post('super/secciones/agregar', 'usuario\super\Seccion@agregar')->name('super/secciones/agregar');
Route::post('super/secciones/actualizar', 'usuario\super\Seccion@actualizar')->name('super/secciones/actualizar');
Route::post('super/secciones/eliminar', 'usuario\super\Seccion@eliminar')->name('super/secciones/eliminar');

Route::get('super/categorias', 'usuario\super\Categoria@index')->name('super/categorias');
Route::post('super/categorias/agregar', 'usuario\super\Categoria@agregar')->name('super/categorias/agregar');
Route::post('super/categorias/actualizar', 'usuario\super\Categoria@actualizar')->name('super/categorias/actualizar');
Route::post('super/categorias/aplicar', 'usuario\super\Categoria@aplicar')->name('super/categorias/aplicar');
Route::post('super/categorias/eliminar', 'usuario\super\Categoria@eliminar')->name('super/categorias/eliminar');
Route::post('super/categorias/quitarcategoria', 'usuario\super\Categoria@quitar_categoria')->name('super/categorias/quitarcategoria');
Route::post('super/categorias/aplicarseccion', 'usuario\super\Seccion@aplicar')->name('super/categorias/aplicarseccion');
Route::post('super/categorias/agregarcategoriaaseccion', 'usuario\super\Seccion@agregar_categoria')->name('super/categorias/agregarcategoriaaseccion');

//rutas para el alumno
Route::get('alumno/calendario', 'usuario\alumno\Calendario@index')->name('alumno/calendario');
Route::get('alumno/tareas', 'usuario\alumno\Tarea@index')->name('alumno/tareas');
Route::get('alumno/docentes', 'usuario\alumno\Docente@index')->name('alumno/docentes');
Route::get('alumno/companieros', 'usuario\alumno\Companiero@index')->name('alumno/companieros');

Route::post('docente/docente/aplicar','usuario\docente\Docente@aplicar')->name('docente/docente/aplicar');
Route::post('docente/docente/buscar','usuario\docente\Docente@buscar')->name('docente/docente/buscar');
Route::post('docente/docente/alumnoscategorias','usuario\docente\AsignarTareas@alumnos_categorias')->name('docente/docente/alumnoscategorias');
Route::post('docente/tarea/registrar','usuario\docente\AsignarTareas@asignar')->name('docente/tarea/registrar');
Route::post('docente/tarea/aplicar','usuario\docente\Tarea@aplicar')->name('docente/tarea/aplicar');
Route::post('docente/tarea/respuesta','usuario\docente\Tarea@respuesta')->name('docente/tarea/respuesta');
Route::post('docente/tarea/calificarrespuesta','usuario\docente\Tarea@calificar_respuesta')->name('docente/tarea/calificarrespuesta');

Route::post('docente/alumno/aplicar','usuario\docente\Alumno@aplicar')->name('docente/alumno/aplicar');

// RUTAS PARA EL DOCENTE
Route::get('docente/docentes', 'usuario\docente\Docente@index')->name('docente/docente');
Route::get('docente/alumnos', 'usuario\docente\Alumno@index')->name('docente/alumno');
Route::get('docente/asignartareas', 'usuario\docente\AsignarTareas@index')->name('docente/asignartareas');
Route::get('docente/estadotareas', 'usuario\docente\EstadoTareas@index')->name('docente/estadotareas');

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
