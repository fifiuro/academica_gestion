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
    Route::get('/home', 'HomeController@index')->name('home');
    
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

    /* ACCIONES A AULA */
    // Formulario de busqueda de Aula
    Route::get('findAula','AulaController@index');
    // Resultado de la busqueda de Aula
    Route::post('findAula','AulaController@show');
    // Formulario de Nuevo Aula
    Route::get('createAula','AulaController@create');
    // Datos del Formulario con los datos del Nuevo Aula
    Route::post('storeAula','AulaController@store');
    // Formulario con los Datos a Modificar del Aula
    Route::get('editAula/{id}','AulaController@edit');
    // datos del Formulario con los datos a modificar Aula
    Route::post('updateAula','AulaController@update');
    // Pregunta de eliminacion del registro del Aula
    Route::get('confirmAula/{id}','AulaController@confirmation');
    // Eliminar los datos del Aula
    Route::post('destroyAula','AulaController@destroy');

    /* ACCIONES A TIPO PAGO */
    // Formulario de busqueda de Pago
    Route::get('findPago','PagoController@index');
    // Resultado de la busqueda de Pago
    Route::post('findPago','PagoController@show');
    // Formulario de Nuevo Pago
    Route::get('createPago','PagoController@create');
    // Datos del Formulario con los datos del Nuevo Pago
    Route::post('storePago','PagoController@store');
    // Formulario con los Datos a Modificar del Pago
    Route::get('editPago/{id}','PagoController@edit');
    // datos del Formulario con los datos a modificar Pago
    Route::post('updatePago','PagoController@update');
    // Pregunta de eliminacion del registro del Pago
    Route::get('confirmPago/{id}','PagoController@confirmation');
    // Eliminar los datos del Pago
    Route::post('destroyPago','PagoController@destroy');
    /* ACCIONES */

    /* ACCIONES A DOCUMENTOS RESPALDO */
    // Formulario de busqueda de Documento
    Route::get('findDocumento','DocumentoController@index');
    // Resultado de la busqueda de Documento
    Route::post('findDocumento','DocumentoController@show');
    // Formulario de Nuevo Documento
    Route::get('createDocumento','DocumentoController@create');
    // Datos del Formulario con los datos del Nuevo Documento
    Route::post('storeDocumento','DocumentoController@store');
    // Formulario con los Datos a Modificar del Documento
    Route::get('editDocumento/{id}','DocumentoController@edit');
    // datos del Formulario con los datos a modificar Documento
    Route::post('updateDocumento','DocumentoController@update');
    // Pregunta de eliminacion del registro del Documento
    Route::get('confirmDocumento/{id}','DocumentoController@confirmation');
    // Eliminar los datos del Documento
    Route::post('destroyDocumento','DocumentoController@destroy');
    /* ACCIONES */

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

    /* ACCIONES A CRONOGRAMA */
    // Formulario de busqueda de Cronograma
    Route::get('findCronograma','CronogramaController@index');
    // Resultado de la busqueda de Cronograma
    Route::post('findCronograma','CronogramaController@show');
    // Formulario de Nuevo Cronograma
    Route::get('createCronograma','CronogramaController@create');
    // Datos del Formulario con los datos del Nuevo Cronograma
    Route::post('storeCronograma','CronogramaController@store');
    // Formulario con los Datos a Modificar
    Route::get('editCronograma/{id}','CronogramaController@edit');
    // datos del Formulario con los datos a modificar Cronograma
    Route::post('updateCronograma','CronogramaController@update');
    // Pregunta de eliminacion del registro del Cronograma
    Route::get('confirmCronograma/{id}','CronogramaController@confirmation');
    // Eliminar los datos del Cronograma
    Route::post('destroyCronograma','CronogramaController@destroy');
    /* ACCIONES  */

    /* ACCIONES A INICIO */
    // Formulario de busqueda de Inicio
    Route::get('findInicio','InicioController@index');
    // Resultado de la busqueda de Inicio
    Route::post('findInicio','InicioController@show');
    // Formulario de Nuevo Inicio
    Route::get('createInicio/{id}','InicioController@create');
    // Datos del Formulario con los datos del Nuevo Inicio
    Route::post('storeInicio','InicioController@store');
    // Formulario con los Datos a Modificar
    Route::get('editInicio/{id}','InicioController@edit');
    // datos del Formulario con los datos a modificar Inicio
    Route::post('updateInicio','InicioController@update');
    // Pregunta de eliminacion del registro del Inicio
    Route::get('confirmInicio/{id}','InicioController@confirmation');
    // Eliminar los datos del Inicio
    Route::post('destroyInicio','InicioController@destroy');
    /* ACCIONES  */

    /* ACCIONES A ALUMNO */
    // Formulario de busqueda de Alumno
    Route::get('findAlumno','AlumnoController@index');
    // Resultado de la busqueda de Alumno
    Route::post('findAlumno','AlumnoController@show');
    // Formulario de Nuevo Alumno
    Route::get('createAlumno','AlumnoController@create');
    // Datos del Formulario con los datos del Nuevo Alumno
    Route::post('storeAlumno','AlumnoController@store');
    // Formulario con los Datos a Modificar
    Route::get('editAlumno/{id}','AlumnoController@edit');
    // datos del Formulario con los datos a modificar
    Route::post('updateAlumno','AlumnoController@update');
    // Pregunta de eliminacion del registro del Alumno
    Route::get('confirmAlumno/{id}','AlumnoController@confirmation');
    // Eliminar los datos del Alumno
    Route::post('destroyAlumno','AlumnoController@destroy');
    // Agregar un Alumno de Curso a una persona existente
    Route::post('addAlumno','AlumnoController@addAlumno');
    // Eliminar todos los Alumnoes de curso de una persona
    Route::get('allDestroyAlumno/{id}','AlumnoController@allDestroyAlumno');
    // Otro para buscar Alumno como tambien Interesado
    Route::post('findAluInt','AlumnoController@findAluInt');
    /* ACCIONES  */

    /* ACCIONES A INTERES */
    // Formulario de busqueda de Interes
    Route::get('findInteres','InteresController@index');
    // Resultado de la busqueda de Interes
    Route::post('findInteres','InteresController@show');
    // Formulario de Nuevo Interes
    Route::get('createInteres','InteresController@create');
    // Datos del Formulario con los datos del Nuevo Interes
    Route::post('storeInteres','InteresController@store');
    // Formulario con los Datos a Modificar
    Route::get('editInteres/{id}','InteresController@edit');
    // Pregunta de eliminacion del registro del Interes
    Route::get('confirmInteres/{id}/{pe}','InteresController@confirmation');
    // Eliminar los datos del Interes
    Route::post('destroyInteres','InteresController@destroy');
    // Agregar un Interese de Curso a una persona existente
    Route::post('addInteres','InteresController@addInteres');
    // Eliminar todos los Intereses de curso de una persona
    Route::get('allDestroyInteres/{id}','InteresController@allDestroyInteres');
    /* ACCIONES  */

    /* ACCIONES A INSCRIPCION */
    // Formulario de busqueda de Inscripcion
    Route::get('findInscripcion','InscripcionController@index');
    // Resultado de la busqueda de Inscripcion
    Route::post('findInscripcion','InscripcionController@show');
    // Formulario de Nuevo Inscripcion
    Route::get('createInscripcion/{id}','InscripcionController@create');
    // Datos del Formulario con los datos del Nuevo Inscripcion
    Route::post('storeInscripcion','InscripcionController@store');
    // Formulario con los Datos a Modificar
    Route::get('editInscripcion/{id}','InscripcionController@edit');
    // Pregunta de eliminacion del registro del Inscripcion
    Route::post('updateInscripcion','InscripcionController@update');
    // Pregunta de eliminacion del registro del Inicio
    Route::get('confirmInscripcion/{id}','InscripcionController@confirmation');
    // Eliminar los datos del Inscripcion
    Route::post('destroyInscripcion','InscripcionController@destroy');
    // Agregar un Inscripcione de Curso a una persona existente
    Route::post('addInscripcion','InscripcionController@addInscripcion');
    // Eliminar todos los Inscripciones de curso de una persona
    Route::get('allDestroyInscripcion/{id}','InscripcionController@allDestroyInscripcion');
    /* ACCIONES  */

    /** ACCIONES A MALLA DE CURSOS */
    // Malla de cursos Lunes a Viernes
    Route::get('mallaLunesViernes','MallaController@mallaLunesViernes');
    // Malla de cursos Sábados
    Route::get('mallaSabados','MallaController@mallaSabados');
    // Malla de cursos Sitio
    Route::get('mallaSitio','MallaController@mallaSitio');
    /** ACCIONES  */

    /** ACCIONES A ASISTENCIA */
    // Formulario de busqueda de Asistencia
    Route::get('findAsistencia','AsistenciaController@index');
    // Resultado de la busqueda de Asistencia
    Route::post('findAsistencia','AsistenciaController@show');
    
    // Formulario de Nuevo Asistencia
    Route::get('createAsistencia/{id}','AsistenciaController@create');
    // Datos del Formulario con los datos del Nuevo Asistencia
    Route::post('storeAsistencia','AsistenciaController@store');
    // Formulario con los Datos a Modificar
    Route::get('editAsistencia/{id}','AsistenciaController@edit');
    // Pregunta de eliminacion del registro del Asistencia
    Route::post('updateAsistencia','AsistenciaController@update');
    // Pregunta de eliminacion del registro del Asistencia
    Route::get('confirmAsistencia/{id}','AsistenciaController@confirmation');
    // Eliminar los datos del Asistencia
    Route::post('destroyAsistencia','AsistenciaController@destroy');
    // Agregar un Asistencia de Curso a una persona existente
    Route::post('addAsistencia','AsistenciaController@addAsistencia');
    // Eliminar todos los Asistencia de curso de una persona
    Route::get('allDestroyAsistencia/{id}','AsistenciaController@allDestroyAsistencia');
    /** ACCIONES */

});

Auth::routes();

