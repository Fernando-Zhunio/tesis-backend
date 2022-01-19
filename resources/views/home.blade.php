@extends('layouts.app')

@section('css')
   <style>
       .card{
              margin-top: 20px;
       }
   </style>
@endsection

@section('content')
    <div class="container">
        {{-- <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div> 
    </div> --}}
        <h1 class="display-2">Bienvenido a UG Events AR</h1>
        <div>
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
                   <div class="col-md-4 col-12">
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
                </div> 
               
                
                <div class="col-md-4 col-12">
                    <a href="{{ route('events.create') }}" style="text-decoration: none">
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
@endsection
