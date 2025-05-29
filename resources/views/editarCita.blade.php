@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Cita</h2>

    <form method="POST" action="{{ route('citas.update', $cita->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Fecha</label>
            <input type="date" name="fecha" value="{{ $cita->fecha }}" required class="form-control">
        </div>

        <div class="mb-3">
            <label>Hora</label>
            <input type="time" name="hora" value="{{ $cita->hora }}" required class="form-control">
        </div>

        <div class="mb-3">
            <label>Auto</label>
            <select name="auto_id" class="form-control">
                @foreach($autos as $auto)
                    <option value="{{ $auto->id }}" {{ $auto->id == $cita->auto_id ? 'selected' : '' }}>
                        {{ $auto->marca }} {{ $auto->modelo }} ({{ $auto->año }})
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Guardar cambios</button>
    </form>
</div>
@endsection
