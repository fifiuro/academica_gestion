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
    //return view('inicio');
    return view('auth.login');
});

Route::group(['middleware' => 'auth'], function() {
    /* ACCIONES A LOS CARGOS */
    // Formulario de busqueda de los Cargos
    Route::get('findCargo', 'cargoController@findForm');
    // Resultado de la busqueda de Cargos
    Route::post('findCargo', 'cargoController@findCargo');
    // Formulario de Nuevo Cargo
    Route::get('createCargo', 'cargoController@createForm');
    // Datos del Formulario con el Nuevo Cargo
    Route::post('createCargo', 'cargoController@createCargo');
    // Formulario con los Datos a Modificar
    Route::get('updateCargo/{id}', 'cargoController@updateForm');
    // Datos del Formulario con los datos a modificar de Cargo
    Route::post('updateCargo', 'cargoController@update');
    // Pregunta de eliminacion del Registro Cargo
    Route::get('deleteCargo/{id}', 'cargoController@destroyForm');
    // Eliminar los datos del Cargo
    Route::post('deleteCargo', 'cargoController@destroy');

    /* ACCIONES A LOS DEPARTAMENTOS */
    // Formulario de busqueda de Departamento
    Route::get('findDepartamento','DepartamentoController@index');
    // Resultado de la busqueda de Departamento
    Route::post('findDepartamento','DepartamentoController@show');
    // Formulario de Nuevo Departamento
    Route::get('createDepartamento','DepartamentoController@create');
    // Datos del Formulario con los datos del Nuevo Departamento
    Route::post('storeDepartamento','DepartamentoController@store');
    // Formulario con los Datos a Modificar
    Route::get('editDepartamento/{id}','DepartamentoController@edit');
    // datos del Formulario con los datos a modificar Departamento
    Route::post('updateDepartamento','DepartamentoController@update');
    // Pregunta de eliminacion del registro del Departamento
    Route::get('confirmDepartamento/{id}','DepartamentoController@confirmation');
    // Eliminar los datos del Departamento
    Route::post('destroyDepartamento','DepartamentoController@destroy');

    /* ACCIONES A FERIADOS */
    // Formulario de busqueda de Feriado
    Route::get('findFeriado','FeriadoController@index');
    // Resultado de la busqueda de Feriado
    Route::post('findFeriado','FeriadoController@show');
    // Formulario de Nuevo Feriado
    Route::get('createFeriado','FeriadoController@create');
    // Datos del Formulario con los datos del Nuevo Feriado
    Route::post('storeFeriado','FeriadoController@store');
    // Formulario con los Datos a Modificar
    Route::get('editFeriado/{id}','FeriadoController@edit');
    // datos del Formulario con los datos a modificar Feriado
    Route::post('updateFeriado','FeriadoController@update');
    // Pregunta de eliminacion del registro del Feriado
    Route::get('confirmFeriado/{id}','FeriadoController@confirmation');
    // Eliminar los datos del Feriado
    Route::post('destroyFeriado','FeriadoController@destroy');

    /* ACCIONES A CATEGORIA */
    // Formulario de busqueda de Categoria
    Route::get('findCategoria','CategoriaController@index');
    // Resultado de la busqueda de Categoria
    Route::post('findCategoria','CategoriaController@show');
    // Formulario de Nuevo Categoria
    Route::get('createCategoria','CategoriaController@create');
    // Datos del Formulario con los datos del Nuevo Categoria
    Route::post('storeCategoria','CategoriaController@store');
    // Formulario con los Datos a Modificar
    Route::get('editCategoria/{id}','CategoriaController@edit');
    // datos del Formulario con los datos a modificar Categoria
    Route::post('updateCategoria','CategoriaController@update');
    // Pregunta de eliminacion del registro del Categoria
    Route::get('confirmCategoria/{id}','CategoriaController@confirmation');
    // Eliminar los datos del Categoria
    Route::post('destroyCategoria','CategoriaController@destroy');

    /* ACCIONES AL PERSONAL COGNOS */
    // Formulario de busqueda de Personal
    Route::get('findPersonal','PersonalController@index');
    // Resultado de la busqueda de Personal
    Route::post('findPersonal','PersonalController@show');
    // Formulario de Nuevo Personal
    Route::get('createPersonal','PersonalController@create');
    // Datos del Formulario con los datos del Nuevo Personal
    Route::post('storePersonal','PersonalController@store');
    // Formulario con los Datos a Modificar
    Route::get('editPersonal/{id}','PersonalController@edit');
    // datos del FOrmulario con los datos a modificar Personal
    Route::post('updatePersonal','PersonalController@update');
    // Pregunta de eliminacion del registro del Personal
    Route::get('confirmPersonal/{id}','PersonalController@confirmation');
    // Eliminar los datos del Personal
    Route::post('destroyPersonal','PersonalController@destroy');

    /* ACCIONES A INSTRUCTOR COGNOS */
    // Formulario de busqueda de Instructor
    Route::get('findInstructor','InstructorController@index');
    // Resultado de la busqueda de Instructor
    Route::post('findInstructor','InstructorController@show');
    // Formulario de Nuevo Instructor
    Route::get('createInstructor','InstructorController@create');
    // Datos del Formulario con los datos del Nuevo Instructor
    Route::post('storeInstructor','InstructorController@store');
    // Formulario con los Datos a Modificar
    Route::get('editInstructor/{id}','InstructorController@edit');
    // datos del FOrmulario con los datos a modificar Instructor
    Route::post('updateInstructor','InstructorController@update');
    // Pregunta de eliminacion del registro del Instructor
    Route::get('confirmInstructor/{id}','InstructorController@confirmation');
    // Eliminar los datos del Instructor
    Route::post('destroyInstructor','InstructorController@destroy');

    /* ACCIONES A CURSOS */
    // Formulario de busqueda de Curso
    Route::get('findCurso','CursoController@index');
    // Resultado de la busqueda de Curso
    Route::post('findCurso','CursoController@show');
    // Formulario de Nuevo Curso
    Route::get('createCurso','CursoController@create');
    // Datos del Formulario con los datos del Nuevo Curso
    Route::post('storeCurso','CursoController@store');
    // Formulario con los Datos a Modificar
    Route::get('editCurso/{id}','CursoController@edit');
    // datos del Formulario con los datos a modificar Curso
    Route::post('updateCurso','CursoController@update');
    // Pregunta de eliminacion del registro del Curso
    Route::get('confirmCurso/{id}','CursoController@confirmation');
    // Eliminar los datos del Curso
    Route::post('destroyCurso','CursoController@destroy');

    /* ACCIONES A EMPRESA */
    // Formulario de busqueda de Empresa
    Route::get('findEmpresa','EmpresaController@index');
    // Resultado de la busqueda de Empresa
    Route::post('findEmpresa','EmpresaController@show');
    // Formulario de Nuevo Empresa
    Route::get('createEmpresa','EmpresaController@create');
    // Datos del Formulario con los datos del Nuevo Empresa
    Route::post('storeEmpresa','EmpresaController@store');
    // Formulario con los Datos a Modificar
    Route::get('editEmpresa/{id}','EmpresaController@edit');
    // datos del Formulario con los datos a modificar Empresa
    Route::post('updateEmpresa','EmpresaController@update');
    // Pregunta de eliminacion del registro del Empresa
    Route::get('confirmEmpresa/{id}','EmpresaController@confirmation');
    // Eliminar los datos del Empresa
    Route::post('destroyEmpresa','EmpresaController@destroy');
    /* ACCIONES  */

    /* ACCIONES A USUARIO */
    // Formulario de busqueda de Usuario
    Route::get('findUsuario','UsuarioController@index');
    // Resultado de la busqueda de Usuario
    Route::post('findUsuario','UsuarioController@show');
    // Formulario de Nuevo Usuario
    Route::get('createUsuario/{id}','UsuarioController@create');
    // Datos del Formulario con los datos del Nuevo Usuario
    Route::post('storeUsuario','UsuarioController@store');
    // Formulario con los Datos a Modificar
    Route::get('editUsuario/{id}','UsuarioController@edit');
    // datos del Formulario con los datos a modificar Usuario
    Route::post('updateUsuario','UsuarioController@update');
    // Pregunta de eliminacion del registro del Usuario
    Route::get('confirmUsuario/{id}','UsuarioController@confirmation');
    // Eliminar los datos del Usuario
    Route::post('destroyUsuario','UsuarioController@destroy');
    /* ACCIONES  */
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
