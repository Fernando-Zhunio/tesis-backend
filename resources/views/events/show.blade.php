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
    <div class="row">
        <div class="col-md-3 col-12">
            <div class="card mb-4 shadow-sm">
                <img class="card-img-top" src="{{ $event?->image ?? asset('assets/images/background-default.jpg') }}"
                    alt="Card image cap">
                <div class="card-body">
                    <p class="card-text
        @if ($event->status == '1') text-success
        @else
        text-danger @endif
        ">
                        {{ $event->status ? 'Activo' : 'Inactivo' }}
                    </p>
                    <p>{{ $event->created_at->diffforhumans() }}</p>
                    <p class="m-0 fs-5 text-secondary">{{ $event->name }}</p>
                    <p class="card-text ">{{ $event->description }}</p>
                    <div class="badge bg-info">Inicia: {{ $event->start_date }}</div>
                    <div class="badge bg-warning">Finaliza: {{ $event->end_date }}</div>
                    <br>
                    <a href="{{ route('events.edit', ['event' => $event->id]) }}" class="btn rounded-pill btn-primary mt-2">Editar
                        <i class="far fa-edit"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
