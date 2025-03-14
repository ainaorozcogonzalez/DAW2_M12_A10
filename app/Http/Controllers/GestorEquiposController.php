<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Incidencia;
use App\Models\User;
use App\Models\Prioridad;

class GestorEquiposController extends Controller
{
    public function vistagestor()
    {
        return view('/gestor.index');
    }

    public function datosincidencias(Request $request)
    {
        $incidencias = Incidencia::select(
            'incidencias.*',
            'c.nombre as clientenombre',
            't.nombre as tecniconombre',
            'ei.nombre as nombreestado',
            'pr.nombre as nombreprioridades'
        )
            ->leftJoin('users as c', 'c.id', '=', 'incidencias.cliente_id')
            ->leftJoin('users as t', 't.id', '=', 'incidencias.tecnico_id')
            ->leftJoin('estado_incidencias as ei', 'ei.id', '=', 'incidencias.estado_id')
            ->leftJoin('prioridades as pr', 'pr.id', '=', 'incidencias.prioridad_id')
            ->where('incidencias.sede_id', '=', Auth::user()->sede_id);

        if ($request->prioridad) {
            $prioridad = $request->prioridad;
            $incidencias->where('incidencias.prioridad_id', '=', "$prioridad");
        }

        if ($request->tecnico) {
            $incidencias->where('incidencias.tecnico_id', '=', $request->tecnico);
        }

        if ($request->orden) {
            if ($request->orden == 'numerico') {
                $incidencias->orderBy('incidencias.id');
            } else {
                $order = $request->orden == 'asc' ? 'asc' : 'desc';
                $incidencias->orderBy('incidencias.prioridad_id', $order);
            }
        } else {
            // Orden por defecto: numérico por ID de incidencia
            $incidencias->orderBy('incidencias.id');
        }

        if ($request->fechacreacion && $request->fechafin) {
            $fechacreacion = $request->fechacreacion . ' 00:00:00';
            $fechafin = $request->fechafin . ' 23:59:59';
            $incidencias->whereBetween('incidencias.created_at', [$fechacreacion, $fechafin]);
        } elseif ($request->fechacreacion) {
            $fechacreacion = $request->fechacreacion . ' 00:00:00';
            $incidencias->where('incidencias.created_at', '>=', $fechacreacion);
        } elseif ($request->fechafin) {
            $fechafin = $request->fechafin . ' 23:59:59';
            $incidencias->where('incidencias.created_at', '<=', $fechafin);
        }

        if ($request->fecha_creacion) {
            $fecha = $request->fecha_creacion . ' 00:00:00';
            $incidencias->whereDate('incidencias.created_at', '=', $fecha);
        }

        $incidencias = $incidencias->get();

        $tecnicos = User::select('id', 'nombre')
            ->where('rol_id', 4)
            ->where('sede_id', Auth::user()->sede_id)
            ->get();

        $prioridades = Prioridad::all();

        return response()->json(['incidencias' => $incidencias, 'tecnicos' => $tecnicos, 'prioridades' => $prioridades]);
    }

    public function editarprioridad(Request $request)
    {
        try {
            if ($request->assignaprioridad != "") {
                $resultado = Incidencia::find($request->id);
                $resultado->prioridad_id = $request->assignaprioridad;
                $resultado->save();
                echo "Asignada prioridad";
                die();
            } else {
                $resultado = Incidencia::find($request->id);
                $resultado->prioridad_id = null;
                $resultado->save();
                echo "Sin asignar";
                die();
            }
        } catch (\PDOException $e) {
            echo "error";
        }
    }

    public function editarassignar(Request $request)
    {
        try {
            if ($request->assignadopara != "") {
                // Verificar que el técnico pertenece a la misma sede que el gestor
                $tecnico = User::where('id', $request->assignadopara)
                    ->where('sede_id', Auth::user()->sede_id)
                    ->first();

                if (!$tecnico) {
                    throw new \Exception('El técnico no pertenece a tu sede');
                }

                $resultado = Incidencia::find($request->id);
                $resultado->tecnico_id = $request->assignadopara;
                $resultado->estado_id = 2;
                $resultado->save();
                echo "Tecnico asignado";
                die();
            } else {
                $resultado = Incidencia::find($request->id);
                $resultado->tecnico_id = null;
                $resultado->estado_id = 1;
                $resultado->save();
                echo "Sin asignar";
                die();
            }
        } catch (\PDOException $e) {
            echo "error";
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
