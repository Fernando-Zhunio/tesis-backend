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
        $best_event = Event::where('status', 1)->withCount('favorites')->get();
        $date_server = Carbon::now()->toDateTimeString();
        $events_best_like = Event::where('status', 1)->whereHas('likers')->withCount('likers')->orderBy('likers_count', 'desc')->paginate(10);
        // return response()->json([
        //     // 'events' => $events,
        //     'events_count' => $events_count,
        //     'events_disabled_count' => $events_disabled_count,
        //     'events_enabled_count' => $events_enabled_count,
        //     'users_count' => $users_count,
        //     // 'best_event' => $best_event,
        //     'event_like' => $events_best_like,
        // ]);
        return view('home', compact('events_best_like','events', 'events_count', 'users_count', 'events_disabled_count', 'events_enabled_count', 'date_server' ));
    }

    public function indexApi()
    {
        $_events = Event::orderBy('created_at', 'desc')
        ->where('start_date', '>=', Carbon::now())
        ->orWhere('end_date', '>=', Carbon::now())
        ->where('status', 1)
        ->paginate();
        /**
         * @var Event $events
         */
        $events = auth()->user()->attachLikeStatus($_events);
        $eventsActives = Event::where('status', 1)
            ->where('start_date', '>=', Carbon::now())
            ->orWhere('end_date', '>=', Carbon::now())
            ->count();

        $eventsFavoriteCount = auth()->user()->favorites()->withType(Event::class)->count();
        $user = auth()->user()->load('likes');

        return response()->json(['success' => true, 'data' => [
            'events' => $events,
            'eventsActivesCount' => $eventsActives,
            'eventsFavoriteCount' => $eventsFavoriteCount,
            'user' => $user,
            'date_server' => Carbon::now()->toDateTimeString(),

        ]]);
    }
}
