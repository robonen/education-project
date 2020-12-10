<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'auth'], function () {
    Route::post('register', 'Auth\RegisterController');
    Route::post('login', 'Auth\LoginController');
    Route::post('logout', 'Auth\LogoutController');
});

Route::apiResource('headteachers', 'Users\HeadTeacherController');

Route::apiResource('teachers', 'Users\TeacherController');
Route::get('teacher/{teacher}/classes', 'Users\TeacherController@getClasses');
Route::get('teacher/{teacher}/classes/{class}/uncheked-task', 'Users\TeacherController@getUncheckedTask');

Route::apiResource('students', 'Users\StudentController');
Route::get('/student/{student}/answers', 'Users\StudentController@getAnswers');

Route::apiResource('parents', 'Users\ParenttController');

Route::apiResource('subjects', 'BankTask\SubjectController');

Route::apiResource('classes', 'SchoolClassController');
Route::post('classes/{class}/teacher', 'SchoolClassController@addTeacher');
Route::get('classes/{class}/students', 'SchoolClassController@getStudents');
Route::get('classes/{class}/subjects', 'SchoolClassController@getSubjects');

Route::apiResource('themes',    'BankTask\ThemeController');

Route::apiResource('timetables', 'TimetableController');

Route::get('banktasks', 'BankTask\BankTaskController@index'); //получение списка всех заданий
Route::group(['prefix' => 'banktask'], function () {
    Route::post('', 'BankTask\BankTaskController@store'); //создание задания
    Route::get('{banktask}', 'BankTask\BankTaskController@show'); //получение задания
    Route::put('{banktask}', 'BankTask\BankTaskController@update'); //обновление задания
    Route::delete('{banktask}', 'BankTask\BankTaskController@delete'); //удаление задания
    Route::post('{banktask}/addfile', 'BankTask\BankTaskFileController@store');
    Route::get('{banktask}/files', 'BankTask\BankTaskFileController@showFiles');
    Route::get('/file/{file}/download', 'BankTask\BankTaskFileController@download');
    Route::delete('/file/{file}/delete', 'BankTask\BankTaskFileController@delete');
    Route::put('/file/{file}/update', 'BankTask\BankTaskFileController@update');
});



Route::group(['prefix' => 'task'], function () {
    Route::post('', 'TaskController@store'); // Добавить таск
    Route::get('', 'TaskController@index'); // Показать задания для класса (в запросе нужно указывать Id класса)
    Route::get('/{task}', 'TaskController@show'); //Показать задание
    Route::put('/{task}', 'TaskController@update'); // Обновить задание
    Route::delete('/{task}', 'TaskController@delete'); // Удалить задание
    Route::put('/answer/check/{answer}', 'TaskController@checkAnswer'); // Проверить ответ ученика
    Route::post('/{task}/addanswer', 'AnswerToTaskController@store'); // Добавить ответ(для ученика)
    Route::get('/{task}/student/{student}', 'AnswerToTaskController@show'); // Показать ответ ученика
    Route::delete('/answer/{answer}', 'AnswerToTaskController@delete'); // Удалить ответ
    Route::put('/answer/{answer}', 'AnswerToTaskController@update'); // Изменить ответ
    Route::post('/{task}/addfile', 'TaskFileController@store'); // Добавить файл
    Route::get('/{task}/files', 'TaskFileController@showFiles'); // Посмотреть файлы у таска(только файлы
                                                                           // которые добавил учитель).
    Route::get('/{task}/file/{file}', 'TaskFileController@download'); // Скачать файл
    Route::delete('/file/{file}', 'TaskFileController@delete'); // Удалить файл
});