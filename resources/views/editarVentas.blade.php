@extends('layouts.app')

@section('content')

@if(!Auth::check() || Auth::user()->role !== 'empleado')
    @php abort(403); @endphp
@endif

<div class="container">
    <h2>Editar Venta</h2>

    <form method="POST" action="{{ route('ventas.update', $venta->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nombre del comprador</label>
            <input type="text" name="nombre_comprador" class="form-control" value="{{ $venta->nombre_comprador }}" required>
        </div>
        <div class="form-group">
            <label>Fecha</label>
            <input type="date" name="fecha" class="form-control" value="{{ $venta->fecha }}" required>
        </div>
        <div class="form-group">
            <label>Hora</label>
            <input type="time" name="hora" class="form-control" value="{{ $venta->hora }}" required>
        </div>
        <div class="form-group">
            <label>Auto vendido</label>
            <select name="auto_id" class="form-control" required>
                @foreach($autos as $auto)
                    <option value="{{ $auto->id }}" {{ $auto->id == $venta->auto_id ? 'selected' : '' }}>
                        {{ $auto->marca }} {{ $auto->modelo }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Actualizar Venta</button>
    </form>
</div>
@endsection
