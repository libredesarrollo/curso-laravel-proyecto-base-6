<?php

namespace App\Http\Controllers\dashboard;

use App\Events\UserCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserPost;
use App\Http\Requests\UpdateUserPut;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
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

    public function index()
    {

        // User::find(2)->tags()->sync([1,2,3,4]);

        $users = User::with('rol')->orderBy('created_at', 'desc')->paginate(10);
        return view('dashboard.user.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.user.create', ['user' => new User()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserPost $request)
    {
        $user = User::create(
            [
                'name' => $request['name'],
                'rol_id' => 1, // rol de admin
                'surname' => $request['surname'],
                'email' => $request['email'],
                'password' => $request['password'],
            ]
        );

        event(new UserCreated($user));

        return back()->with('status', 'Usuario creado con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('dashboard.user.show', ["user" => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('edit', $user);
        return view('dashboard.user.edit', ["user" => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserPut $request, User $user)
    {
        $this->authorize('edit', $user);
        $user->update(
            [
                'name' => $request['name'],
                'surname' => $request['surname'],
                'email' => $request['email'],
            ]
        );
        return back()->with('status', 'Usuario actualizado con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('status', 'Usuario eliminado con exito');
    }
}
