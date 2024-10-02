@extends('base')

@section('title', 'Minerva Maps UES-FMO')

@section('content')

<!-- Sección con las tarjetas -->
<div class="container-fluid">
    <div class="row m-3">
        @foreach($departments as $department => $cards)
        <div class="col-12 mb-6" id="{{ strtolower(str_replace(' ', '', $department)) }}">
            <h2 class="section-title">{{ $department }}</h2>
            <div class="row">
                @foreach(array_slice($cards, 0, 8) as $card)
                @if(isset($card['id']) && isset($card['nombre']))
                <div class="col-md-3 mb-4">
                    <div class="card h-100 d-flex flex-column">
                        @if(isset($card['fotos']))
                        <a href="{{ route('minerva-la.aula', ['id' => $card['id']]) }}" class="text-decoration-none">
                            @php
                            $fotos = explode(',', $card['fotos']);
                            @endphp
                            <img src="{{ $fotos[0] }}" class="card-img-top img-fluid" alt="{{ $card['nombre'] }}">
                            @elseif(isset($card['foto']))
                            <a href="{{ route('minerva-la.referencia', ['id' => $card['id']]) }}"
                                class="text-decoration-none">
                                <img src="{{ explode(',', $card['foto'])[0] }}" class="card-img-top img-fluid"
                                    alt="{{ $card['nombre'] }}">
                                @endif
                                <div class="mt-3">
                                    <h5 class="title-card">{{ $card['nombre'] }}</h5>
                                    @if(isset($card['fotos']))
                                    <p class="card-text text-card">Zonarelaciona: {{ $department }}</p>

                                    @else
                                    <p class="card-text text-card">
                                        {{ $card['descripcion'] ?? 'No description available' }}</p>

                                    @endif
                                </div>
                            </a>
                    </div>
                </div>
                @endif
                @endforeach
            </div>

            @if(count($cards) > 8)
            <div class="col-13 mb-4" id="more-{{ strtolower(str_replace(' ', '', $department)) }}"
                style="display: none;">
                <div class="row">
                    @foreach(array_slice($cards, 8) as $card)
                    @if(isset($card['id']) && isset($card['nombre']))
                    <div class="col-md-3 mb-4 card-container">
                        <div class="card h-100 d-flex flex-column">
                            @if(isset($card['fotos']))
                            <a href="{{ route('minerva-la.aula', ['id' => $card['id']]) }}"
                                class="text-decoration-none">
                                @php
                                $fotos = explode(',', $card['fotos']);
                                @endphp
                                <img src="{{ $fotos[0] }}" class="card-img-top img-fluid" alt="{{ $card['nombre'] }}">
                                @elseif(isset($card['foto']))
                                <a href="{{ route('minerva-la.referencia', ['id' => $card['id']]) }}"
                                    class="text-decoration-none">
                                    <img src="{{ explode(',', $card['foto'])[0] }}" class="card-img-top img-fluid"
                                        alt="{{ $card['nombre'] }}">
                                    @endif
                                    <div class="mt-3">
                                        <h5 class=" title-card">{{ $card['nombre'] }}</h5>
                                        @if(isset($card['fotos']))
                                        <p class="card-text text-card">Zonarelaciona: {{ $department }}</p>
                                       @else
                                        <p class="card-text text-card">
                                            {{ $card['descripcion'] ?? 'No description available' }}</p>
                                        @endif
                                    </div>
                                </a>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>

            <div class="text-center">
                <button class=" btn " id="toggle-{{ strtolower(str_replace(' ', '', $department)) }}"
                    onclick="showMoreCards('more-{{ strtolower(str_replace(' ', '', $department)) }}', this)">Ver
                    más</button>
            </div>
            @endif
        </div>
        @endforeach
    </div>
</div>
@endsection