@extends('layouts.app')

@section('content')

@if(!Auth::check() || !in_array(Auth::user()->role, ['empleado', 'admin']))
    @php abort(403); @endphp
@endif

<div class="container mt-4">
    <h2>Empleados registrados</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Formulario solo visible para admin --}}
    @if(auth()->user()->role === 'admin')
        <div class="card mb-4">
            <div class="card-header">Registrar nuevo empleado</div>
            <div class="card-body">
                <form action="{{ route('empleados.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label>Nombre:</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Email:</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Contraseña:</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Confirmar Contraseña:</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                    <button class="btn btn-success">Registrar Empleado</button>
                </form>
            </div>
        </div>
    @endif

    {{-- Tabla de empleados --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Editar / Eliminar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($empleados as $empleado)
            <tr>
                <td>{{ $empleado->name }}</td>
                <td>{{ $empleado->email }}</td>
                <td>
                    <a href="{{ route('empleados.edit', $empleado->id) }}" class="btn btn-sm btn-warning">Editar</a>

                    <form action="{{ route('empleados.destroy', $empleado->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('¿Eliminar este empleado?')" class="btn btn-sm btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
