<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Auto;

class AutosController extends Controller
{
    public function index()
    {
        $autos = Auto::all();
        return view('inicio', compact('autos'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'marca' => 'required',
            'modelo' => 'required',
            'anio' => 'required|integer',
            'color' => 'required',
            'tipoTransmision' => 'required',
            'km' => 'required|integer',
            'imagen' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'precio' => 'required|numeric',
        ]);

        // Guardar imagen en storage/app/public/imagenes
        $imagenPath = $request->file('imagen')->store('imagenes', 'public');

        Auto::create([
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'anio' => $request->anio,
            'color' => $request->color,
            'tipoTransmision' => $request->tipoTransmision,
            'km' => $request->km,
            'imagen' => $imagenPath,
            'precio' => $request->precio,
        ]);

        return redirect()->route('autos.crud')->with('success', 'Auto agregado correctamente');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $auto = Auto::findOrFail($id);
        $autos = Auto::all(); // para mantener la tabla al editar
        return view('crudAutos', compact('auto', 'autos'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'marca' => 'required',
            'modelo' => 'required',
            'anio' => 'required|integer',
            'color' => 'required',
            'tipoTransmision' => 'required',
            'km' => 'required|integer',
            'precio' => 'required|numeric',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $auto = Auto::findOrFail($id);

        // Verifica si se subió nueva imagen
        if ($request->hasFile('imagen')) {
            // Elimina la imagen anterior si existe
            if ($auto->imagen && Storage::disk('public')->exists($auto->imagen)) {
                Storage::disk('public')->delete($auto->imagen);
            }

            // Guarda la nueva imagen
            $imagenPath = $request->file('imagen')->store('imagenes', 'public');
            $auto->imagen = $imagenPath;
        }

        $auto->marca = $request->marca;
        $auto->modelo = $request->modelo;
        $auto->anio = $request->anio;
        $auto->color = $request->color;
        $auto->tipoTransmision = $request->tipoTransmision;
        $auto->km = $request->km;
        $auto->precio = $request->precio;

        $auto->save();

        return redirect()->route('autos.crud')->with('success', 'Auto actualizado correctamente');
    }

    public function destroy(string $id)
    {
        $auto = Auto::findOrFail($id);

        // Eliminar la imagen del disco si existe
        if ($auto->imagen && Storage::disk('public')->exists($auto->imagen)) {
            Storage::disk('public')->delete($auto->imagen);
        }

        $auto->delete();

        return redirect()->route('autos.crud')->with('success', 'Auto eliminado correctamente');
    }

    public function crud()
    {
        $autos = Auto::all();
        return view('crudAutos', compact('autos'));
    }


   
}
