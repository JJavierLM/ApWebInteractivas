<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Auto;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class VentasController extends Controller
{
    public function index()
    {
        if (!auth()->check() || !in_array(auth()->user()->role, ['empleado', 'admin'])) {
            abort(403);
        }

        $autos = Auto::all();
        return view('crudVentas', compact('autos'));
    }

    public function store(Request $request)
    {
        if (!auth()->check() || !in_array(auth()->user()->role, ['empleado', 'admin'])) {
            abort(403);
        }

        $request->validate([
            'nombre_comprador' => 'required|string|max:255',
            'fecha' => 'required|date',
            'hora' => 'required',
            'auto_id' => 'required|exists:autos,id',
        ]);

        Venta::create([
            'nombre_comprador' => $request->nombre_comprador,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'auto_id' => $request->auto_id,
            'user_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', '¡Venta registrada con éxito!');
    }

    public function misVentas()
    {
        if (!auth()->check() || !in_array(auth()->user()->role, ['empleado', 'admin'])) {
            abort(403);
        }

        $ventas = Venta::where('user_id', auth()->id())->with('auto')->get();
        return view('ventasUsuarios', compact('ventas'));
    }

    public function edit(string $id)
    {
        if (!auth()->check() || !in_array(auth()->user()->role, ['empleado', 'admin'])) {
            abort(403);
        }

        $venta = Venta::findOrFail($id);
        $autos = Auto::all();
        return view('editarVentas', compact('venta', 'autos'));
    }

    public function update(Request $request, string $id)
    {
        if (!auth()->check() || !in_array(auth()->user()->role, ['empleado', 'admin'])) {
            abort(403);
        }

        $request->validate([
            'nombre_comprador' => 'required|string|max:255',
            'fecha' => 'required|date',
            'hora' => 'required',
            'auto_id' => 'required|exists:autos,id',
        ]);

        $venta = Venta::findOrFail($id);
        $venta->update($request->only([
            'nombre_comprador',
            'fecha',
            'hora',
            'auto_id',
        ]));

        return redirect()->route('ventas.mis')->with('success', '¡Venta actualizada con éxito!');
    }

    public function destroy(string $id)
    {
        if (!auth()->check() || !in_array(auth()->user()->role, ['empleado', 'admin'])) {
            abort(403);
        }

        Venta::destroy($id);
        return redirect()->route('ventas.mis')->with('success', '¡Venta eliminada con éxito!');
    }

    public function reportePDF()
    {
        if (!auth()->check() || !in_array(auth()->user()->role, ['empleado', 'admin'])) {
            abort(403);
        }

        $ventas = Venta::with('auto')->where('user_id', auth()->id())->get();
        $pdf = Pdf::loadView('reporteVentas', compact('ventas'));

        return $pdf->download('reporte_ventas.pdf');
    }
}
