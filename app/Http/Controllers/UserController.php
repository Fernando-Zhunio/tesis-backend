<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:web');
        $this->middleware('can:super-admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $search = request('search', null);
        // $page = request('page', 1);

        // $users = User::search($search)->with('roles')->orderBy('created_at', 'desc')->paginate();
        // return view('users.index', compact('users'));
        $search = request()->get('search', null);
        $users = User::search($search)->with('roles')->orderBy('created_at', 'desc')->paginate();
        return request()->wantsJson()
            ? new JsonResponse($users, 200)
            :  view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'is_student' => 'boolean',
            'birthday' => 'required|date',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'is_student' => $request->get('is_student', 0),
            'birthday' => $request->birthday,
        ]);
        $user->assignRole('user');
        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (auth()->user()->id == $id) {
            throw ValidationException::withMessages(['message' => 'Tu no puedes borrar tu propio usuario']);
        }
        $user = User::findOrFail($id);
        $user->delete();
        return request()->wantsJson()
            ? new JsonResponse($user, 200)
            : redirect()->route('users.index');
    }

    public function beAdmin($id)
    {

        $user = User::findOrFail($id);
        if ($user->id == auth()->user()->id) {
            throw ValidationException::withMessages(['message' => 'Tu no puedes asignarte tu propio rol']);
        }
        $user->removeRole('user');
        $user->assignRole('admin');
        return request()->wantsJson()
                    ? new JsonResponse($user, 200)
        : redirect()->route('users.index');
    }

    public function quitAdmin($id)
    {
        $user = User::findOrFail($id);
        if ($user->id == auth()->user()->id) {
            throw ValidationException::withMessages(['message' => 'Tu no puedes quitar tu propio rol de administrador']);
        }
        $user->removeRole('admin');
        $user->assignRole('user');
        return request()->wantsJson()
            ? new JsonResponse($user, 200)
            : redirect()->route('users.index');
    }
}
