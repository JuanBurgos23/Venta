<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Comprobante de Compra</title>
    <style>
        :root {
            --text: #111827;
            --muted: #6b7280;
            --accent: #2563eb;
        }

        body {
            font-family: "Inter", "Segoe UI", system-ui, -apple-system, sans-serif;
            color: var(--text);
            margin: 0;
            padding: 0;
            background: #ffffff;
        }

        .ticket {
            width: 420px;
            margin: 24px auto;
            padding: 16px 18px;
            box-sizing: border-box;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .line {
            border-top: 1px dashed #cbd5e1;
            margin: 6px 0;
        }

        .row {
            display: flex;
            justify-content: space-between;
        }

        .mt {
            margin-top: 6px;
        }

        .muted {
            color: var(--muted);
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 6px;
        }

        .badge {
            display: inline-block;
            padding: 2px 8px;
            font-size: 10px;
            border-radius: 999px;
            background: #eef2ff;
            color: #3730a3;
        }

        .print-bar {
            display: flex;
            justify-content: center;
            margin: 12px 0 0;
        }

        .btn-print {
            border: none;
            background: var(--accent);
            color: #fff;
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 13px;
            cursor: pointer;
        }

        .btn-print:active {
            transform: translateY(1px);
        }

        @media print {
            body {
                width: 58mm;
                margin: 0;
            }
            .ticket {
                width: 58mm;
                margin: 0;
                padding: 6mm 4mm;
            }
            .print-bar {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="ticket">

    {{-- ENCABEZADO --}}
    <div class="header">
        <div class="bold">{{ $empresa->nombre ?? 'Empresa' }}</div>
    </div>
    <div class="center muted">COMPROBANTE DE COMPRA</div>

    <div class="line"></div>

    {{-- DATOS --}}
    <div class="row">
        <span class="muted">Proveedor</span>
        <span>{{ trim(($compra->proveedor->nombre ?? '') . ' ' . ($compra->proveedor->paterno ?? '') . ' ' . ($compra->proveedor->materno ?? '')) ?: '-' }}</span>
    </div>
    <div class="row">
        <span class="muted">Factura</span>
        <span>{{ $compra->numero_factura ?? '-' }}</span>
    </div>
    <div class="row">
        <span class="muted">Fecha</span>
        <span>{{ $compra->fecha_ingreso }}</span>
    </div>
    <div class="row">
        <span class="muted">Almacén</span>
        <span>{{ $compra->almacen->nombre ?? '-' }}</span>
    </div>

    <div class="line"></div>

    {{-- DETALLE --}}
    <div class="bold">DETALLE</div>
    @foreach ($items as $it)
        <div class="mt">
            <div class="bold">{{ $it['producto'] }}</div>
            <div class="row">
                <span class="muted">{{ $it['cantidad'] }} x {{ number_format($it['costo_unitario'], 2) }}</span>
                <span>{{ number_format($it['costo_total'], 2) }}</span>
            </div>
        </div>
        @if (!empty($it['lote']))
            <div class="row">
                <span class="muted">Lote</span>
                <span>{{ $it['lote'] }}</span>
            </div>
        @endif
    @endforeach

    <div class="line"></div>

    {{-- TOTALES --}}
    <div class="row">
        <span class="muted">Subtotal</span>
        <span>{{ number_format($compra->subtotal, 2) }}</span>
    </div>
    <div class="row">
        <span class="muted">Descuento</span>
        <span>{{ number_format($compra->descuento, 2) }}</span>
    </div>
    <div class="row bold">
        <span>Total</span>
        <span>{{ number_format($compra->total, 2) }}</span>
    </div>

    <div class="line"></div>

    {{-- FIRMAS --}}
    <div class="center mt">
        ---------------------- <br>
        Firma Responsable
    </div>

    <div class="center mt">
        Gracias por su compra
    </div>

    <div class="print-bar">
        <button class="btn-print" type="button" onclick="window.print()">Imprimir</button>
    </div>
    </div>

</body>

</html>
