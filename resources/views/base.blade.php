<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Minerva Maps UES-FMO')</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
    crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/minerva.css') }}">   
    
  @yield('styles')
</head>
<body>
<div>
    @if(!isset($hideHeader) || !$hideHeader)
    <div class="row">
        <header class="header">
            <div class="">
                <p class="busqueda__titulo">Minerva Maps <br>UES-FMO</p>
                <div class="boton">
                    <svg xmlns="http://www.w3.org/2000/svg" class="type__icon" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                        <path d="M21 21l-6 -6" />
                    </svg>
                    <input class="boton__texto" type="text" placeholder="Buscar">
                </div>
            </div>
            <div class="">
                <img class="logo" src="https://www.uese.ues.edu.sv/images/minerva_sola_white.png" alt="Logo UES">
            </div>
        </header>
    </div>
    
    <!-- Contenedor del menú -->
    <div class="menu-container">
        @if(isset($departments) && count($departments) > 0)
        @foreach($departments as $department => $cards) <!-- Aquí obtienes la clave y los datos -->
        <a href="#{{ strtolower(str_replace(' ', '', $department)) }}" class="menu-item">{{ $department }}</a> <!-- $department es la clave (nombre de la zona) -->
        @endforeach
        @else
        <p>No hay departamentos disponibles en este momento.</p>
        @endif
    </div>
    @endif
</div>
    @yield('content')

    <div class="footer">
        <div class="footer-text">© Realizado por estudiantes de Ingeniería en Sistemas Informáticos 2024.</div>
    </div>
 
    <script src="{{ asset('js/minerva.js') }}"></script>
    
</body>

</html>