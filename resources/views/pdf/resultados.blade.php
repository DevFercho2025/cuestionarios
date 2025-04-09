<!DOCTYPE html>
<html>
<head>
    <title>Resultados</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 8px; }
    </style>
</head>
<body>
    <h1>Informe de Resultados</h1>

    <p><strong>Nombre y apellidos:</strong> {{ $usuario->name }}</p>
    <p><strong>Correo:</strong> {{ $usuario->email }}</p>
    <p><strong>Vacante:</strong> {{ $aplicacion->cargo_aplicado ?? '--' }}</p>

    <table>
        <thead>
            <tr>
                <th>Pregunta</th>
                <th>Respuesta del Usuario</th>
                <th>Respuesta Correcta</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($respuestas as $respuesta)
                <tr>
                    <td>{{ $respuesta->pregunta->pregunta ?? 'N/A' }}</td>
                    <td>{{ $respuesta->respuesta->respuesta ?? 'Sin respuesta' }}</td>
                    <td>{{ $respuesta->respuestaCorrecta->respuesta->respuesta ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>