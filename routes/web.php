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
Route::get('/register','Auth\LoginController@showRegisterForm')->name('register');
Route::post('/register', 'UserController@registrarse');

Route::get('/login','Auth\RegisterController@showAtrasForm');


Route::group(['middleware' => ['guest']], function () {
    //Auth::routes();
    //esta ruta es para el login 
    
    
    Route::get('/','Auth\LoginController@showLoginForm');
    // alias login
    Route::post('/login','Auth\LoginController@login')->name('login');
});

    
    Route::group(['middleware' => ['auth']], function () {

    Route::post('/logout','Auth\LoginController@logout')->name('logout');   
    Route::get('/dashboard', 'DashboardController');
    
    Route::get('/main', function () {
        return view('contenido/contenido');
    })->name('main');

    Route::group(['middleware' => ['Usuario']], function () {
        
        // la ruta se establece mediante la pagina y la funcion en este caso articulo
        Route::get('/articulo', 'ArticuloController@index');
        Route::post('/articulo/registrar', 'ArticuloController@store');
        Route::put('/articulo/actualizar', 'ArticuloController@update');
        Route::put('/articulo/desactivar', 'ArticuloController@desactivar');
        Route::put('/articulo/activar', 'ArticuloController@activar');
        Route::get('/articulo/listarPdf', 'ArticuloController@listarPdf')->name('articulos_pdf');

    });

    Route::group(['middleware' => ['Administrador']], function () {
        // la ruta se establece mediante la pagina y la funcion en este caso categoria
        Route::get('/categoria', 'CategoriaController@index');
        Route::post('/categoria/registrar', 'CategoriaController@store');
        Route::put('/categoria/actualizar', 'CategoriaController@update');
        Route::put('/categoria/desactivar', 'CategoriaController@desactivar');
        Route::put('/categoria/activar', 'CategoriaController@activar');
        Route::get('/categoria/selectCategoria', 'CategoriaController@selectCategoria');


        // la ruta se establece mediante la pagina y la funcion en este caso ubicacion
        Route::get('/ubicacion', 'UbicacionController@index');
        Route::post('/ubicacion/registrar', 'UbicacionController@store');
        Route::put('/ubicacion/actualizar', 'UbicacionController@update');
        Route::put('/ubicacion/desactivar', 'UbicacionController@desactivar');
        Route::put('/ubicacion/activar', 'UbicacionController@activar');
        Route::get('/ubicacion/selectUbicacion', 'UbicacionController@selectUbicacion');

        // la ruta se establece mediante la pagina y la funcion en este caso responsable
        Route::get('/responsable', 'ResponsableController@index');
        Route::post('/responsable/registrar', 'ResponsableController@store');
        Route::put('/responsable/actualizar', 'ResponsableController@update');
        Route::put('/responsable/desactivar', 'ResponsableController@desactivar');
        Route::put('/responsable/activar', 'ResponsableController@activar');
        Route::get('/responsable/selectResponsable', 'ResponsableController@selectResponsable');

        // la ruta se establece mediante la pagina y la funcion en este caso articulo
        Route::get('/articulo', 'ArticuloController@index');
        Route::post('/articulo/registrar', 'ArticuloController@store');
        Route::put('/articulo/actualizar', 'ArticuloController@update');
        Route::put('/articulo/desactivar', 'ArticuloController@desactivar');
        Route::put('/articulo/activar', 'ArticuloController@activar');
        Route::get('/articulo/listarPdf', 'ArticuloController@listarPdf')->name('articulos_pdf');

        // la ruta se establece mediante la pagina y la funcion en este caso depreciacion
        Route::get('/depreciacion', 'DepreciacionController@index');
        Route::post('/depreciacion/registrar', 'DepreciacionController@store');

        // la ruta se establece mediante la pagina y la funcion en este caso ubicacion

        Route::get('/rol', 'RolController@index');
        Route::get('/rol/selectRol', 'RolController@selectRol');

        // la ruta se establece mediante la pagina y la funcion en este caso usuarios
        Route::get('/user', 'UserController@index');
        Route::post('/user/registrar', 'UserController@store');
        Route::put('/user/actualizar', 'UserController@update');
        Route::put('/user/desactivar', 'UserController@desactivar');
        Route::put('/user/activar', 'UserController@activar');

        // la ruta se establece mediante la pagina y la funcion en este caso respaldo
        //Route::get('/respaldo', 'RespaldoController@index');
        //Route::get('/respaldo/registrar', 'RespaldoController@backup_database');

        //Route::match(array('GET','POST'),'/respaldo/registrar','RespaldoController@backup_database');
        //Route::post('/respaldo/registrar', 'RespaldoController@index');
        Route::post('/respaldo/registrar', 'RespaldoController@backup_database');
        //Route::post('/respaldo', 'RespaldoController@backup');
        //Route::any('/respaldo/registrar', 'RespaldoController@backup_database');

        // la ruta se establece mediante la pagina y la funcion en este caso respaldo
        Route::get('/auditoria', 'AuditoriaController@index');
        Route::get('/auditoria/listarPdf', 'AuditoriaController@listarPdf')->name('auditorias_pdf');
        Route::get('/auditoria/listarPdf1', 'AuditoriaController@listarPdf1')->name('auditorias_pdf');
        Route::get('/auditoria/listarPdf2', 'AuditoriaController@listarPdf2')->name('auditorias_pdf');
        Route::get('/auditoria/listarPdf3', 'AuditoriaController@listarPdf3')->name('auditorias_pdf');
        Route::get('/auditoria/listarPdf4', 'AuditoriaController@listarPdf4')->name('auditorias_pdf');

        // la ruta se establece mediante la pagina y la funcion en este caso resportes generales
        //Route::get('/reportesgenerales', 'reportesGeneralesController@index');
        Route::get('/articulo/listarPdf', 'ArticuloController@listarPdf')->name('articulos_pdf');
        Route::get('/categoria/listarPdf1', 'reportesGeneralesController@listarPdf1')->name('categorias_pdf');
        Route::get('/ubicacion/listarPdf2', 'reportesGeneralesController@listarPdf2')->name('ubicaciones_pdf');
        Route::get('/responsable/listarPdf3', 'reportesGeneralesController@listarPdf3')->name('responsables_pdf');
        Route::get('/user/listarPdf4', 'reportesGeneralesController@listarPdf4')->name('usuarios_pdf');

        Route::get('/articulo/listarPdf5', 'reportesGeneralesController@listarPdf5')->name('articulo_pdf');
        Route::get('/depreciacion/listarPdf6', 'reportesGeneralesController@listarPdf6')->name('depreciacion_pdf');
        /*Route::get('/', function(){
            $pdf = PDF::loadView('pdf.chart');
            $pdf->setOptions(['isPhpEnabled' => true]);
            //$pdf->setOption('enable-javascript', true); 
            //$pdf->setOption('javascript-delay', 1000); 
            //$pdf->setOption('no-stop-slow-scripts', true); 
            //$pdf->setOption('enable-smart-shrinking', true); 
            $pdf->setPaper('L', 'landscape');
            return $pdf->stream();
        });*/
        


    });

});

//Route::get('/home', 'HomeController@index')->name('home');
