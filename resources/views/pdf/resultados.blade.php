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

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .header {
            background-color: #305ca8;
            color: white;
            display: flex; 
            justify-content: space-between;
            padding: 10px 20px;
            height: auto; 
        }
        .logo-empresa{
            width: 60px;
            height: 60px;
            object-fit: contain;
        }
        .slogan{
            font-size: 14px;
            display: flex;
            align-items: flex-end;
            justify-self: flex-end;
        }
        .fondo{
            background-color: #eaeaea;
        }

        .titulo-test {
            display: block;
            margin: 0 auto;
            background-color: white; 
            top: 20px;
            z-index: 1;
            border-radius: 25px;
            padding: 10px 20px;
            padding-left: 50px;
            padding-right: 50px; 
            text-align: center;
            width: fit-content;
            font-weight: bold;
            font-size: 24px;
            box-shadow: 0 -6px 8px rgba(0, 0, 0, 0.1);
            transform: translateY(70%);
        }

        .contenedor-seccion {
            display: flex;
            background-color: white;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap; /* Permite que los divs se envuelvan en filas si la pantalla es pequeña */
            margin: 10px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 10px;
        }
        .seccion-1 {
            justify-content: space-around;
            align-items: center;
        }

        .info-candidato > div {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 200px;
        }

        .foto-candidato {
            width: 100%;
            max-width: 150px;
            height: 150px;
            border-radius: 50%; 
            object-fit: cover;
            margin: 0 auto;
        }

        .icono-puntuacion {
            width: 1.5em;
            height: 1.5em;
            vertical-align: middle; 
            margin-right: 5px;
        }

        .calificadores{
            padding: 20px; 
        }

        .calificadores ul {
            padding: 0;
            list-style: none;
        }

        .calificadores li {
            margin-bottom: 15px; 
            display: flex;
            align-items: center; 
        }

        .calificadores li span {
            margin-right: 10px; 
            font-size: 1.2em;
        }


        .grafica-comparacin {
            max-width: 100%; 
            width: 300px;
            height: auto;
            display: block;
            margin-top: 10px;
        }

        .contenedor-seccion.seccion-3 {
    display: flex;
    flex-direction: column; /* Título encima de las columnas */
    gap: 20px; /* Espacio entre el título y las columnas */
}

.contenedor-seccion.seccion-3 .informacion-prueba {
    display: flex;
    justify-content: space-between; /* Distribuye las columnas con espacio entre ellas */
    gap: 20px; /* Espacio entre las columnas */
}

.contenedor-seccion.seccion-3 .informacion-prueba > div {
    flex: 1; /* Las columnas ocupan el mismo tamaño */
    min-width: 280px; /* Evita que las columnas sean demasiado estrechas en pantallas pequeñas */
    box-sizing: border-box; /* Incluye el padding y border dentro del tamaño del div */
}


        .icono-puntuacion {
            width: 1.5em;
            height: 1.5em;
            vertical-align: middle; 
            margin-right: 5px;
        }

        .footer {
            display: flex;
            justify-content: space-between;
            padding: 10px 20px;
        }
        
    </style>

    <div class="header">
        <img  class="logo-empresa" src="{{ asset('storage/logos/logoAlobri.jpeg') }}">
        <div class="slogan"><span>Ensuring Personnel Integrity</span></div>
    </div>
    
    <div class="fondo">
        <div class="titulo-test">IntegriTest</div>
        <div class="contenedor-seccion seccion-1">
            <div>
                <img class="foto-candidato" src="{{ asset('storage/logos/logoAlobri.jpeg') }}">
            </div>
            
            <div>
                <p><strong>Nombre:</strong> {{ $usuario->name }}</p>
                <p><strong>RFC:</strong> {{ $usuario->rfc ?? '---' }}</p>
                <p><strong>Fecha:</strong> {{ now()->format('d/m/Y') }}</p>
            </div>
            <div>
                <p><strong>Cuenta:</strong> <!--{//{ $aplicacion->cuenta ?? '---' }}--></p>
                <p><strong>Cargo:</strong> {{ $aplicacion->cargo_aplicado ?? '---' }}</p>
                <p><strong>Idioma:</strong> Español</p>
            </div>
        </div>

        <div class="contenedor-seccion seccion-2">
            <div class="puntuacion-general">
                <div>
                    <img  class="icono-puntuacion" src="{{ asset('storage/logos/logoAlobri.jpeg') }}">
                    <span>Puntuación general</span>
                </div>
                <div class="calificadores">
                    <ul style="list-style: none; padding: 0;">
                        <li><span style="color: green;">■</span> Recomendado</li>
                        <li><span style="color: #a6d96a;">■</span> Se requiere aclaración</li>
                        <li><span style="color: orange;">■</span> Marginal</li>
                        <li><span style="color: red;">■</span> No recomendado</li>
                        <li><span style="color: black;">■</span> Sin resultados</li>
                    </ul>
                </div>
            </div>
            <div class="grafico">
                <img  class="icono-puntuacion" src="{{ asset('storage/logos/logoAlobri.jpeg') }}">
                <span>Comparación</span>
                <img  class="grafica-comparacin" src="{{ asset('storage/logos/logoAlobri.jpeg') }}">
            </div>
            <div class="resumen">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </p>
            </div>
        </div>

        <div class="contenedor-seccion seccion-3">
            <div>
                <img  class="icono-puntuacion" src="{{ asset('storage/logos/logoAlobri.jpeg') }}">
                <span>Información de la prueba</span>
            </div>

            <div class="informacion-prueba">
                <div style="flex: 1;">
                    <p><strong>Correo electrónico:</strong> {{ $usuario->email }}</p>
                    <p><strong>Número telefónico:</strong> {{ $usuario->telefono ?? '---' }}</p>
                    <!--{//{ $token->created_at->format('d/m/Y H:i') }}-->
                    <p><strong>Fecha de registro:</strong> </p>
                    <p><strong>Fecha de Inicio de la Prueba:</strong> </p>
                    <p><strong>Fecha de Finalización de la Prueba:</strong> </p>
                </div>
                <div style="flex: 1;">
                    <p><strong>Decisión de contratación:</strong> {{ $aplicacion->nombre_evaluacion }}</p>
                    <p><strong>Puntuación general:</strong> Se requiere aclaración</p>
                    <p><strong>Tipo de prueba:</strong> Integridad</p>
                    <p><strong>Nombre de la evalaución</strong> Integridad</p>
                    <p><strong>Cuenta Principal</strong> Integridad</p>
                </div>
                <div style="flex: 1;">
                    <p><strong>Tipo de registro:</strong> Reclutador</p>
                    <p><strong>Registrado por:</strong> Web</p>
                    <!--{//{ $token->created_at->format('d/m/Y H:i') }}-->
                    <p><strong>Ingresando desde:</strong></p>
                    <p><strong>Fecha de envío de la liga de pruebas:</strong> </p>
                </div>
            </div>
            
        </div>

        <div class="footer">
            <span>{{ now()->format('d/m/Y') }}</span>
            <span>página 1 de 5</span>
        </div>
        
    </div>
    

    
    <!--
        <h1>Informe de Resultados</h1>

        <p><strong>Nombre y apellidos:</strong> {//{ $usuario->name }}</p>
        <p><strong>Correo:</strong> {//{ $usuario->email }}</p>
        <p><strong>Vacante:</strong> {//{ $aplicacion->cargo_aplicado ?? '--' }}</p>

        <table>
            <thead>
                <tr>
                    <th>Pregunta</th>
                    <th>Respuesta del Usuario</th>
                    <th>Respuesta Correcta</th>
                </tr>
            </thead>
            <tbody>
                @//foreach ($respuestas as $respuesta)
                    <tr>
                        <td>{//{ $respuesta->pregunta->pregunta ?? 'N/A' }}</td>
                        <td>{//{ $respuesta->respuesta->respuesta ?? 'Sin respuesta' }}</td>
                        <td>{//{ $respuesta->respuestaCorrecta->respuesta->respuesta ?? 'N/A' }}</td>
                    </tr>
                @//endforeach
            </tbody>
        </table>
    -->
</body>
</html>