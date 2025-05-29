<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Concesionario Ferrari</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Leaflet CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .navbar {
      background-color: #000;
    }
    .navbar-brand, .nav-link, .btn-outline-light {
      color: white !important;
    }
    .btn-outline-light:hover {
      background-color: #c70039;
      border-color: #c70039;
    }
    h1 {
      color: #c70039;
      text-align: center;
      margin: 40px 0 20px;
      font-weight: bold;
    }
    .card {
      border: none;
      transition: transform 0.3s ease;
    }
    .card:hover {
      transform: scale(1.03);
    }
    .card-img-top {
      height: 200px;
      object-fit: cover;
    }
    .card-title {
      color: #c70039;
    }
    #map {
      height: 400px;
      margin: 40px auto;
      max-width: 1000px;
    }
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand fw-bold" href="{{ route('home') }}">Ferrari Motors</a>
    <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Nuestros Autos</a></li>
        @auth
            @if(Auth::user()->role === 'cliente')
                <li class="nav-item"><a class="nav-link" href="{{ route('citas.index') }}">Agendar Cita</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('citas.mis') }}">Mis Citas</a></li>
            @elseif(Auth::user()->role === 'empleado')
                <li class="nav-item"><a class="nav-link" href="{{ route('ventas.index') }}">Ventas</a></li>
            @elseif(Auth::user()->role === 'admin')
                <li class="nav-item"><a class="nav-link" href="{{ route('autos.crud') }}">Autos</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('usuarios.index') }}">Usuarios</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('ventas.index') }}">Ventas</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('citas.index') }}">Citas</a></li>
            @endif
        @endauth
        @guest
            <li class="nav-item"><a class="nav-link" href="{{ route('citas.index') }}">Agendar Cita</a></li>
        @endguest
      </ul>
      <div class="d-flex gap-2">
        @guest
          <a href="{{ route('login') }}" class="btn btn-outline-light">Iniciar sesión</a>
          <a href="{{ route('register') }}" class="btn btn-outline-light">Registrarse</a>
        @else
          <span class="text-white me-2 align-self-center">{{ Auth::user()->name }}</span>
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-light">Cerrar sesión</button>
          </form>
        @endguest
      </div>
    </div>
  </div>
</nav>

<!-- TÍTULO -->
<h1>Nuestros Autos</h1>

<!-- CARDS DINÁMICAS -->
<div class="container">
  <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    @foreach($autos as $auto)
      <div class="col">
        <div class="card shadow">
          @if($auto->imagen)
            <img src="{{ Storage::url($auto->imagen) }}" class="card-img-top" alt="{{ $auto->marca }} {{ $auto->modelo }}">
          @else
            <img src="https://via.placeholder.com/400x200.png?text=Sin+imagen" class="card-img-top" alt="Sin imagen">
          @endif
          <div class="card-body">
            <h5 class="card-title">{{ $auto->marca }} {{ $auto->modelo }}</h5>
            <p class="card-text">
              <strong>Año:</strong> {{ $auto->anio }}<br>
              <strong>Color:</strong> {{ $auto->color }}<br>
              <strong>Transmisión:</strong> {{ $auto->tipoTransmision }}<br>
              <strong>Kilometraje:</strong> {{ number_format($auto->km) }} km<br>
              <strong>Precio:</strong> ${{ number_format($auto->precio, 2) }}
            </p>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>

<!-- MAPA -->
<h2 class="mt-5 text-center">Ubicación de la Agencia</h2>
<div id="map"></div>

<!-- SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
  const map = L.map('map').setView([22.1511, -100.9310], 15); // Coordenadas de la agencia

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
  }).addTo(map);

  L.marker([22.1511, -100.9310]).addTo(map)
    .bindPopup('Agencia Ferrari')
    .openPopup();
</script>
</body>
</html>
