<?php
$images = [
    ['url' => 'https://via.placeholder.com/502x677', 'caption' => 'Imagen principal'],
    ['url' => 'https://via.placeholder.com/346x332', 'caption' => 'Imagen secundaria'],
    ['url' => 'https://via.placeholder.com/346x332', 'caption' => 'Imagen secundaria'],
    ['url' => 'https://via.placeholder.com/346x332', 'caption' => 'Imagen secundaria'],
    ['url' => 'https://via.placeholder.com/346x332', 'caption' => 'Imagen secundaria']
];

$highlightedImages = [
  [
      'url' => 'https://via.placeholder.com/712x677',
      'title' => 'Auditorio 1',
      'location' => 'CRQV+V24, San Miguel',
      'address' => 'Frente a la Plaza Roque Daltón, Costado Poniente del Parqueo de Visitantes.',
      'capacity' => '250 personas'
  ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minerva Maps UES-FMO</title>
    <link rel="stylesheet" href="{{ asset('css/minerva-la.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
</head>
<body>
<!-- Botón de retorno en la parte superior izquierda -->
<a href="{{ route('minerva') }}"class="circle-button">
    <div class="inner-circle">
        <i class="fas fa-arrow-left"></i>
    </div>
</a>

<div class="container">
  <div class="image-grid">
    @foreach ($images as $index => $image)
      @if ($index == 0)
        <!-- Primera imagen más grande -->
        <img class="main-image" src="{{ $image['url'] }}" alt="{{ $image['caption'] }}" />
      @else
        <!-- Imágenes secundarias en grid -->
        <img class="grid-image" src="{{ $image['url'] }}" alt="{{ $image['caption'] }}" />
      @endif
    @endforeach
    
    <!-- Botón flotante sobre la última imagen del grid -->
    <div class="button-box" onclick="location.href='{{ route('minerva-overley') }}'">
      <div class="button-text">Mostrar todas las fotos</div>
    </div>
  </div>
  
  <div class="container">
    <!-- Contenedor de imagen destacada y texto -->
    @foreach ($highlightedImages as $image)
    <div class="highlighted-container">
        <div class="info-box">
            <div class="auditorio-text">{{ $image['title'] }}</div>
            <div class="location">
                <i class="bi bi-geo-alt" style="font-size: 24px;"></i>
                <div class="location-text">{{ $image['location'] }}</div>
            </div>
            <div class="address">
                <i class="bi bi-map" style="font-size: 24px;"></i>
                <div class="address-text">{{ $image['address'] }}</div>
            </div>
            <div class="capacity">
                <i class="bi bi-people" style="font-size: 24px;"></i>
                <div class="capacity-text">{{ $image['capacity'] }}</div>
            </div>
        </div>
        <img class="highlighted-image" src="{{ $image['url'] }}" alt="{{ $image['title'] }}" />
    </div>
    @endforeach
</div>
</div>
<br><br><br>
<!-- Footer al final del contenido -->
<div class="footer">
  <div class="footer-text">© Realizado por estudiantes de Ingeniería en Sistemas Informáticos 2024.</div>
</div>

<script src="{{ asset('js/minerva.js') }}"></script>
</body>
</html>
