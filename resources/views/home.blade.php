@extends('layouts.app')

@section('css')
    <style>
        .card {
            margin-top: 20px;
        }
        .img-header-home {
            width: 70px;
            height: 70px;
        }

    </style>
@endsection

@section('content')
    <div class="container">
        {{-- <h1 class="display-2 fw-normal">Bienvenido a UG Events AR</h1> --}}
        <div class="center justify-content-start my-4">
            <img class="img-header-home" src="/assets/images/Logo1.png" alt="logo ar">
            <div>
                <h1 class="m-0">Hola <strong class="text-capitalize">{{auth()->user()->name}}</strong></h1>
                <h3>Bienvenido a UG Events AR</h3>
            </div>
        </div>
        <div>
            <div class="row">
                <div class="item-home col-md-3 text-center card-body shadow rounded-20">
                    <h3 >Total de eventos</h3>
                    <div class="center">
                        <i class="fas fa-bell fa-4x"></i>
                        <span>&nbsp;&nbsp;&nbsp;</span>
                        <span class="fs-1">{{ $events_count }}</span>
                    </div>
                </div>
                <div class=" col-md-3 text-center">
                    <div class="card-body item-home shadow rounded-20">
                        <h3 >Eventos Activos</h3>
                        <div class="center">
                            <i class="far fa-bell fa-4x"></i>
                            <span>&nbsp;&nbsp;&nbsp;</span>
                            <span class="fs-1">{{ $events_enabled_count }}</span>
                        </div>
                    </div>
                </div>
                <div class=" col-md-3 text-center">
                    <div class="card-body item-home shadow rounded-20">
                        <h3 >Eventos Inactivos </h3>
                        <div class="center">
                            <i class="far fa-bell-slash fa-4x"></i>
                            <span>&nbsp;&nbsp;&nbsp;</span>
                            <span class="fs-1">{{ $events_disabled_count }}</span>
                        </div>
                    </div>
                </div>
                <div class="  col-md-3 text-center">
                    <div class="card-body item-home shadow rounded-20">
                        <h3 >Total de usuarios</h3>
                        <div class="center">
                            <i class="fas fa-users fa-4x"></i>
                            <span>&nbsp;&nbsp;&nbsp;</span>
                            <span class="fs-1">{{ $users_count }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-7">
                    <div class="row">
                        {{-- <div class="col-md-6 col-12">
                            <a href="{{ route('events.create') }}" style="text-decoration: none">
                                <div class="card text-center border-0 shadow lead" style="border-radius: 20px">
                                    <div class="card-header" style="border-radius: 20px 20px 0 0;">
                                        <i class="fas fa-calendar-day fa-6x"></i>
                                    </div>
                                    <div class="card-body">
                                        <p>
                                            Crear evento
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div> --}}
                        <div class="col-md-6 col-12">
                            <a href="{{ route('events.index') }}" style="text-decoration: none">
                                <div class="card text-center border-0 shadow lead" style="border-radius: 20px">
                                    <div class="card-header" style="border-radius: 20px 20px 0 0;">
                                        <i class="fas fa-calendar-alt fa-6x"></i>
                                    </div>
                                    <div class="card-body">
                                        <p>
                                            Ver eventos
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 col-12">
                            <a href="{{ route('users.index') }}" style="text-decoration: none">
                                <div class="card text-center border-0 shadow lead" style="border-radius: 20px">
                                    <div class="card-header" style="border-radius: 20px 20px 0 0;">
                                        <i class="fas fa-users-cog fa-6x"></i>
                                    </div>
                                    <div class="card-body">
                                        <p>
                                            Gestinar usuarios
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-5 col-12 pt-4">
                    <div class="rounded-20 shadow card-body">
                        <h3>Eventos mas popular</h3>
                        <div>
                            <table class="table table-striped table-borderless">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Inicio/a</th>
                                        <th>Me gusta</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($events_best_like as $event)
                                        <tr>
                                            <td><span>{{ $event->name }}</span></td>
                                            <td>{{ $event->start_date }}</td>
                                            <td>{{ $event->likers_count }}</td>
                                            <td>
                                                <a href="{{ route('events.show', $event->id) }}" class="btn btn-primary btn-sm">Ver</a>
                                        </tr>
                                    @endforeach
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="text-end" style="position:fixed;right: 10px;bottom:10px">
        <a href="{{ route('events.create') }}" class=" btn btn-warning my-1 p-1 px-2 rounded-20 shadow-sm text-white border-0"><i class="fas fa-plus"></i> Crear evento</a><br>
        <span class="badge bg-success">Fecha del servidor: {{ $date_server }}</span>
    </div>
@endsection
