@extends('layouts.app')

@section('css')
    <style>
        .card {
            margin-top: 20px;
        }

    </style>
@endsection

@section('content')
    <div class="container">
        <h1 class="display-2 fw-normal">Bienvenido a UG Events AR</h1>
        <div>
            <div class="row">
                <div class="col-md-3 text-center card-body shadow rounded-20">
                    <h3 class="border-bottom">Total de eventos</h3>
                    <div class="center">
                        <i class="fas fa-bell fa-4x"></i>
                        <span>&nbsp;&nbsp;&nbsp;</span>
                        <span class="fs-1">{{ $events_count }}</span>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="card-body shadow rounded-20">
                        <h3 class="border-bottom">Eventos Activos</h3>
                        <div class="center">
                            <i class="far fa-bell fa-4x"></i>
                            <span>&nbsp;&nbsp;&nbsp;</span>
                            <span class="fs-1">{{ $events_enabled_count }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="card-body shadow rounded-20">
                        <h3 class="border-bottom">Eventos Inactivos </h3>
                        <div class="center">
                            <i class="far fa-bell-slash fa-4x"></i>
                            <span>&nbsp;&nbsp;&nbsp;</span>
                            <span class="fs-1">{{ $events_disabled_count }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="card-body shadow rounded-20">
                        <h3 class="border-bottom">Total de usuarios</h3>
                        <div class="center">
                            <i class="fas fa-users fa-4x"></i>
                            <span>&nbsp;&nbsp;&nbsp;</span>
                            <span class="fs-1">{{ $users_count }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-12">
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
                </div>

                <div class="col-md-4 col-12">
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
                @can('super-admin')
                    {{-- <div class="col-md-4 col-12">
                    <a href="{{ route('events.create') }}" style="text-decoration: none">
                        <div class="card text-center border-0 shadow lead" style="border-radius: 20px">
                            <div class="card-header" style="border-radius: 20px 20px 0 0;">
                                <i class="fas fa-user-tag fa-6x"></i>
                            </div>
                            <div class="card-body">
                                <p>
                                    Asignar permisos
                                </p>
                            </div>
                        </div>
                    </a>
                </div> --}}

                    <div class="col-md-4 col-12">
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
                @endcan
            </div>
        </div>
    </div>
    <div class="badge bg-success" style="position:fixed;right: 10px;;bottom:10px">
        Fecha del servidor: {{ $date_server }}
    </div>
@endsection
