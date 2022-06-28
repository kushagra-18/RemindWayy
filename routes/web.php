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
    return view('auth.login');
});

Auth::routes();


Route::group(['middleware' => ['auth']], function () { 

Route::get('/home', 'ReminderController@index')->name('home');

Route::post('/reminder', 'ReminderController@saveReminder')->name('reminder');

Route::get('/reminder', 'ReminderController@getReminders')->name('reminders');
Route::get('/reminder/upcoming', 'ReminderController@getUpcomingReminders')->name('upcomingreminders');

Route::delete('/reminder', 'ReminderController@deleteReminder')->name('deleteReminder');

Route::post('/add-phone', 'ReminderController@addPhoneNumber')->name('addPhone');

});

