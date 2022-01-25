<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $events = Event::orderBy('created_at', 'desc')->paginate();
        $events_count = Event::count();
        $events_disabled_count = Event::where('status', 0)->count();
        $events_enabled_count = Event::where('status', 1)->count();
        $users_count = User::count();
        return view('home', compact('events', 'events_count', 'users_count', 'events_disabled_count', 'events_enabled_count'));
    }
}
