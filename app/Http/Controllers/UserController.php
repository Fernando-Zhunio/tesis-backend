<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
        $search = request('search', null);
        $page = request('page', 1);

        $users = User::search($search)->with('roles')->orderBy('created_at', 'desc')->paginate();
        // return $users;
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index');
    }

    public function beAdmin($id)
    {
        
        $user = User::findOrFail($id);
        if ($user->id == auth()->user()->id) {
            return redirect()->route('users.index');
        }
        $user->removeRole('user');
        $user->assignRole('super-admin');
        return redirect()->route('users.index');
    }

    public function quitAdmin($id)
    {
        $user = User::findOrFail($id);
        if ($user->id == auth()->user()->id) {
            return redirect()->route('users.index');
        }
        $user->removeRole('super-admin');
        $user->assignRole('user');
        return redirect()->route('users.index');
    }

}
