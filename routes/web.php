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

Route::get('/', function () {
    return view('welcome');
});

// Routes pour la gestion des utilisateurs
Route::post('/register', 'UserController@register');
Route::post('/login', 'UserController@login');
Route::post('/manage-roles', 'UserController@manageRoles');

// Routes pour la gestion des produits
Route::post('/products/create', 'ProductController@create');
Route::put('/products/update/{id}', 'ProductController@update');
Route::delete('/products/delete/{id}', 'ProductController@delete');
Route::get('/products', 'ProductController@listProducts');
Route::get('/products/search', 'ProductController@search');

// Routes pour la gestion des commandes
Route::post('/orders/create', 'OrderController@create');
Route::put('/orders/update-status/{id}', 'OrderController@updateStatus');
Route::get('/orders/history', 'OrderController@viewHistory');

// Routes pour la gestion des éléments de commande
Route::post('/order-items/add', 'OrderItemController@add');
Route::put('/order-items/update-quantity/{id}', 'OrderItemController@updateQuantity');
Route::delete('/order-items/delete/{id}', 'OrderItemController@delete');
