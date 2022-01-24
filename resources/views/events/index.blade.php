@extends('layouts.app')

@section('css')
   <style>
       .card{
           border: none;
           border-radius: 20px;
           box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
       }
       .card img {
              border-radius: 20px 20px 0px 0px;
       }
   </style>
@endsection
@section('content')
    <div class="container">
        <div class="display-3">Eventos</div>
        @if (!empty($events))
            <div class="row">
                @foreach ($events as $event)
                    <div class="col-md-4 col-12">
                        <div class="card mb-4 shadow-sm">
                            <img class="card-img-top" src="{{ $event?->image ?? asset('assets/images/background-default.jpg') }}" alt="Card image cap">
                            <div class="card-body">
                                <p
                                    class="card-text
                    @if ($event->status == '1')
                    text-success
                    @else
                    text-danger
                    @endif
                    ">
                                    {{ $event->status ? 'Activo' : 'Inactivo' }}
                                </p>
                                <p>{{$event->created_at->diffforhumans()}}</p>
                                <p class="card-text fs-5">{{ $event->name }}</p>
                                <p class="card-text lead">{{ $event->description }}</p>
                                <a href="{{route('events.edit',['event' => $event->id])}}" class="btn rouded-circle btn-outline-primary"><i class="far fa-edit"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else

        @endif
    </div>
@endsection
