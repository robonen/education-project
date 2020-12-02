<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', 'RegisterController');
    Route::post('login', 'LoginController');
    Route::post('logout', 'LogoutController');
});

Route::group(['prefix' => 'users'], function () {
    Route::group(['prefix' => 'headteachers'], function () {
        Route::get('', 'HeadTeacherController@index'); //получение списка всех завучей
        Route::get('{headteacher}', 'HeadTeacherController@show'); //получение завуча
        Route::put('{headteacher}', 'HeadTeacherController@update')
            ->middleware('role:headteacher'); //обновление завуча
    });

    Route::group(['prefix' => 'teachers'], function () {
        Route::get('', 'TeacherController@index'); //получение списка всех учителей
        Route::get('{teacher}', 'TeacherController@show'); //получение учителя
        Route::put('{teacher}', 'TeacherController@update')
            ->middleware(['role:headteacher|teacher']); //обновление учителя
    });

    Route::group(['prefix' => 'students'], function () {
        Route::get('', 'StudentController@index'); //получение списка всех учеников
        Route::get('{student}', 'StudentController@show'); //получение ученика
        Route::put('{student}', 'StudentController@update')
            ->middleware(['role:headteacher|teacher|student']); //обновление ученика
    });

    Route::group(['prefix' => 'parents'], function () {
        Route::get('', 'ParenttController@index'); //получение списка всех родителей
        Route::get('{parent}', 'ParenttController@show'); //получение родителя
        Route::put('{parent}', 'ParenttController@update')
            ->middleware(['role:headteacher|teacher|parent']); //обновление родителя
    });
});

Route::group(['prefix' => 'classes', 'middleware' => 'role:headteacher'], function () {
    Route::get('', 'SchoolClassController@index'); //получение списка всех классов
    Route::get('{schoolClass}', 'SchoolClassController@show'); //получение класса
    Route::post('', 'SchoolClassController@store'); //создание класса
    Route::put('{schoolClass}', 'SchoolClassController@update'); //обновление класса
});

Route::group(['prefix' => 'tasks', 'middleware' => 'role:headteacher|teacher'], function () {
    Route::get('', 'TaskController@allTasks');    // Просмотреть все задания(неоптимизированно)
    Route::get('{task}', 'TaskController@showTask'); // Посмотреть задание {id}
    Route::post('', 'TaskController@createTask'); // Добавить новое задание
    Route::put('task}', 'TaskController@editTask'); // Изменить задание {id}
    Route::delete('{task}', 'TaskController@deleteTask'); // Удалить задание {id}
});


//Route::get('headteachers', 'HeadTeacherController@index'); //получение списка всех завучей
//Route::group(['prefix' => 'profile/headteacher'], function () {
//    Route::get('{headteacher}', 'HeadTeacherController@show'); //получение завуча
//    Route::put('{headteacher}', 'HeadTeacherController@update'); //обновление завуча
//});
//
//Route::get('teachers', 'TeacherController@index'); //получение списка всех учителей
//Route::group(['prefix' => 'profile/teacher'], function () {
//    Route::get('{teacher}', 'TeacherController@show'); //получение учителя
//    Route::put('{teacher}', 'TeacherController@update'); //обновление учителя
//});
//
//Route::get('students', 'StudentController@index'); //получение списка всех завучей
//Route::group(['prefix' => 'profile/student'], function () {
//    Route::get('{student}', 'StudentController@show'); //получение завуча
//    Route::put('{student}', 'StudentController@update'); //обновление завуча
//});
//
//Route::get('parents', 'ParenttController@index'); //получение списка всех родителей
//Route::group(['prefix' => 'profile/parent'], function () {
//    Route::get('{parent}', 'ParenttController@show'); //получение родителя
//    Route::put('{parent}', 'ParenttController@update'); //обновление родителя
//});
//
//Route::get('classes', 'SchoolClassController@index'); //получение списка всех классов
//Route::group(['prefix' => 'class'], function () {
//    Route::post('', 'SchoolClassController@store'); //создание класса
//    Route::get('{schoolClass}', 'SchoolClassController@show'); //получение класса
//    Route::put('{schoolClass}', 'SchoolClassController@update'); //обновление класса
//});
