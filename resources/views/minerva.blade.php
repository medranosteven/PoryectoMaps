<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Minerva Maps UES-FMO</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/minerva.css') }}">
</head>
<body>
  <header class="header">
      <div class="busqueda">
          <h1 class="busqueda__titulo">Minerva Maps <br>UES-FMO</h1>
          <div class="boton">
              <input class="boton__texto" type="text" placeholder="Buscar en Minerva Maps">
          </div>
      </div>
      <img class="logo" src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Escudo_de_la_Universidad_de_El_Salvador.svg" alt="Logo UES">
  </header>

  <!-- Botón de retorno en la parte superior izquierda -->
  <a href="{{ route('minerva.home') }}" class="circle-button">
      <div class="inner-circle">
          <i class="fas fa-arrow-left"></i>
      </div>
  </a>

  <!-- Contenedor del menú -->
  <div class="menu-container">
      @if(isset($departments) && count($departments) > 0)
          @foreach($departments as $department => $cards)
              <a href="#{{ strtolower(str_replace(' ', '', $department)) }}" class="menu-item">{{ $department }}</a>
          @endforeach
      @else
          <p>No hay departamentos disponibles en este momento.</p>
      @endif
  </div>

  <!-- Sección de Zonas -->
  <div class="section-container">
      @if(isset($departments) && count($departments) > 0)
          @foreach($departments as $department => $cards)
              <div class="section" id="{{ strtolower(str_replace(' ', '', $department)) }}">
                  <h2>{{ $department }}</h2>
                  <div class="cards-container">
                      @foreach(array_slice($cards, 0, 8) as $card)
                          <a href="{{ route('minerva-la') }}" class="card">
                              <div class="card-body">
                                  <img src="{{ explode(',', $card['foto'])[0] }}" alt="{{ $card['nombre'] }}" class="card-img">
                                  <h3>{{ $card['nombre'] ?? 'Sin Nombre' }}</h3>
                                  <p>{{ $card['descripcion'] ?? 'Sin Descripción' }}</p>
                                  <p>Coordenadas: {{ $card['coordenadas'] ?? 'Sin Coordenadas' }}</p>
                              </div>
                          </a>
                      @endforeach
                  </div>

                  @if(count($cards) > 8)
                      <div class="more-cards-container" id="more-{{ strtolower(str_replace(' ', '', $department)) }}" style="display: none;">
                          @foreach(array_slice($cards, 8) as $card)
                              <a href="{{ route('minerva-la') }}" class="card">
                                  <div class="card-body">
                                      <img src="{{ explode(',', $card['foto'])[0] }}" alt="{{ $card['nombre'] }}" class="card-img">
                                      <h3>{{ $card['nombre'] ?? 'Sin Nombre' }}</h3>
                                      <p>{{ $card['descripcion'] ?? 'Sin Descripción' }}</p>
                                      <p>Coordenadas: {{ $card['coordenadas'] ?? 'Sin Coordenadas' }}</p>
                                  </div>
                              </a>
                          @endforeach
                      </div>
                      <div class="view-more-btn">
                          <button class="btn" onclick="showMoreCards('more-{{ strtolower(str_replace(' ', '', $department)) }}')">Ver más...</button>
                      </div>
                  @endif
              </div>
          @endforeach
      @else
          <p>No hay departamentos disponibles en este momento.</p>
      @endif
  </div>

  <!-- Sección de Aulas -->
  <div class="container">
      <h1>Listado de Aulas</h1>

      @if(isset($error))
          <div class="alert alert-danger">
              <p>{{ $error }}</p>
          </div>
      @elseif(!empty($aulas))
          <table class="table table-striped">
              <thead>
                  <tr>
                      <th>ID</th>
                      <th>Nombre</th>
                      <th>Capacidad</th>
                      <th>Zona</th>
                      <!-- Añade más columnas según la estructura de tus datos -->
                  </tr>
              </thead>
              <tbody>
                  @foreach ($aulas as $aula)
                      <tr>
                          <td>{{ $aula['id'] ?? 'N/A' }}</td>
                          <td>{{ $aula['nombre'] ?? 'Sin Nombre' }}</td>
                          <td>{{ $aula['capacidad'] ?? 'Sin Capacidad' }}</td>
                          <td>{{ $aula['zona'] ?? 'Sin Zona' }}</td>
                          <!-- Añade más datos según la estructura de tus datos -->
                      </tr>
                  @endforeach
              </tbody>
          </table>
      @else
          <p>No se encontraron aulas.</p>
      @endif
  </div>

  <!-- Galería de Imágenes -->
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
