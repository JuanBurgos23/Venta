<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Cierre de Caja</title>
    <style>
        body {
            font-family: monospace;
            font-size: 11px;
            width: 260px;
            /* 58mm aprox */
            margin: 0;
            padding: 0;
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
            border-top: 1px dashed #000;
            margin: 6px 0;
        }

        .row {
            display: flex;
            justify-content: space-between;
        }

        .mt {
            margin-top: 6px;
        }
    </style>
</head>

<body>

    {{-- ENCABEZADO --}}
    <div class="center bold">
        {{ $caja->empresa->nombre }}
    </div>
    <div class="center">
        CIERRE DE CAJA
    </div>

    <div class="line"></div>

    {{-- DATOS --}}
    Cajero: {{ $caja->usuario->name }} <br>
    Sucursal: {{ $caja->sucursal->nombre ?? '-' }} <br>
    Apertura: {{ $caja->fecha_apertura }} <br>
    Cierre: {{ $caja->fecha_cierre }}

    <div class="line"></div>

    {{-- VENTAS --}}
    <div class="bold">VENTAS</div>

    <div class="row">
        <span>Efectivo</span>
        <span>{{ number_format($ventasEfectivo, 2) }}</span>
    </div>

    <div class="row">
        <span>No efectivo</span>
        <span>{{ number_format($ventasNoEfectivo, 2) }}</span>
    </div>

    <div class="row bold">
        <span>Total ventas</span>
        <span>{{ number_format($totalVentas, 2) }}</span>
    </div>

    <div class="line"></div>

    {{-- MOVIMIENTOS --}}
    <div class="bold">MOVIMIENTOS VARIOS</div>

    <div class="row">
        <span>Ingresos</span>
        <span>{{ number_format($ingresosVarios, 2) }}</span>
    </div>

    <div class="row">
        <span>Egresos</span>
        <span>{{ number_format($egresos, 2) }}</span>
    </div>

    <div class="line"></div>

    {{-- CUADRE --}}
    <div class="bold">CUADRE DE CAJA</div>

    <div class="row">
        <span>Monto inicial</span>
        <span>{{ number_format($caja->monto_inicial, 2) }}</span>
    </div>

    <div class="row">
        <span>Efectivo esperado</span>
        <span>{{ number_format($efectivoEsperado, 2) }}</span>
    </div>

    <div class="row">
        <span>Efectivo declarado</span>
        <span>{{ number_format($caja->monto_final, 2) }}</span>
    </div>

    <div class="row bold">
        <span>Diferencia</span>
        <span>{{ number_format($diferencia, 2) }}</span>
    </div>

    <div class="line"></div>

    {{-- FIRMAS --}}
    <div class="center mt">
        ---------------------- <br>
        Firma Cajero
        <br><br>
        ---------------------- <br>
        Firma Administrador
    </div>

    <div class="center mt">
        Gracias por su trabajo
    </div>

</body>

</html>