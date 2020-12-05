<?php

namespace App\Http\Controllers\dashboard;

use App\Tag;
use App\Post;
use App\Category;
use App\PostImage;
use App\Jobs\SendEmail;
use App\Helpers\CustomUrl;
use App\Exports\PostsExport;
use App\Imports\PostsImport;
use Illuminate\Http\Request;
use App\Jobs\ProcessImageSmall;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostPost;
use App\Http\Requests\UpdatePostPut;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Armancodes\DownloadLink\Facades\DownloadLinkGenerator;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('rol.admin');
    }

    public function export(){
        return Excel::download(new PostsExport, 'posts.xlsx');
    }

    public function import(){

        Excel::import(new PostsImport, 'posts.xlsx');

        return "Importado!";
    }

    public function index(Request $request)
    {

        Log::error('Error para el usuario ',['id' => 5]); //::channel('stack')

        // Enlaces de descarga
        
        /*Storage::fake('local')->put('example.txt','Hola Mundo');
        Storage::disk('local')->put('example.txt','Hola Mundo');
        $link = DownloadLinkGenerator::disk('local')->filePath('example.txt')->generate();
        echo $link;*/



        //SendEmail::dispatch('andres@hotmail.com','Email enviado por colas');

        // $this->sendMail();

        /*
         **************PRUEBAS TRANSACCIONES

        DB::transaction(function () {

        DB::table('contacts')
        ->where(["id" => 6])
        ->delete();

        $contact = DB::select('select * from contacts where id = ?', [50]);
        dd($contact[0]);

        DB::table('contacts')
        ->where(["id" => 2])
        ->update(['name' => "Pepito"]);
        });*/

        /* DB::beginTransaction();
        DB::table('contacts')
        ->where(["id" => 7])
        ->delete();

        DB::table('contacts')
        ->where(["id" => 20])
        ->update(['name' => "Pepito"]);

        // $contact = DB::select('select * from contacts where id = ?', [50]);
        //dd($contact[0]);
        DB::commit();*/

        /*
         **************PRUEBAS COLECCIONES

        $personas = [
        ["nombre" => "usuario 1", "edad" => 50],
        ["nombre" => "usuario 2", "edad" => 70],
        ["nombre" => "usuario 3", "edad" => 10],
        ];

        //dd($personas);

        //dd(Category::all());

        $collection1 = collect($personas);
        //dd($collection1);
        $collection2 = new Collection($personas);
        //dd($collection2);
        $collection3 = Collection::make($personas);
        //dd($collection3);

        dd($collection2->filter(function($value,$key){
        return $value['edad'] > 17;
        })
        ->sum('edad'));

        $personas = ["usuario 1","usuario 2","usuario 3","usuario 1","usuario 4"];

        $collection = collect($personas);

        dd((bool) $collection->intersect(['usuario 5'])->count());*/

        // select * from posts
        $posts = Post::with('category')
            ->orderBy('created_at', request('created_at', 'DESC'));

        if ($request->has('search')) {
            $posts = $posts->where('title', 'like', '%' . request('search') . '%');
        }

        $posts = $posts->paginate(10);

        return view('dashboard.post.index', ['posts' => $posts]);
    }

    private function sendMail()
    {

        $data['title'] = "Datos de prueba";

        Mail::send('emails.email', $data, function ($message) {
            $message->to('andres@gmail.com', 'Pepito')
                ->subject("Gracias por escribirnos");
        });

        dd(Mail::failures());

        if (Mail::failures()) {
            return "Mensaje no enviado";
        } else {
            return "Mensaje enviado";
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::pluck('id', 'title');
        $categories = Category::pluck('id', 'title');
        $post = new Post();
        return view('dashboard.post.create', compact('post', 'categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostPost $request)
    {

        // $request->validate([
        //     'title' => 'required|min:5|max:500',
        //     //'url_clean' => 'required|min:5|max:500'
        //     'content' => 'required|min:5'
        // ]);

        if ($request->url_clean == "") {
            $urlClean = CustomUrl::urlTitle(CustomUrl::convertAccentedCharacters($request->title), '-', true);
        } else {
            $urlClean = CustomUrl::urlTitle(CustomUrl::convertAccentedCharacters($request->url_clean), '-', true);
        }
        $requestData = $request->validated();
        $requestData['url_clean'] = $urlClean;

        $validator = Validator::make($requestData, StorePostPost::myRules());

        if ($validator->fails()) {
            return redirect('dashboard/post/create')
                ->withErrors($validator)
                ->withInput();
        }

        $post = Post::create($requestData);

        $post->tags()->sync($request->tags_id);

        return back()->with('status', 'Post creado con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //  $post = Post::findOrFail($id);
        return view('dashboard.post.show', ["post" => $post]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {

        //dd($post->tags->pluck("id"));
        $tag = Tag::find(1);
        $tags = Tag::pluck('id', 'title');
        //dd($tag->posts);

        //dd(old('tags_id'));

        // dd(PostImage::create(['image'=> "aaa", 'post_id'=> 11]));
        //  dd($post->image->image);
        $categories = Category::pluck('id', 'title');
        return view('dashboard.post.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostPut $request, Post $post)
    {

        // dd($request->tags_id);

        //$post->tags()->attach(1);
        
        $post->tags()->sync($request->tags_id);

        $post->update($request->validated());
        //return redirect("/dashboard/post");//->route("post.index");
        return back()->with('status', 'Post actualizado con exito');
    }

    public function image(Request $request, Post $post)
    {
        $request->validate([
            'image' => 'required|mimes:jpeg,bmp,png|max:10240', //10Mb
        ]);

        $filename = time() . "." . $request->image->extension();

        $request->image->move(public_path('images'), $filename);

        //$path = $request->image->store('public/images');

        $image = PostImage::create(['image' => /*$path*/ $filename, 'post_id' => $post->id]);

        ProcessImageSmall::dispatch($image);

        return back()->with('status', 'Imagen cargada con exito');

    }

    public function contentImage(Request $request)
    {
        $request->validate([
            'image' => 'required|mimes:jpeg,bmp,png|max:10240', //10Mb
        ]);

        $filename = time() . "." . $request->image->extension();

        $request->image->move(public_path('images_post'), $filename);

        return response()->json(["default" => URL::to('/') . '/images_post/' . $filename]);

    }

    public function imageDownload(PostImage $image)
    {
       // return $image->image;
       // Storage::disk('local')->put('file.txt', 'Contents');
      //  return storage_path('app\public');
        return Storage::disk('local')->download($image->image);
    }

    public function imageDelete(PostImage $image)
    {
        $image->delete();
        Storage::disk('local')->delete($image->image);
        return back()->with('status', 'Imagen eliminado con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return back()->with('status', 'Post eliminado con exito');

    }
}
