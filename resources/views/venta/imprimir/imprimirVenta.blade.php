<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Nota de Venta - {{ $venta->codigo }}</title>
    <link rel="icon" type="image/x-icon" href="{{asset('assets/img/favicon/gato.svg')}}">
    <style>
        /* Tamaño de papel térmico 80mm de ancho */
        @page {
            size: 80mm auto;
            margin: 0;
        }

        body {
            width: 80mm;
            /* ancho del rollo */
            font-family: 'Courier New', monospace;
            font-size: 12px;
            margin: 0;
            padding: 5px;
            color: #000;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .separator {
            border-top: 1px dashed #000;
            margin: 5px 0;
        }

        .bold {
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 2px 0;
        }

        .logo {
            width: 60px;
            height: auto;
            margin: 0 auto 5px;
            display: block;
        }

        /* Evitar que el navegador reduzca el tamaño */
        @media print {
            body {
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>
    @php
    $fecha = \Carbon\Carbon::parse($venta->fecha);
    @endphp

    @if($empresa->logo && $logoBase64)
    <img src="{{ $logoBase64 }}" alt="Logo" class="logo">
    @endif

    <div class="text-center bold">{{ $empresa->nombre }}</div>
    <div class="text-center">Tel: {{ $empresa->telefono }}</div>

    <div class="separator"></div>

    <div class="bold text-center">NOTA DE VENTA</div>

    <div>Fecha: {{ $fecha->format('Y-m-d') }}</div>
    <div>Hora: {{ $fecha->format('H:i') }}</div>

    <div class="separator"></div>

    <div class="bold">Cliente:</div>
    <div>Nombre: {{ $venta->cliente->nombre ?? '-' }}</div>
    <div>CI: {{ $venta->cliente->ci ?? '-' }}</div>
    <div>Tel: {{ $venta->cliente->telefono ?? '-' }}</div>

    <div class="separator"></div>

    <div class="bold">Detalle:</div>
    @foreach($venta->detalles as $d)
    <div>
        {{ $d->producto->nombre ?? $d->nombre }}<br>
        {{ number_format($d->cantidad,2) }} x {{ number_format($d->precio_unitario,2) }}
        <span class="text-right">Bs/ {{ number_format($d->subtotal,2) }}</span>
    </div>
    @endforeach

    <div class="separator"></div>

    <table>
        <tr>
            <td>Total:</td>
            <td class="text-right">Bs/ {{ number_format($venta->total,2) }}</td>
        </tr>
        <tr>
            <td>Descuento {{ $venta->descuento ?? 0 }}%:</td>
            <td class="text-right">Bs/ {{ number_format($venta->descuento_monto ?? 0,2) }}</td>
        </tr>
        <tr class="bold">
            <td>Total a pagar:</td>
            <td class="text-right">Bs/ {{ number_format($venta->total - ($venta->descuento_monto ?? 0),2) }}</td>
        </tr>
    </table>

    <div class="separator"></div>

    <div>Cajero: {{ $venta->usuario->name ?? '-' }}</div>
    <div>Comprobante: {{ $venta->codigo }}</div>
    <div class="text-center">Hecho por www.Tuxon.com</div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>