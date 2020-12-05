<?php

namespace App\Http\Controllers\dashboard;

use App\Category;
use App\Helpers\CustomUrl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryPost;
use App\Http\Requests\UpdateCategoryPut;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware(['auth', 'rol.admin']);
    }

    public function index(Request $request)
    {

        $elements = array();

        /* for ($i=0; $i < 116; $i++) { 
            array_push($elements, $i);
        }*/

        $elements = range(1, 224);
        $perPage = 10;
        $currentPage = $request->page ?: 1;

        $currentElements = array_slice($elements, $perPage * ($currentPage - 1), $perPage);

        //dd($currentElements);

        //$res = new Paginator($currentElements,$perPage,$currentPage ,['path'=>'/dashboard/category']);
        $res = new LengthAwarePaginator($currentElements, count($elements), $perPage, $currentPage, ['path' => '/dashboard/category']);

        $res->setPath('/dashboard/category');

        // dd($res);


        // dd($elements);

        $categories = Category::orderBy('created_at', 'desc')->paginate(10);
        return view('dashboard.category.index', ['categories' => $categories, 'res' => $res]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.category.create', ['category' => new Category()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryPost $request)
    {
        // dd($request->validated());
        if ($request->url_clean == "") {
            $urlClean = CustomUrl::urlTitle(CustomUrl::convertAccentedCharacters($request->title), '-', true);
        } else {
            $urlClean = CustomUrl::urlTitle(CustomUrl::convertAccentedCharacters($request->url_clean), '-', true);
        }
        $requestData = $request->validated();
        $requestData['url_clean'] = $urlClean;

        $validator = Validator::make($requestData, StoreCategoryPost::myRules());

        if ($validator->fails()) {
            return redirect('dashboard/category/create')
                ->withErrors($validator)
                ->withInput();
        }

        Category::create($requestData);
        return back()->with('status', 'Categoria creado con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('dashboard.category.show', ["category" => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('dashboard.category.edit', ["category" => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryPut $request, Category $category)
    {
        $category->update($request->validated());
        return back()->with('status', 'Categoria actualizado con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('status', 'Categoria eliminado con exito');
    }
}
