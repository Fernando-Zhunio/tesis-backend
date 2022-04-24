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
{{-- @section('scripts')
<script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async></script>
@endsection --}}
@section('scripts')
{{-- <script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async></script> --}}
    <script src="{{ asset('js/event.js') }}"></script>
@endsection
@section('content')

    {{-- <div class="container">
        <div class="display-3">Eventos</div>
        @if (!empty($events))
            <div data-masonry='{"percentPosition": true }' class="row">
                @foreach ($events as $event)
                    <div class="col-md-3 col-12">
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
                                <p class="m-0 fs-5 text-secondary">{{ $event->name }}</p>
                                <p class="card-text ">{{ $event->description }}</p>
                                <div class="badge bg-info">Inicia: {{ $event->start_date }}</div>
                                <div class="badge bg-warning">Finaliza: {{ $event->end_date }}</div>
                                <br>
                                <a href="{{route('events.edit',['event' => $event->id])}}" class="btn rounded-pill btn-primary mt-2">Editar <i class="far fa-edit"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="d-flex justify-content-center">
                    {!! $events->links('pagination::bootstrap-4') !!}
                </div>
            </div>
        @else

        @endif
    </div> --}}
    <div id="app">
        <events-list-component></events-list-component>
    </div>
@endsection


