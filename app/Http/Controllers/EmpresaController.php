<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EmpresaController extends Controller
{
    public function index()
    {
        return view('empresa.empresa');
    }
    public function edit($id)
    {
        $user = Auth::user();

        $query = Empresa::query();

        // Si el usuario no es Administrador, solo puede acceder a su empresa
        if (!$user->hasRole('Administrador')) {
            $query->where('id', $user->id_empresa ?? 0);
        }

        $empresa = $query->findOrFail($id);

        return response()->json($empresa);
    }

    public function fetch(Request $request)
    {
        $search  = $request->input('search', '');
        $perPage = (int) $request->input('per_page', 10);
        $page    = (int) $request->input('page', 1);

        $user = Auth::user();
        $empresaId = $user->id_empresa ?? null;

        $query = Empresa::query();

        // Siempre limitar a la empresa del usuario; si no tiene, devolver vacío
        if ($empresaId) {
            $query->where('id', $empresaId);
        } else {
            return response()->json([
                'data' => [],
                'current_page' => 1,
                'last_page' => 1,
                'total' => 0,
            ]);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('telefono', 'like', "%{$search}%")
                    ->orWhere('correo', 'like', "%{$search}%")
                    ->orWhere('nit', 'like', "%{$search}%")
                    ->orWhere('direccion', 'like', "%{$search}%");
            });
        }

        $empresas = $query
            ->orderByDesc('id')
            ->paginate($perPage, ['*'], 'page', $page);

        return response()->json($empresas);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre'   => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'correo'   => 'nullable|email|max:255',
            'logo'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // max 2MB
            'qr'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // max 2MB
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $validator->errors()->first()
            ], 200);
        }

        $user = Auth::user();

        $logoPath = $request->hasFile('logo')
            ? $request->file('logo')->store('logos_empresas', 'public')
            : null;

        $qrPath = $request->hasFile('qr')
            ? $request->file('qr')->store('qr_empresas', 'public')
            : null;

        $empresa = Empresa::create([
            'nombre'    => $request->nombre,
            'telefono'  => $request->telefono,
            'correo'    => $request->correo,
            'logo'      => $logoPath,
            'qr'        => $qrPath,
            'direccion' => $request->direccion,
            'nit'       => $request->nit,
        ]);

        Cliente::create([
            'nombre'     => 'Cliente General',
            'id_empresa' => $empresa->id,
        ]);

        $user->id_empresa = $empresa->id;
        $user->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Empresa registrada correctamente',
            'empresa' => $empresa
        ], 200);
    }


    public function update(Request $request, $id)
    {
        $empresa = Empresa::find($id);

        if (!$empresa) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Empresa no encontrada'
            ], 200);
        }

        $validator = Validator::make($request->all(), [
            'nombre'   => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'correo'   => 'nullable|email|max:255',
            'logo'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'qr'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $validator->errors()->first()
            ], 200);
        }

        // Subida de nuevo logo (opcional)
        if ($request->hasFile('logo')) {
            // eliminar logo anterior si existe
            if ($empresa->logo && Storage::disk('public')->exists($empresa->logo)) {
                Storage::disk('public')->delete($empresa->logo);
            }
            $empresa->logo = $request->file('logo')->store('logos_empresas', 'public');
        }

        // Subida de nuevo QR (opcional)
        if ($request->hasFile('qr')) {
            // eliminar qr anterior si existe
            if ($empresa->qr && Storage::disk('public')->exists($empresa->qr)) {
                Storage::disk('public')->delete($empresa->qr);
            }
            $empresa->qr = $request->file('qr')->store('qr_empresas', 'public');
        }

        $empresa->nombre    = $request->nombre;
        $empresa->telefono  = $request->telefono;
        $empresa->correo    = $request->correo;
        $empresa->direccion = $request->direccion;
        $empresa->nit       = $request->nit;
        $empresa->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Empresa actualizada correctamente',
            'empresa' => $empresa
        ], 200);
    }
    public function getQr($id)
    {
        $user = Auth::user();

        $query = Empresa::query();

        // Si el usuario no es Administrador, solo puede acceder a su empresa
        if (!$user->hasRole('Administrador')) {
            $query->where('id', $user->id_empresa ?? 0);
        }

        $empresa = $query->findOrFail($id);

        // URL completa del QR si existe
        $qrUrl = $empresa->qr ? asset('storage/' . $empresa->qr) : null;

        return response()->json([
            'id' => $empresa->id,
            'nombre' => $empresa->nombre,
            'qr_url' => $qrUrl,
        ]);
    }
}
