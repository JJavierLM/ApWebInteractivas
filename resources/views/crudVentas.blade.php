@extends('layouts.app')

@section('content')

@if(!Auth::check() || !in_array(Auth::user()->role, ['empleado', 'admin']))
    @php abort(403); @endphp
@endif

<div class="container">
    <h2>Registrar Venta</h2>

    <form method="POST" action="{{ route('ventas.store') }}">
        @csrf
        <div class="form-group">
            <label>Nombre del comprador</label>
            <input type="text" name="nombre_comprador" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Fecha</label>
            <input type="date" name="fecha" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Hora</label>
            <input type="time" name="hora" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Auto vendido</label>
            <select name="auto_id" class="form-control" required>
                @foreach($autos as $auto)
                    <option value="{{ $auto->id }}">{{ $auto->marca }} {{ $auto->modelo }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success mt-3">Registrar Venta</button>
    </form>
</div>
@endsection
