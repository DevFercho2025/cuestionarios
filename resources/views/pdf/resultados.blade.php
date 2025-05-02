<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Resultados</title>
        <link rel="stylesheet" href="{{ public_path('assets/css/pdf.css') }}">
        <!--Para dompdf, cambiar asset en los src por public_path-->
</head>
<body>
    <div class="header">
        <img  class="logo-empresa" src="{{ asset('storage/logos/logoAlobri.jpeg') }}">
        <div class="slogan"><span>Ensuring Personnel Integrity</span></div>
    </div>

    <div class="content">
        <div class="fondo">
            <section class="pagina-uno">
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
    
            </section>
            
            <section class="pagina-dos">
                <div class="contenedor-seccion">
                    <img  class="icono-seccion-metrica" src="{{ asset('storage/logos/logoAlobri.jpeg') }}">
                    <p>Puntuación por medida. Basado en normas de población relevante</p>
                    @foreach($metricas as $metrica)
                        <div class="contenedor-metrica">
                            <h5>{{ $metrica['titulo']}}</h5>
                            <div class="seccion-metrica">
                                <div class="linea-metrica">
                                    <div class="etiqueta-izq">{{ $metrica['etiqueta_izq'] }}</div>
                                        <div class="contenedor">
                                            <div class="separador izquierda"></div>
                                                <div class="linea">
                                                <div class="numeros">
                                                    <span>0</span>
                                                    <span>10</span>
                                                    <span>20</span>
                                                    <span>30</span>
                                                    <span>40</span>
                                                    <span>50</span>
                                                    <span>60</span>
                                                    <span>70</span>
                                                    <span>80</span>
                                                    <span>90</span>
                                                    <span>100</span>
                                                </div>
                                                <div class="puntuacion" style="left: {{ $metrica['puntuacion'] -1}}%;">
                                                    {{ $metrica['puntuacion'] }}
                                                </div>
                                                </div>
                                            <div class="separador derecha"></div>
                                        </div>
                                    <div class="etiqueta-der">{{ $metrica['etiqueta_der'] }}</div>
                                </div>
                                <div class="texto-metrica">
                                    <p>{{ $metrica['descripcion'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
    
            <section class="pagina-tres">
                    <div class="contenedor-s experiencia">
                        <img  class="icono-informe" src="{{ asset('storage/logos/logoAlobri.jpeg') }}">
                        <h5>Información relativa a experiencia y trayectoria informada por el candidato</h5>
                    </div>
                    <div class="contenedor-s general">
                        <img  class="icono-informe" src="{{ asset('storage/logos/logoAlobri.jpeg') }}">
                        <h5>General</h5>
                    </div>
                    <div class="contenedor-s record-criminal">
                        <img  class="icono-informe" src="{{ asset('storage/logos/logoAlobri.jpeg') }}">
                        <h5>Récord Criminal</h5>
                    </div>
                    <div class="contenedor-s desvinculacion">
                        <img  class="icono-informe" src="{{ asset('storage/logos/logoAlobri.jpeg') }}">
                        <h5>Desvinculación de la Empresa</h5>
                    </div>
                    <div class="contenedor-s historial-manejo">
                        <img  class="icono-informe" src="{{ asset('storage/logos/logoAlobri.jpeg') }}">
                        <h5>Historial de Manejo</h5>
                    </div>
                    <div class="contenedor-s drogas">
                        <img  class="icono-informe" src="{{ asset('storage/logos/logoAlobri.jpeg') }}">
                        <h5>Drogas</h5>
                    </div>
                    <div class="contenedor-s alcohol">
                        <img  class="icono-informe" src="{{ asset('storage/logos/logoAlobri.jpeg') }}">
                        <h5>Alcohol</h5>
                    </div>
                    <div class="contenedor-s historia-laboral">
                        <img  class="icono-informe" src="{{ asset('storage/logos/logoAlobri.jpeg') }}">
                        <h5>Historia Laboral</h5>
                    </div>
                    <div class="contenedor-s seguridad-laboral">
                        <img  class="icono-informe" src="{{ asset('storage/logos/logoAlobri.jpeg') }}">
                        <h5>Seguridad Laboral</h5>
                    </div>
    
                    <!--<div class="contenedor-seccion nota">
                        <p>La información adjunta es confidencial y solo debe compartirse con las partes autorizadas. <br>
                            Los resultados reportados aquí están basados en el total de respuestas brindadas durante la evaluación. <br>
                            Estos resultados deberían utilizarse como una herramienta de soporte en la toma de decisiones, mas no como la única base para tomar decisiones de selección.
                        </p>
                    </div>
    
                    <div class="deco">
                        <div class="circulo azul-oscuro"></div>
                        <div class="circulo azul-claro"></div>
                        <div class="circulo azul"></div>
                        <div class="circulo rojo"></div>
                    </div>-->
            </section>
        </div>

        <div class="contenedor-seccion nota">
            <p>La información adjunta es confidencial y solo debe compartirse con las partes autorizadas. <br>
                Los resultados reportados aquí están basados en el total de respuestas brindadas durante la evaluación. <br>
                Estos resultados deberían utilizarse como una herramienta de soporte en la toma de decisiones, mas no como la única base para tomar decisiones de selección.
            </p>
        </div>
        <div class="deco">
            <div class="circulo azul-oscuro"></div>
            <div class="circulo azul-claro"></div>
            <div class="circulo azul"></div>
            <div class="circulo rojo"></div>
        </div>'
    </div>

    <div class="footer">
        <span>{{ now()->format('d/m/Y') }}</span>
        <span>página 1 de 5</span>
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