<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(Request $request): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Determinar si es registro de empleado (por el admin)
        $isEmpleado = $request->routeIs('registro.empleado.store');

        // Seguridad: solo admin puede registrar empleados
        if ($isEmpleado && (!Auth::check() || Auth::user()->role !== 'admin')) {
            abort(403, 'Solo el administrador puede registrar empleados.');
        }

        $role = $isEmpleado ? 'empleado' : 'cliente';

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $role,
        ]);

        event(new Registered($user));

        if ($role === 'empleado') {
            return redirect()->route('admin.empleados.index')->with('success', 'Empleado registrado correctamente');
        }

        Auth::login($user);
        return redirect()->route('dashboard');
    }
}
