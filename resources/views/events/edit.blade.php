@extends('layouts.app')

@section('css')
    <style>
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, .175) !important;
        }

        .card img {
            border-radius: 20px 20px 0px 0px;
        }

    </style>


    <script src='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.css' rel='stylesheet' />
@endsection
@section('content')
    <div class="container">
        <div class="display-3">Eventos Editando</div>
        <form action="{{ route('events.update',['event' => $event->id]) }}">
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" id="name" class="form-control" name="name" value="{{ $event->name }}">
            </div>
            <div class="form-group">
                <label for="description">Descripcion</label>
                <textarea name="description" id="description" cols="30" rows="10"
                    class="form-control">{{ $event->description }}</textarea>
            </div>
            <div id='map' style='width: 400px; height: 300px;'></div>
        </form>

    </div>
@endsection

@section('scripts')
    <script>
        mapboxgl.accessToken =
            'pk.eyJ1IjoiZmVybmFuZG8xOTkxIiwiYSI6ImNrOGRlcHF2czBxd28zbW5wa3hsaTZnaWcifQ.g1IjAr-9rd65D5W93ftlew';
        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11'
        });
    </script>
@endsection
