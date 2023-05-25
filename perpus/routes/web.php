<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\MemberController;

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/home/test_spatie', [App\Http\Controllers\HomeController::class, 'test_spatie']);
// Route::get('/transactiondetail', [App\Http\Controllers\TransactionDetailController::class, 'index']);

Route::get('/catalogs', [App\Http\Controllers\CatalogController::class, 'index']);
Route::get('/catalogs/create', [App\Http\Controllers\CatalogController::class, 'create']);
Route::post('/catalogs', [App\Http\Controllers\CatalogController::class, 'store']);
Route::get('/catalogs/{catalog}/edit', [App\Http\Controllers\CatalogController::class, 'edit']);
Route::put('/catalogs/{catalog}', [App\Http\Controllers\CatalogController::class, 'update']);
Route::delete('/catalogs/{catalog}', [App\Http\Controllers\CatalogController::class, 'destroy']);

Route::resource('/books', App\Http\Controllers\BookController::class);
Route::get('api/books', [App\Http\Controllers\BookController::class, 'api']);

Route::resource('/publishers', PublisherController::class);
Route::get('api/publishers', [App\Http\Controllers\PublisherController::class, 'api']);

Route::resource('/authors', AuthorController::class);
Route::get('api/authors', [App\Http\Controllers\AuthorController::class, 'api']);

Route::resource('/members', MemberController::class);
Route::get('api/members', [App\Http\Controllers\MemberController::class, 'api']);

Route::resource('/transactions', App\Http\Controllers\TransactionController::class);
Route::get('api/transactions', [App\Http\Controllers\TransactionController::class, 'api']);
Route::get('cari_tanggal/transactions', [App\Http\Controllers\TransactionController::class, 'cari_tanggal']);
