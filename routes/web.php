<?php

use App\Http\Controllers\DocsController;
use App\Http\Controllers\HomeController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('home', [HomeController::class, 'index']);

Route::get('docs', function () {
    return redirect(route('docs.show', [config('docs.default')]));
});

Route::get('docs/{version}/{doc?}', [DocsController::class, 'showDocs'])->name('docs.show');

Route::get('api/{version?}', [
    'as' => 'api.redirect',
    'uses' => function ($version = 'kr') {
        return Redirect::to('https://laravel.com/api/'.$version);
    }
]);
