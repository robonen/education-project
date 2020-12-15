<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'auth'], function () {
    Route::post('register', 'Auth\RegisterController');
    Route::post('login', 'Auth\LoginController');
    Route::post('logout', 'Auth\LogoutController');
});

Route::apiResource('headteachers', 'Users\HeadTeacherController');

Route::apiResource('teachers', 'Users\TeacherController');
Route::get('teacher/{teacher}/classes', 'Users\TeacherController@getClasses'); //получить классы у которых ведет учитель

Route::apiResource('students', 'Users\StudentController');

Route::apiResource('parents', 'Users\ParenttController');

Route::apiResource('subjects', 'SubjectController');

Route::apiResource('classes', 'SchoolClassController');
Route::post('classes/{class}/teacher', 'SchoolClassController@addTeacher');
Route::get('classes/{class}/students', 'SchoolClassController@getStudents'); //все ученики класса
Route::get('classes/{class}/journal', 'SchoolClassController@getStudentsJournal'); //все ученики класса с оценками
Route::get('classes/{class}/subjects', 'SchoolClassController@getSubjects'); //все предметы класса

Route::apiResource('journal', 'JournalController');

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
