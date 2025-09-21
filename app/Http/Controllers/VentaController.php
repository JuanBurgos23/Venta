<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Producto;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function index()
    {
        return view('venta.venta');
    }
    public function fetchProducto(Request $request)
    {
        $empresaId = auth()->user()->id_empresa; // filtrar por empresa
        $productos = Producto::deEmpresa($empresaId)
            ->with('categoria') // opcional, si quieres incluir nombre de categoría
            ->get();

        $data = $productos->map(function ($p) {
            return [
                'id'       => $p->id,
                'name'     => $p->nombre,
                'price'    => $p->tipoPrecio ? $p->tipoPrecio->valor ?? 0 : 0, // ajustar si tienes precios
                'category' => $p->categoria_id,
                'stock'    => $p->inventariable ?? 0, // o usa tu campo real de stock
                'image'    => $p->foto ? asset('storage/' . $p->foto) : null,
            ];
        });

        return response()->json($data);
    }
    public function search(Request $request)
    {
        $empresaId = auth()->user()->id_empresa; // filtrar por empresa
        $query = $request->input('query');

        $productos = Producto::deEmpresa($empresaId)
            ->with(['categoria', 'tipoPrecio']) // si quieres incluir relaciones
            ->where(function ($q) use ($query) {
                $q->where('nombre', 'LIKE', "%{$query}%")
                    ->orWhere('descripcion', 'LIKE', "%{$query}%");
            })
            ->limit(10)
            ->get();

        $data = $productos->map(function ($p) {
            return [
                'id'       => $p->id,
                'name'     => $p->nombre,
                'price'    => $p->tipoPrecio ? ($p->tipoPrecio->valor ?? 0) : 0, // misma lógica que fetchProducto
                'category' => $p->categoria_id,
                'stock'    => $p->inventariable ?? 0,
                'image'    => $p->foto ? asset('storage/' . $p->foto) : null,
            ];
        });

        return response()->json($data);
    }
    public function fetchJson(Request $request)
    {
        $empresaId = auth()->user()->id_empresa;

        $categorias = Categoria::where('id_empresa', $empresaId)
            ->withCount('subcategorias') // opcional, si quieres info extra
            ->orderBy('nombre')
            ->get();

        $data = $categorias->map(function ($c) {
            return [
                'id'   => $c->id,
                'name' => $c->nombre,      // uniforme con 'name' en productos
                'subcategories_count' => $c->subcategorias_count ?? 0, // opcional
            ];
        });

        return response()->json($data);
    }
    public function fetchClientes(Request $request)
    {
        $empresaId = auth()->user()->id_empresa;
        $clientes = Cliente::where('id_empresa', $empresaId)
            ->select('id', 'nombre', 'ci', 'telefono', 'paterno')
            ->orderBy('nombre')
            ->get();

        return response()->json($clientes);
    }
    public function buscarPorCodigo($codigo)
    {
        $empresaId = auth()->user()->id_empresa; // filtrar por empresa

        $producto = Producto::deEmpresa($empresaId)
            ->with(['categoria', 'tipoPrecio'])
            ->where('codigo', $codigo) // <-- ajusta al nombre de tu campo real
            ->first();

        if (!$producto) {
            return response()->json(null, 404); // devolver 404 si no existe
        }

        $data = [
            'id'       => $producto->id,
            'name'     => $producto->nombre,
            'price'    => $producto->tipoPrecio ? ($producto->tipoPrecio->valor ?? 0) : 0,
            'category' => $producto->categoria_id,
            'stock'    => $producto->inventariable ?? 0,
            'image'    => $producto->foto ? asset('storage/' . $producto->foto) : null,
        ];

        return response()->json($data);
    }
}
