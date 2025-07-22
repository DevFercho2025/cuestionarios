<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Evaluaciones asignadas</title>
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
    <div class="container">
        <img src="{{ $message->embed($logoPath) }}" alt="Logo ALOBRI" style="max-width: 150px;">
        <h2>¡Hola {{ $candidateName }}!</h2>

        @if ($testsCount === 1)
            <span>Te ha sido asignada <strong>1</strong> evaluación</span>
        @else
            <span>Te han sido asignadas <strong>{{ $testsCount }}</strong> evaluaciones </span>
        @endif
        <span>para realizar como parte de tu proceso de selección en <strong>{{ $company }}</strong> para la vacante de <strong>{{ $code->vacancy }}</strong>: <br> </span>
        <br>

        @foreach($assignedTests as $assignedTest)
            <li>{{ $assignedTest->test_title }}</li>
        @endforeach

        <p>Para comenzar, haz clic en el siguiente botón, e inicia sesión como candidato con el código <strong>{{ $code->code }}</strong> </p>

        <p style="text-align: center;">
            <a href="{{ $loginURL }}" class="btn">Acceder a mis evaluaciones</a>
        </p>

        <p style="margin-top: 50px;">Si tienes preguntas, no dudes en contactarnos en Contacto@alobri.com</p>

        <div class="footer">
            Este mensaje fue enviado automáticamente por el sistema de evaluación. Por favor, no respondas directamente a este correo.
        </div>
    </div>
</body>
</html>