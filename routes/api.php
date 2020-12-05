<?php

use Illuminate\Http\Request;
/*use Illuminate\Support\Facades\DB;

Encryption keys generated successfully.
Personal access client created successfully.
Client ID: 1
Client secret: PJTXhIJe4YL94kb3uclUtJRJH0tuZywMlmAHbe5o
Password grant client created successfully.
Client ID: 2
Client secret: 3Wst0HOZJQPH6sPThRMruoXeBOuBq2EGuuw6GrZi

DB::listen(function ($query) {
    echo "<code>".$query->sql."</code>";
    echo "<code>".$query->time."</code>";
    // $query->bindings
    // $query->time
});*/


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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::resource('post', 'api\PostController')->only([
    'index', 'show'
]);//->middleware('auth:api');

Route::get('post/{category}/category', 'api\PostController@category');
Route::get('post/{url_clean}/url_clean', 'api\PostController@url_clean');

Route::get('category', 'api\CategoryController@index');
Route::get('category/all', 'api\CategoryController@all');

Route::post('contact','api\ContactController@store');

Route::post('login','api\AuthController@login');
Route::post('logout','api\AuthController@logout')->middleware('auth:api');
Route::get('user','api\AuthController@user')->middleware('auth:api');
