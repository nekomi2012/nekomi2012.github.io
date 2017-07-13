<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/ru', ['as' => 'ru', 'uses' => 'PagesController@ru']);
Route::get('/en', ['as' => 'en', 'uses' => 'PagesController@index']);
Route::get('/', ['as' => 'index', 'uses' => 'PagesController@index']);
Route::get('/success', ['as' => 'success', 'uses' => 'PagesController@success']);
Route::get('/login', ['as' => 'login', 'uses' => 'LoginController@vklogin']);
Route::post('/api/free-money', ['as' => 'free', 'uses' => 'PagesController@addbonus']);
Route::post('/api/generateGame', ['as' => 'game', 'uses' => 'PagesController@generateGame']);
Route::post('/api/checkGame', ['as' => 'gamecheck', 'uses' => 'PagesController@checkGame']);
Route::post('/api/takebet', ['as' => 'gameget', 'uses' => 'PagesController@takebet']);
Route::post('/api/getBalance', ['as' => 'getBalance', 'uses' => 'PagesController@getBalance']);
Route::post('/api/stats', ['as' => 'getStats', 'uses' => 'PagesController@getStats']);
Route::post('/api/getHistory', ['as' => 'getHistory', 'uses' => 'PagesController@getHistory']);
Route::post('/api/getHistoryUser', ['as' => 'getHistoryUser', 'uses' => 'PagesController@getHistoryUser']);
Route::post('/api/getTopUser', ['as' => 'getTopUser', 'uses' => 'PagesController@getTopUser']);
Route::post('/api/getTopUserWeg', ['as' => 'getTopUserWeg', 'uses' => 'PagesController@getTopUserWeg']);
Route::post('/api/getBig', ['as' => 'getBig', 'uses' => 'PagesController@getBig']);
Route::post('/api/vivod', ['as' => 'vivod', 'uses' => 'PagesController@vivod']);
Route::post('/vivod/{price}/{koshelek}', 'PagesController@vivod');
Route::post('/pay', 'PagesController@pay');
Route::post('/getPayment', 'PagesController@getPayment');
Route::post('/support', 'SupportController@support');
Route::post('/api/last_drop_jet', 'PagesController@last_drop_jet');
Route::post('/api/last_jet_get', 'PagesController@last_jet_get');

Route::group(['middleware' => 'admin', 'middleware' => 'access:admin', 'prefix' => 'admin'], function () {
    Route::get('/', 'AdminController@index');
    Route::get('/addCase', 'AdminController@addCase');
    Route::post('/addCase', 'AdminController@addCasePost');
    Route::get('/addItem', 'AdminController@addItem');
    Route::post('/addItem', 'AdminController@addItemPost');
    Route::get('/lastvvod', 'AdminController@lastvvod');
    Route::get('/lastvivod', 'AdminController@vivod');
    Route::get('/vivodgifts', 'AdminController@vivodgifts');
    Route::get('/users', 'AdminController@users');
    Route::get('/cases', 'AdminController@cases');
    Route::get('/tickets', 'AdminController@tickets');
    Route::get('/cases/{id}', ['as' => 'cases', 'uses' => 'AdminController@caseid']);
    Route::get('/ticket/{id}', ['as' => 'ticket', 'uses' => 'AdminController@ticket']);
    Route::post('/ticketsave', ['as' => 'ticket', 'uses' => 'AdminController@ticketsave']);
    Route::post('/casedit', ['as' => 'case', 'uses' => 'AdminController@casedit']);
    Route::get('/searchusers', ['as' => 'search', 'uses' => 'AdminController@search2']);
    Route::get('/searchusersname', ['as' => 'search', 'uses' => 'AdminController@searchusersname']);
    Route::get('/user/{id}', ['as' => 'users', 'uses' => 'AdminController@userid']);
    Route::post('/userdit', ['as' => 'user', 'uses' => 'AdminController@userdit']);
  Route::match(['get', 'post'], '/givemoney/{id}', ['as' => 'givemoney', 'uses' => 'AdminController@givemoney']);
    Route::get('/vivodclose/{id}', 'AdminController@close');
    Route::get('/vivodclosegift/{id}', 'AdminController@closegift');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/logout', 'LoginController@logout');
    Route::get('/support', ['as' => 'support.index', 'uses' => 'SupportController@support']);
    Route::get('/support/{ticket}', ['as' => 'ticket', 'uses' => 'SupportController@ticket']);
    Route::post('/support/{ticket}', ['as' => 'ticket', 'uses' => 'SupportController@ticket']);

    Route::get('/ru/support', ['as' => 'support.index', 'uses' => 'SupportController@support']);
    Route::get('/ru/support/{ticket}', ['as' => 'ticket', 'uses' => 'SupportController@ticket']);
    Route::post('/ru/support/{ticket}', ['as' => 'ticket', 'uses' => 'SupportController@ticket']);

    Route::get('/en/support', ['as' => 'support.index', 'uses' => 'SupportController@support']);
    Route::get('/en/support/{ticket}', ['as' => 'ticket', 'uses' => 'SupportController@ticket']);
    Route::post('/en/support/{ticket}', ['as' => 'ticket', 'uses' => 'SupportController@ticket']);
});
