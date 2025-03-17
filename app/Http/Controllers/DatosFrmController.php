<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subcategoria;

use function Pest\Laravel\get;

class DatosFrmController extends Controller
{
    public function mostrarusuarios(Request $request)
    {
        $usuarios = User::where('sede_id', $request->id)->where('rol_id', 2)->get();
        $tecnicos = User::where('sede_id', $request->id)->where('rol_id', 4)->get();
        return response()->json(['usuarios' => $usuarios, 'tecnicos' => $tecnicos]);
    }

    public function mostrarsubcategorias(Request $request)
    {
        $subcat = Subcategoria::where('categoria_id', $request->id)->get();
        return response()->json($subcat);
    }
}
