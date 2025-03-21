<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incidencia;
use App\Models\EstadoIncidencia;
use App\Models\Comentario;
use App\Models\Archivo;

class TecnicoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $incidencias = Incidencia::where('tecnico_id', auth()->id())
            ->with(['cliente', 'estado', 'prioridad'])
            ->when(request('hideClosed'), function($query) {
                $estadoCerrada = EstadoIncidencia::where('nombre', 'Cerrada')->first();
                if ($estadoCerrada) {
                    return $query->where('estado_id', '!=', $estadoCerrada->id);
                }
            })
            ->get();

        $estados = EstadoIncidencia::whereNotIn('nombre', ['Sin asignar', 'Cerrada'])->get();

        // Inicializamos $mensajes como un array vacío
        $mensajes = [];

        if (request()->ajax()) {
            return view('tecnico.partials.incidencias', compact('incidencias', 'estados', 'mensajes'));
        }

        return view('tecnico.dashboard', compact('incidencias', 'estados', 'mensajes'));
    }

    public function cambiarEstado(Request $request, Incidencia $incidencia)
    {
        $request->validate([
            'estado_id' => 'required|exists:estado_incidencias,id'
        ]);

        $incidencia->update(['estado_id' => $request->estado_id]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Estado de la incidencia actualizado correctamente');
    }

    public function enviarComentario(Request $request, Incidencia $incidencia)
    {
        $request->validate([
            'mensaje' => 'required|string|max:500'
        ]);

        Comentario::create([
            'incidencia_id' => $incidencia->id,
            'usuario_id' => auth()->id(),
            'mensaje' => $request->mensaje
        ]);

        return back()->with('success', 'Mensaje enviado correctamente');
    }

    public function obtenerMensajes(Incidencia $incidencia)
    {
        $mensajes = Comentario::with(['usuario', 'archivo'])
            ->where('incidencia_id', $incidencia->id)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($mensajes);
    }

    public function enviarMensaje(Request $request)
    {
        $request->validate([
            'incidencia_id' => 'required|exists:incidencias,id',
            'mensaje' => 'nullable|string|max:500',
            'archivo' => 'nullable|file|mimes:jpg,jpeg,png,pdf,webp,zip,rar,tar,gz|max:20480',
        ]);

        // Crear el comentario
        $comentario = Comentario::create([
            'incidencia_id' => $request->incidencia_id,
            'usuario_id' => auth()->id(),
            'mensaje' => $request->mensaje ? htmlspecialchars($request->mensaje) : null,
        ]);

        // Si se adjunta un archivo, guardarlo relacionado con el comentario
        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            $ruta = $archivo->store('archivos', 'public');
            $rutaPublica = asset('storage/' . $ruta);

            // Mapear el tipo MIME a uno de los valores permitidos en el enum
            $tipoMime = $archivo->getMimeType();
            $tipo = match (true) {
                str_contains($tipoMime, 'image') => 'imagen',
                str_contains($tipoMime, 'pdf') => 'pdf',
                default => 'otro',
            };

            $comentario->archivo()->create([
                'url_archivo' => $rutaPublica,
                'tipo' => $tipo,
            ]);
        }

        return response()->json(['success' => true]);
    }
}
