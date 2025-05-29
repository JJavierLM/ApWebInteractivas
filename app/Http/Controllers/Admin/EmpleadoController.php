<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class EmpleadoController extends Controller
{
    /**
     * Verifica si el usuario autenticado es administrador.
     */
    private function esAdmin(): bool
    {
        return Auth::check() && Auth::user()->role === 'admin';
    }

    /**
     * Mostrar la lista de empleados.
     */
    public function index()
    {
        $empleados = User::where('role', 'empleado')->get();
        return view('crudEmpleados', compact('empleados'));
    }

    /**
     * Registrar un nuevo empleado.
     */
    public function store(Request $request)
    {
        if (!$this->esAdmin()) {
            abort(403, 'No autorizado');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'role'     => 'empleado',
        ]);

        return redirect()->route('empleados.index')->with('success', 'Empleado registrado correctamente');
    }

    /**
     * Mostrar el formulario de edición de un empleado.
     */
    public function edit($id)
    {
        if (!$this->esAdmin()) {
            abort(403, 'No autorizado');
        }

        $empleado = User::where('role', 'empleado')->findOrFail($id);
        $empleados = User::where('role', 'empleado')->get();

        return view('crudEmpleados', compact('empleados', 'empleado'))->with('editar', $empleado);
    }

    /**
     * Actualizar los datos del empleado.
     */
    public function update(Request $request, $id)
    {
        if (!$this->esAdmin()) {
            abort(403, 'No autorizado');
        }

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $empleado = User::where('role', 'empleado')->findOrFail($id);
        $empleado->update($request->only('name', 'email'));

        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado correctamente');
    }

    /**
     * Eliminar un empleado.
     */
    public function destroy($id)
    {
        if (!$this->esAdmin()) {
            abort(403, 'No autorizado');
        }

        $empleado = User::where('role', 'empleado')->findOrFail($id);
        $empleado->delete();

        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado correctamente');
    }
}
