<h2>Reporte de Ventas</h2>
<table width="100%" border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Auto</th>
        </tr>
    </thead>
    <tbody>
        @foreach($ventas as $venta)
            <tr>
                <td>{{ $venta->fecha }}</td>
                <td>{{ $venta->hora }}</td>
                <td>{{ $venta->auto->marca }} {{ $venta->auto->modelo }} ({{ $venta->auto->año }})</td>
            </tr>
        @endforeach
    </tbody>
</table>
