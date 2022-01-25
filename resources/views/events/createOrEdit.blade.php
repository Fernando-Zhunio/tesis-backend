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

        .btn-apply-location {
            display: flex;
            align-items: end;
        }

    </style>


    <script src='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.css' rel='stylesheet' />
@endsection
@section('content')
    <div id="app" class="container">
        @isset($event)
            <div class="display-3">Editando Evento</div>
            <create-events-component :event_id="{{ $event->id }}"></create-events-component>
        @else
        <div class="display-3">Creando Evento</div>
            <create-events-component></create-events-component>
        @endisset
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/event.js') }}"></script>
@endsection
