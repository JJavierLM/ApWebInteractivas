@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Agendar Cita</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('citas.store') }}">
        @csrf
        <div class="mb-3">
            <label for="nombre_cliente" class="form-label">Nombre del cliente</label>
            <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente" required>
        </div>

        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" class="form-control" id="fecha" name="fecha" required>
        </div>

        <div class="mb-3">
            <label for="hora" class="form-label">Hora</label>
            <input type="time" class="form-control" id="hora" name="hora" required>
        </div>

        <div class="mb-3">
            <label for="auto_id" class="form-label">Auto de interés</label>
            <select class="form-select" name="auto_id" id="auto_id" required>
                <option value="">-- Selecciona un auto --</option>
                @foreach($autos as $auto)
                    <option value="{{ $auto->id }}">
                        {{ $auto->marca }} {{ $auto->modelo }} ({{ $auto->anio }})
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Agendar Cita</button>
    </form>
</div>
@endsection
