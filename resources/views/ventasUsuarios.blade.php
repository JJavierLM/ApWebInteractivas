@extends('layouts.app')

@section('content')

@if(!Auth::check() || Auth::user()->role !== 'empleado')
    @php abort(403); @endphp
@endif

<div class="container">
    <h2>Mis Ventas</h2>

    @foreach ($ventas as $venta)
        <div class="card my-3 p-3">
            <p><strong>Comprador:</strong> {{ $venta->nombre_comprador }}</p>
            <p><strong>Fecha:</strong> {{ $venta->fecha }}</p>
            <p><strong>Hora:</strong> {{ $venta->hora }}</p>
            <p><strong>Auto:</strong> {{ $venta->auto->marca }} {{ $venta->auto->modelo }} ({{ $venta->auto->anio }})</p>

            <a href="{{ route('ventas.edit', $venta->id) }}" class="btn btn-primary">Editar</a>

            <form action="{{ route('ventas.destroy', $venta->id) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Eliminar</button>
            </form>
        </div>
    @endforeach

    <div>
        <a href="{{ route('ventas.reporte') }}" class="btn btn-success mb-3">Generar reporte de ventas</a>
    </div>
</div>
@endsection
