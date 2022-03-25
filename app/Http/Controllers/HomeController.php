<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:web')->only(['index']);
        // $this->middleware('can:super-admin')->only(['index']);
        $this->middleware('auth:api')->except(['index']);
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
        $events_enabled_count = Event::where('status', 1)
        ->whereDate('start_date', '>=', Carbon::now())
        ->whereDate('end_date', '>=', Carbon::now())
        ->where('status', 1)->count();
        $users_count = User::count();
        return view('home', compact('events', 'events_count', 'users_count', 'events_disabled_count', 'events_enabled_count'));
    }

    public function indexApi() {
        $_events = Event::orderBy('created_at', 'desc')->paginate(10);
        $events = auth()->user()->attachFavoriteStatus($_events);
        $eventsActives = Event::where('status', 1)
        ->whereDate('start_date', '>=', Carbon::now())
        ->whereDate('end_date', '>=', Carbon::now())
        ->where('status', 1)->count();
        $eventsFavoriteCount = auth()->user()->favorites()->withType(Event::class)->count();

        return response()->json(['success' => true, 'data' => [
            'events' => $events,
            'eventsActivesCount' => $eventsActives,
            'eventsFavoriteCount' => $eventsFavoriteCount,
            'user' => auth()->user()
        ]]);
    }
}
