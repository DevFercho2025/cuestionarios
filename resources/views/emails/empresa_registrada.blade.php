<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Empresa Registrada</title>
    <style>
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4c5baf;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            font-family: Arial, sans-serif;
            padding: 24px;
            background-color: #f9f9f9;
            border-radius: 8px;
        }
        .footer {
            margin-top: 24px;
            font-size: 12px;
            color: #999;
        }
    </style>
</head>
<body>
    <h3>Vista Preliminar del correo que se envía al registrarse una empresa:</h3>
    <div class="container">
        <img src="{{ $message->embed($logoPath) }}" alt="Logo ALOBRI" style="max-width: 150px;">
        <br><br>

        <p>¡Bienvenido a bordo, {{ $companyName }}!</p>

        <p> {{ $companyUser }}, nos alegra que haya registrado su empresa para comenzar a usar <strong>Psicométricas</strong>. A partir de ahora, podrá asignar evaluaciones y obtener reportes.</p>
        <p>Como bienvenida, tiene <strong>{{ $availableTests }}</strong> tests disponibles para ser asignados por su equipo desde ya. Para comenzar, haga clic en el siguiente botón, e inicie sesión como Empresa con su correo y contraseña registrados.</p>
        <br>
        <p style="text-align: center;">
            <a href="{{ $loginURL }}" class="btn">Acceder a mi dashboard</a>
        </p>

        <p style="margin-top: 50px;"> Si necesita ayuda para empezar, no dude en contactarnos en ejemplo@email.com. ¡Estamos aquí para ayudar y sacar el máximo provecho!</p>
        <span>Atentamente,</span><br>
        <span style="color: #4c5baf;">Equipo de Alobri</span>

        <div class="footer">
            Este mensaje fue enviado automáticamente por el sistema de Psicométricas. Por favor, no responda directamente a este correo.
        </div>
    </div>
</body>
</html>