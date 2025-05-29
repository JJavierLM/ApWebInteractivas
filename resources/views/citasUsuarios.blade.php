@extends('layouts.app') 

@section('content')
<div class="container">
    <h2>Mis Citas</h2>

    {{-- Mensaje de confirmación --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Listado de citas --}}
    @foreach ($citas as $cita)
        <div class="card my-3 p-3">
            <p><strong>Fecha:</strong> {{ $cita->fecha }}</p>
            <p><strong>Hora:</strong> {{ $cita->hora }}</p>
            <p><strong>Auto:</strong> {{ $cita->auto->marca }} {{ $cita->auto->modelo }} ({{ $cita->auto->año }})</p>

            <div class="d-flex gap-2">
                {{-- Editar --}}
                <a href="{{ route('citas.edit', $cita->id) }}" class="btn btn-primary">Editar</a>

                {{-- Eliminar --}}
                <form action="{{ route('citas.destroy', $cita->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta cita?')">
                        Eliminar
                    </button>
                </form>

                {{-- Enviar correo --}}
                <form action="{{ route('citas.enviarCorreo', $cita->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-secondary">
                        Enviar correo
                    </button>
                </form>
            </div>
        </div>
    @endforeach
</div>
@endsection
