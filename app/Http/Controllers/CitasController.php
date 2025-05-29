<?php

namespace App\Http\Controllers;

use App\Models\Auto;
use App\Models\Cita;
use App\Mail\CitaRecordatorioMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CitasController extends Controller
{
    public function index()
    {
        // Todos pueden acceder, excepto empleados
        if (auth()->check() && auth()->user()->role === 'empleado') {
            abort(403);
        }

        $autos = Auto::all();
        return view('crudCitas', compact('autos'));
    }

    public function store(Request $request)
    {
        // Solo visitantes, clientes o admin pueden agendar citas
        if (auth()->check() && !in_array(auth()->user()->role, ['cliente', 'admin'])) {
            abort(403);
        }

        $request->validate([
            'nombre_cliente' => 'required|string|max:255',
            'fecha' => 'required|date',
            'hora' => 'required',
            'auto_id' => 'required|exists:autos,id',
        ]);

        Cita::create([
            'nombre_cliente' => $request->nombre_cliente,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'auto_id' => $request->auto_id,
            'user_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', '¡Cita agendada con éxito!');
    }

    public function citasUsuario()
    {
        if (!auth()->check() || auth()->user()->role !== 'cliente') {
            abort(403);
        }

        $citas = Cita::where('user_id', auth()->id())->with('auto')->get();
        return view('citasUsuarios', compact('citas'));
    }

    public function edit($id)
    {
        if (!auth()->check() || auth()->user()->role !== 'cliente') {
            abort(403);
        }

        $cita = Cita::where('user_id', auth()->id())->findOrFail($id);
        $autos = Auto::all();
        return view('editarCita', compact('cita', 'autos'));
    }

    public function update(Request $request, $id)
    {
        if (!auth()->check() || auth()->user()->role !== 'cliente') {
            abort(403);
        }

        $cita = Cita::where('user_id', auth()->id())->findOrFail($id);

        $request->validate([
            'fecha' => 'required|date',
            'hora' => 'required',
            'auto_id' => 'required|exists:autos,id',
        ]);

        $cita->update($request->only('fecha', 'hora', 'auto_id'));

        return redirect()->route('citas.mis')->with('success', 'Cita actualizada');
    }

    public function destroy($id)
    {
        if (!auth()->check() || auth()->user()->role !== 'cliente') {
            abort(403);
        }

        $cita = Cita::where('user_id', auth()->id())->findOrFail($id);
        $cita->delete();

        return redirect()->route('citas.mis')->with('success', 'Cita eliminada');
    }

    public function enviarCorreo($id)
    {
        if (!auth()->check() || auth()->user()->role !== 'cliente') {
            abort(403);
        }

        $cita = Cita::with(['auto', 'user'])->findOrFail($id);

        // Verifica que sea su propia cita
        if ($cita->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para enviar este correo.');
        }

        // Correo destino extra (puedes mover esto a .env/config si lo deseas)
        $correoFijoGmail = 'tucorreo@gmail.com';

        // Enviar correo
        Mail::to(auth()->user()->email)
            ->cc($correoFijoGmail)
            ->send(new CitaRecordatorioMail($cita));

        return redirect()->route('citas.mis')->with('success', 'Correo enviado correctamente.');
    }
}
