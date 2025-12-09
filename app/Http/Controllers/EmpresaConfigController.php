<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmpresaConfig;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EmpresaConfigController extends Controller
{
    public function getConfig()
    {
        $empresaId = Auth::user()->id_empresa;

        $config = EmpresaConfig::where('id_empresa', $empresaId)->first();

        if (!$config) {
            $config = EmpresaConfig::create([
                'id_empresa' => $empresaId,
                'configuraciones' => [
                    'color_primario' => '#696cff',
                    'tema' => 'light',
                    'menu_layout' => 'expanded',
                    'navbar_type' => 'sticky',
                ]
            ]);
        }

        return response()->json($config->configuraciones);
    }

    public function saveConfig(Request $request)
    {
        $empresaId = Auth::user()->id_empresa;
        $config = EmpresaConfig::firstOrCreate(['id_empresa' => $empresaId]);

        $newConfig = array_merge($config->configuraciones ?? [], $request->all());
        $config->update(['configuraciones' => $newConfig]);

        return response()->json(['ok' => true, 'configuraciones' => $newConfig]);
    }
}
