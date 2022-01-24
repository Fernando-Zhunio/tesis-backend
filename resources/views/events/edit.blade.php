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
        .form-group {
            margin-top: 5px;
        }

    </style>


    <script src='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.css' rel='stylesheet' />
@endsection
@section('content')
    <div class="container">
        <div class="display-3">Eventos Editando</div>

        <form action="{{ route('events.update', ['event' => $event->id]) }}">
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" id="name" class="form-control" name="name" value="{{ $event?->name }}">
            </div>
            <div class="form-group">
                <label for="description">Descripcion</label>
                <textarea name="description" id="description" cols="30" rows="5"
                    class="form-control">{{ $event?->description }}</textarea>
            </div>
            <div>
                <div class="my-2">Seleccione una posicion del evento</div>
                <div id='map' style='width: 100%; height: 500px;' class="rounded-20 shadow"></div>
            </div>
            <button type="submit" class="btn btn-primary my-2">Guardar </button>
        </form>
        
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/event.js')}}"></script>
@endsection
