<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


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
        $this->middleware('auth:api');
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
            $file_name = $this->addFile($image);

            // $name = time().'.'.$image->getClientOriginalExtension();
            // $path = $image->storeAs('images', $name);
            // $destinationPath = public_path('/images');
            // $image->move($destinationPath, $name);
        }

        $event = Event::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $file_name ?? null,
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
        return response()->json(['success' => true, 'data' => $event]);
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
            $file_name = $this->addFile($image);
            // $name = time().'.'.$image->getClientOriginalExtension();
            // $path = $image->storeAs('images', $name);
            // $destinationPath = public_path('/images');
            // $image->move($destinationPath, $name);
        }

        $event = $event->update([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $file_name ?? null,
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

    public function addFile(UploadedFile  $file,  string $disk = 'public', string $dir = '/images'){
        $file_name =  $dir . "/" . Str::random(30) . time() . "." . $file->guessClientExtension();
        Storage::disk($disk)->put($file_name, $file->getContent());
        return $file_name;
    }

    public function getWaypoints(Request $request,Event $event){
        // return $event;
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ], $request->all());
        $lng_start = $request->lng;
        $lat_start = $request->lat;
        $token= env('TOKEN_MAPBOX');
        $lng_end = $event->position[0];
        $lat_end = $event->position[1];
        $url = "https://api.mapbox.com/directions/v5/mapbox/driving/$lng_start,$lat_start;$lng_end,$lat_end?access_token=$token&geometries=geojson&overview=full";
        $responde_mapbox = Http::get($url)->json();
        $waypoints = $responde_mapbox['routes'][0]['geometry']['coordinates'];
        return response()->json(['success' => true, 'data' => $waypoints]);
    }

    public function getWaypointsForMap(Request $request,Event $event){
        // return $event;
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',

        ], $request->all());
        $lng = $event->position[0];
        $lat = $event->position[1];
        $token= env('TOKEN_MAPBOX');
        $lat_o = $request->lat;
        $lng_o = $request->lng;
        $url = "https://api.mapbox.com/directions/v5/mapbox/driving/$lng_o,$lat_o;$lng,$lat?access_token=$token&geometries=geojson&overview=full";
        $responde_mapbox = Http::get($url)->json();
        $waypoints =[];
        $_waypoints = (array)$responde_mapbox['routes'][0]['geometry']['coordinates'];
        if (count($_waypoints) > 1) {
            $waypoints = ['start_location' => $_waypoints[0], 'end_location' => $_waypoints[1], 'is_end' => false];
        } else {
            $waypoints = ['start_location' => $_waypoints[0], 'end_location' => $_waypoints[0], 'is_end' => true];
        }

        return response()->json(['success' => true, 'data' => $waypoints]);
    }

    public function toggleFavorite(Request $request, Event $event){
        $user = auth()->user();
        $user->toggleFavorite($event);
        return response()->json(['success' => true, 'data' => $event]);
    }

    public function getFavorite(){
        $user = auth()->user();
        $events = $user->getFavoriteItems(Event::class)->get();
        return response()->json(['success' => true, 'data' => $events]);
    }
}
