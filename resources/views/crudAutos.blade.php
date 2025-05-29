@extends('layouts.app')

@section('content')

@if(!Auth::check() || !in_array(Auth::user()->role, ['empleado', 'admin']))
    @php abort(403); @endphp
@endif

<div class="container">
    <h1>CRUD de Autos</h1>

    {{-- Mensaje de exito --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Formulario de agregar/editar --}}
    <form action="{{ isset($auto) ? route('autos.update', $auto->id) : route('autos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($auto))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label>Marca</label>
            <input type="text" name="marca" class="form-control" value="{{ old('marca', $auto->marca ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label>Modelo</label>
            <input type="text" name="modelo" class="form-control" value="{{ old('modelo', $auto->modelo ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label>Año</label>
            <input type="number" name="anio" class="form-control" value="{{ old('anio', $auto->anio ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label>Color</label>
            <input type="text" name="color" class="form-control" value="{{ old('color', $auto->color ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label>Transmisión</label>
            <input type="text" name="tipoTransmision" class="form-control" value="{{ old('tipoTransmision', $auto->tipoTransmision ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label>Kilometraje</label>
            <input type="number" name="km" class="form-control" value="{{ old('km', $auto->km ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label>Imagen</label>
            <input type="file" name="imagen" class="form-control" {{ isset($auto) ? '' : 'required' }}>
            @if(isset($auto) && $auto->imagen)
                <p class="mt-2">Imagen actual:</p>
                <img src="{{ Storage::url($auto->imagen) }}" width="120">
            @endif
        </div>
        <div class="mb-3">
            <label>Precio</label>
            <input type="number" name="precio" class="form-control" step="0.01" value="{{ old('precio', $auto->precio ?? '') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">
            {{ isset($auto) ? 'Actualizar Auto' : 'Agregar Auto' }}
        </button>
    </form>

    <hr>

    {{-- Tabla de autos --}}
    <h2>Lista de Autos</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Año</th>
                <th>Color</th>
                <th>Transmisión</th>
                <th>KM</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($autos as $a)
                <tr>
                    <td>{{ $a->marca }}</td>
                    <td>{{ $a->modelo }}</td>
                    <td>{{ $a->anio }}</td>
                    <td>{{ $a->color }}</td>
                    <td>{{ $a->tipoTransmision }}</td>
                    <td>{{ $a->km }}</td>
                    <td>
                        @if($a->imagen)
                            <img src="{{ Storage::url($a->imagen) }}" width="100">
                        @else
                            Sin imagen
                        @endif
                    </td>
                    <td>${{ number_format($a->precio, 2) }}</td>
                    <td>
                        <a href="{{ route('autos.edit', $a->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('autos.destroy', $a->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este auto?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
