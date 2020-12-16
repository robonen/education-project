<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'auth'], function () {
    Route::post('register', 'Auth\RegisterController');
    Route::post('login', 'Auth\LoginController');
    Route::post('logout', 'Auth\LogoutController')->middleware('auth:api');
});

Route::get('users', 'Users\UserController@getUser')->middleware('auth:api');

Route::apiResource('chat/links', 'ChatLinkController')->except(['show'])->middleware('auth:api'); // ссылки чата

Route::apiResource('headteachers', 'Users\HeadTeacherController');

Route::apiResource('teachers', 'Users\TeacherController');//->middleware(['auth:api','role:headteacher|teacher']);
Route::get('teacher/{teacher}/classes', 'Users\TeacherController@getClasses'); //получить классы у которых ведет учитель

Route::apiResource('students', 'Users\StudentController');

Route::apiResource('parents', 'Users\ParenttController');

Route::apiResource('subjects', 'SubjectController');

Route::apiResource('classes', 'SchoolClassController');
Route::post('classes/{class}/teacher', 'SchoolClassController@addTeacher');
Route::get('classes/{class}/students', 'SchoolClassController@getStudents'); //все ученики класса
Route::get('classes/{class}/subjects', 'SchoolClassController@getSubjects'); //все предметы класса

Route::apiResource('themes', 'ThemeController');

Route::apiResource('timetables', 'TimetableController');

Route::get('banktasks', 'BankTaskController@index'); //получение списка всех заданий
Route::group(['prefix' => 'banktask'], function () {
    Route::post('', 'BankTaskController@store'); //создание задания
    Route::get('{banktask}', 'BankTaskController@show'); //получение задания
    Route::put('{banktask}', 'BankTaskController@update'); //обновление задания
    Route::delete('{banktask}', 'BankTaskController@delete'); //удаление задания
    Route::post('{banktask}/addfile', 'BankTaskFileController@store');
    Route::get('{banktask}/files', 'BankTaskFileController@showFiles');
});

Route::get('/file/{file}/download', 'BankTaskFileController@download');
Route::delete('/file/{file}/delete', 'BankTaskFileController@delete');
Route::put('/file/{file}/update', 'BankTaskFileController@update');
