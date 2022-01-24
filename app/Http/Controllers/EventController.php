<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // $this->middleware('role:admin');
        $this->middleware('auth:api')->only('index');
        $this->middleware('auth:web')->except('index');
    }


    public function index()
    {
        $events = Event::paginate();
        return response()->json(['success' => true, 'data' => $events]);
    }

    public function indexOnlyAdmins()
    {
        $events = Event::orderBy('created_at', 'desc')->paginate();
        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('events.createOrEdit');
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
            'description' => 'required|string|max:2000',
            'dates' => 'required|array',
            'dates.*' => 'required|date',
            'image' => 'file|image|mimes:jpeg,png,jpg|max:2048',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'is_active' => 'required|in:true,false,0,1',
        ], $request->all());

        if($request->hasFile('image')){
            $image = $request->file('image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $path = $image->storeAs('images', $name);
            // $destinationPath = public_path('/images');
            // $image->move($destinationPath, $name);
        }

        $event = Event::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $name ?? null,
            'position' => '['.$request->lng.','. $request->lat.']',
            'status' => (bool)$request->is_active,
            'start_date' => $request->dates[0],
            'end_date' => $request->dates[1],
        ]);

        // return redirect()->route('events.index');

        return response()->json(['success' => true, 'data' => $request->all()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        if(request()->wantsJson()){
            return response()->json(['success' => true, 'data' => $event]);
        }
        return view('events.createOrEdit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'dates' => 'required|array',
            'dates.*' => 'required|date',
            'image' => 'file|image|mimes:jpeg,png,jpg|max:2048',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'is_active' => 'required|in:true,false,0,1',
        ], $request->all());

        if($request->hasFile('image')){
            $image = $request->file('image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $path = $image->storeAs('images', $name);
            // $destinationPath = public_path('/images');
            // $image->move($destinationPath, $name);
        }

        $event = $event->update([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $name ?? null,
            'position' => '['.$request->lng.','. $request->lat.']',
            'status' => (bool)$request->is_active,
            'start_date' => $request->dates[0],
            'end_date' => $request->dates[1],
        ]);

        // return redirect()->route('events.index');

        return response()->json(['success' => true, 'data' => $request->all()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }
}
