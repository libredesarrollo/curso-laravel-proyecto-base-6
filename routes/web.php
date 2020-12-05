<?php

use Illuminate\Support\Facades\Http;
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

 Route::get('request', function () {

    //$response = Http::get('https://jsonplaceholder.typicode.com/todos/1');

    /*
    ************Fake Callback
    Http::fake(
        [
            'jsonplaceholder.*' => Http::response("Hola mundo",200)
        ]
    );
    
    $response = Http::post('https://jsonplaceholdsser.typicode.com/posts',[
        'user_id' => 101,
        'name' => 'Andrés'
    ]);
    
    */

   /* 
   ************Inspecting Requests
   Http::fake();

    $response = Http::post('https://jsonplaceholdsser.typicode.com/posts',[
        'user_id' => 101,
        'name' => 'Andrés'
    ]);

    Http::assertSent(function ($request) {

        dd($request);

        return 
               $request['name'] !== 'Andrés';
    });*/

    //$response->throw();


    $response = Http::timeout(3)->delete('https://jsonplaceholder.typicode.com/posts/1',[
        'user_id' => 101,
        'name' => 'Andrés'
    ]);

    dd($response->body());
     
    return "request";
 });

Route::get('/test', function () {

    $string = "  Hola mundo Andrés  ";
    //$string =  str_replace(" ","-",strtolower(trim($string)));

   /* $string = Str::of($string)
                ->afterLast("o")
                ->ascii();*/

    $string = Str::of($string)
                ->trim()
                ->lower()
                ->replace(" ","-")
                ->ascii()
                ;

   // dd($string);

    return $string;
});

Route::get('/hola/{nombre?}', function ($nombre = "Juan") {
    return "Hola $nombre";
});

/*
Route::get('/sobre-nosotros-en-la-web', function () {
return "<h1>Toda la información sobre nosotros!</h1>";
})->name("nosotros");

Route::get('home/{nombre?}/{apellido?}', function ($nombre = "Pepe",$apellido = "Cruz") {

$posts = ["Posts1","Posts2","Posts3","Posts4"];
$posts2 = null;

//return view("home")->with("nombre",$nombre)->with("apellido",$apellido);
return view("home",['nombre' => $nombre,'apellido' => "Mujica",'posts' => $posts,'posts2' => $posts2]);
})->name("home");*/

//Route::resource('dashboard/post', 'dashboard\PostController');

// imagenes post
Route::post('dashboard/post/{post}/image', 'dashboard\PostController@image')->name('post.image');
Route::get('dashboard/post/image-download/{image}', 'dashboard\PostController@imageDownload')->name('post.image-download');
Route::delete('dashboard/post/image-delete/{image}', 'dashboard\PostController@imageDelete')->name('post.image-delete');
Route::post('dashboard/post/content_image', 'dashboard\PostController@contentImage');

Route::resource('dashboard/category', 'dashboard\CategoryController');
Route::resource('dashboard/user', 'dashboard\UserController');
Route::resource('dashboard/contact', 'dashboard\ContactController')->only([
    'index', 'show', 'destroy',
]);
Route::resource('dashboard/post-comment', 'dashboard\PostCommentController')->only([
    'index', 'show', 'destroy',
]);
Route::get('dashboard/post-comment/{post}/post', 'dashboard\PostCommentController@post')->name('post-comment.post');
Route::get('dashboard/post-comment/j-show/{postComment}', 'dashboard\PostCommentController@jshow');
Route::post('dashboard/post-comment/proccess/{postComment}', 'dashboard\PostCommentController@proccess');

Route::get('/', 'web\WebController@index')->name('index');
Route::get('/categories', 'web\WebController@index')->name('index');

Route::get('/detail/{id}', 'web\WebController@detail');
Route::get('/post-category/{id}', 'web\WebController@post_category');

Route::get('/dashboard/excel/post-export', 'dashboard\PostController@export')->name('post.export');
Route::get('/dashboard/excel/post-import', 'dashboard\PostController@import');

Route::get('/contact', 'web\WebController@contact')->name('contact');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');//->middleware('check_age:19');

// paquetes
Route::get('/chart', 'PaquetesController@charts')->name('chart');
Route::get('/image', 'PaquetesController@image')->name('image');
Route::get('/qr_qenerate', 'PaquetesController@qr_qenerate')->name('qr_qenerate');
Route::get('/translate', 'PaquetesController@translate')->name('translate');
Route::get('/stripe_create_customer', 'PaquetesController@stripe_create_customer')->name('stripe_create_customer');
Route::get('/stripe_payment_method_register', 'PaquetesController@stripe_payment_method_register')->name('stripe_payment_method_register');
Route::get('/stripe_payment_method_create', 'PaquetesController@stripe_payment_method_create')->name('stripe_payment_method_create');
Route::get('/stripe_payment_method', 'PaquetesController@stripe_payment_method')->name('stripe_payment_method');
Route::get('/stripe_create_only_pay_form', 'PaquetesController@stripe_create_only_pay_form')->name('stripe_create_only_pay_form');
Route::get('/stripe_create_only_pay', 'PaquetesController@stripe_create_only_pay')->name('stripe_create_only_pay');
Route::get('/stripe_create_suscription', 'PaquetesController@stripe_create_suscription')->name('stripe_create_suscription');

Route::post('/login2', 'auth\LoginController@authenticate');

/*
Sociales
*/

Route::get('login/social/{provider}','Auth\LoginController@redirectToProvider')->name('sociallogin');
Route::get('login/social/callback/{provider}','Auth\LoginController@handleProviderCallback');



















//Route::resource('dashboard/post', 'dashboard\PostController');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('dashboard/post',App\Http\Controllers\dashboard\PostController::class);