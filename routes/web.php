<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', [
    'as' => 'home',
    'uses' => 'HomeController@index'
]);

Auth::routes();

Route::get('/home', 'HomeController@index');


Route::get('about', [
    'as' => 'about',
    'uses' => 'AboutController@index'
]);

Route::get('docs', function () {
    return redirect(route('docs.show', [config('docs.default')]));
});

Route::get('docs/{version}/{doc?}', [
    'as' => 'docs.show',
    'uses' => 'DocsController@showDocs'
]);

Route::get('api/{version?}', [
    'as' => 'api.redirect',
    'uses' => function ($version = 'kr') {
        return Redirect::to('https://laravel.com/api/'.$version);
    }
]);
