<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Resultados</title>
        <link rel="stylesheet" href="{{ public_path('assets/css/pdf.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/pdf.css') }}">
        <!--Para dompdf, cambiar asset en los src por public_path-->
        <!--<style>
            .page-break {
                page-break-after: always;
            }
        </style>-->
</head>
<body>
    <div id="header">
        <div class="header-izq">
            <img class="logo-empresa" src="{{ public_path('storage/logos/logoAlobri.jpeg') }}">
        </div>
        <div class="header-der">
            <span>Ensuring Personnel Integrity</span>
        </div>
    </div>

    <div id="footer">
        <div class="footer-izq">
            <span class="fecha">{{ now()->format('d/m/Y') }}</span>
        </div>
        <div class="footer-der">
            <span class="paginado">página 1 de 5</span>
        </div>        
    </div>

    <div class="content" style="font-family: sans-serif;">
            <section class="pagina-uno">

                <div class="ti">
                    <table>
                        <tr>
                            <td class="deco-td">
                                <div class="titulo-test">
                                    @if(!empty($scores))
                                        {{ collect($scores)->pluck('test_title')->implode(' | ') }}
                                    @else
                                        Evaluación Psicométrica
                                    @endif
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="contenedor-seccion seccion-1">
                    <table class="tabla-datos-candidato">
                        <tr>
                            <td class="columna-candidato">
                                <img class="foto-candidato" src="{{ public_path('storage/logos/logoAlobri.jpeg') }}">
                            </td>
                            
                            <td class="columna-candidato">
                                <div>
                                    <p><strong>Nombre</strong> <br>{{ $usuario->name }}</p>
                                    <p><strong>RFC:</strong> {{ $usuario->rfc ?? '---' }}</p>
                                    <p><strong>Fecha:</strong> {{ now()->format('d/m/Y') }}</p>
                                </div>
                            </td>
                            <td class="columna-divisor">
                                <div class="divisor-vertical-info-candidato"></div>
                            </td>
                            <td class="columna-candidato">
                                <div>
                                    <p><strong>Cuenta:</strong> {{ Auth::user()->config->Company->name ?? '---'}}</p>
                                    <p><strong>Cargo:</strong> {{ $aplicacion->vacancy ?? '---' }}</p>
                                    <p><strong>Idioma:</strong> Español</p>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                
                <div class="contenedor-seccion seccion-2">

                    <table style="width: 100%; border-collapse: collapse; background-color: #ffffff; border-radius: 10px; margin: 10px;">
                        <tr>
                          <!-- Columna: Puntuación general -->
                          <td style="width: 50%; vertical-align: top;">

                            <div style="display: inline-block; text-align: left;">
                                <table style="margin: 0 auto;">
                                  <tr>
                                    <td style="vertical-align: middle; padding-right: 10px;">
                                      <img src="{{ public_path('storage/logos/logoAlobri.jpeg') }}" style="width: 30px;">
                                    </td>
                                    <td style="vertical-align: middle;">
                                      <div>Puntuación general</div>
                                    </td>
                                  </tr>
                                </table>
                            </div>
                            <div class="calificadores">
                                <ul style="list-style: none; padding: 0; margin: 0;">
                                    <li> <span class="circulo-calificador green"></span> Recomendado</li>
                                    <li> <span  class="circulo-calificador lightgreen"></span> Se requiere aclaración</li>
                                    <li> <span  class="circulo-calificador orange"></span> Marginal</li>
                                    <li> <span  class="circulo-calificador red"></span> No recomendado</li>
                                    <li> <span  class="circulo-calificador black"></span> Sin resultados</li>
                                </ul>
                            </div>
                          </td>
                      
                          <!-- Columna: Gráfico -->
                          <td style="width: 50%; vertical-align: top; text-align: center;">
                            <div style="text-align: center;">
                                <div style="display: inline-block; text-align: left;">
                                    <table style="margin: 0 auto;">
                                      <tr>
                                        <td style="vertical-align: middle; padding-right: 10px;">
                                          <img src="{{ public_path('storage/logos/logoAlobri.jpeg') }}" style="width: 30px;">
                                        </td>
                                        <td style="vertical-align: middle;">
                                          <div>Comparación</div>
                                        </td>
                                      </tr>
                                    </table>
                                </div>

                                  <!-- Imagen de gráfica debajo -->
                                <div style="margin-top: 10px;">
                                    <img src="{{ public_path('storage/logos/logoAlobri.jpeg') }}" style="width: 100%; max-width: 200px;">
                                </div>
                            </div>
                          </td>
                        </tr>
                      
                        <!-- Fila completa: Resumen -->
                        <tr>
                          <td colspan="2" style=" font-size: 14px; text-align: justify; padding-right: 20px">
                            <p>
                              Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                              Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                              Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                              Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                            </p>
                          </td>
                        </tr>
                    </table>

                </div>
                      
                <div class="contenedor-seccion seccion-3" style="padding-bottom: 133px;">
                    <div style="display: inline-block; text-align: left;">
                        <table style="margin: 0 auto;">
                          <tr>
                            <td style="vertical-align: middle; padding-right: 10px;">
                              <img src="{{ public_path('storage/logos/logoAlobri.jpeg') }}" style="width: 30px;">
                            </td>
                            <td style="vertical-align: middle;">
                              <div>Información de la prueba</div>
                            </td>
                          </tr>
                        </table>
                    </div>
                    
                    <div class="informacion-prueba">
                        <table class="tabla-info-prueba" style="font-size: 11">
                            <tr>
                                <td style="padding-right: 60px; padding-left:10px;">
                                    <p><div style="color:darkcyan;">Correo electrónico:</div> {{ $usuario->email }}</p>
                                </td>
                                <td style="padding-right: 60px;">
                                    <p><div style="color:darkcyan;">Decisión de contratación:</div> {{ $aplicacion->nombre_evaluacion ?? '---' }}</p></td>
                                </td>
                                <td >
                                    <p><div style="color:darkcyan;">Tipo de registro:</div> Reclutador</p>
                                </td>
                            </tr>
                            <tr>
                                <td>  
                                    <p><div style="color:darkcyan; padding-left:10px;">Número telefónico:</div> <span style="padding-left:10px;">{{ $usuario->info->phone ?? '---' }}</span></p>
                                <td> 
                                    <p><div style="color:darkcyan;">Puntuación general:</div> Se requiere aclaración</p>
                                </td>
                                <td>
                                    <p><div style="color:darkcyan;">Registrado por:</div>{{auth()->user()->name}}</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p><div style="color:darkcyan; padding-left:10px;">Fecha de registro:</div><span style="padding-left:10px;">{{ $usuario->created_at}}</span></p>
                                </td>
                                <td>
                                    <p><div style="color:darkcyan;">Tipo de prueba:</div>{{ !empty($scores) ? collect($scores)->pluck('type_name')->unique()->implode(', ') : '---' }}</p>
                                </td>
                                <td>
                                    <p><div style="color:darkcyan;">Ingresando desde:</div>Liga Remota</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p><div style="color:darkcyan; padding-left:10px;">Fecha de Inicio de la Prueba:</div> <span style="padding-left:10px;">{{ $usuario->created_at}}</span></p>
                                </td> 
                                <td>
                                    <p><div style="color:darkcyan;">Nombre de la evaluación</div> {{ !empty($scores) ? collect($scores)->pluck('test_title')->implode(', ') : '---' }}</p>
                                </td>
                                <td >
                                    <p><div style="color:darkcyan;">Fecha de envío de la liga de pruebas:</div>{{ $usuario->created_at}}</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p><div style="color:darkcyan; padding-right: 50px; padding-left:10px;">Fecha de Finalización de la Prueba:</div><span style="padding-left:10px;">{{ $usuario->created_at}}</span></p>
                                </td>
                                <td>
                                    <p><div style="color:darkcyan;">Cuenta Principal</div> Integridad</p>
                                </td>
                            </tr>

                        </table>
                    </div> 
                </div>
            </section>
            <div class="page-break"></div>

            
            <section class="pagina-dos">
                <div class="contenedor-seccion" style="margin-top:80px;">
                    <div style="display: inline-block; text-align: left;">
                        <table style="margin: 0 auto;">
                          <tr>
                            <td style="vertical-align: middle; padding-right: 10px;">
                              <img src="{{ public_path('storage/logos/logoAlobri.jpeg') }}" style="width: 30px;">
                            </td>
                            <td style="vertical-align: middle;">
                              <div>Puntuación por medida. Basado en normas de población relevante</div>
                            </td>
                          </tr>
                        </table>
                    </div>
                    @foreach($imagenesBase64 as $imagen)
                        <div class="contenedor-metrica">
                            <img src="{{ $imagen }}" alt="Métrica Imagen" style="max-width:100%; height: auto;"/>
                       </div>
                    @endforeach
                </div>
            </section>
            
            <section class="pagina-tres">
                    <div class="contenedor-s experiencia" style="margin-top:80px;">
                        <div style="display: inline-block; text-align: left;">
                            <table style="margin: 0 auto;">
                              <tr>
                                <td style="vertical-align: middle; padding-right: 10px;">
                                  <img src="{{ public_path('storage/logos/logoAlobri.jpeg') }}" style="width: 30px;">
                                </td>
                                <td style="vertical-align: middle;">
                                  <div>Información relativa a experiencia y trayectoria informada por el candidato</div>
                                </td>
                              </tr>
                            </table>
                        </div>
                        <table width="100%" cellspacing="0" cellpadding="10">
                            <tr>
                                 <!-- Columna 1 -->
                               <td style="vertical-align: middle; font-size: 12px; padding: 5px;">
                                    <table cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
                                        <tr>
                                            <td style="vertical-align: middle;">
                                                <div style="font-family: 'DejaVu Sans', sans-serif; font-style: normal; font-weight: bold; font-size: 16px;  width: 20px; height: 20px; border-radius: 50%; background-color:rgb(59,156,156); text-align: center; line-height: 15px; font-weight: bold; color: white;">
                                                    &#10003;
                                                </div>
                                            </td>
                                            <td style="vertical-align: middle; padding-left: 10px;">
                                                <div>Respuestas que requieren</div>
                                                <div>una aclaración adicional</div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>

                                <!-- Columna 2 -->
                               <td style="vertical-align: middle; font-size: 12px; padding: 5px;">
                                    <table cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
                                        <tr>
                                            <td style="vertical-align: middle;">
                                                <div style="width: 20px; height: 20px; border-radius: 50%; background-color: rgb(206, 51, 51); text-align: center; line-height: 18px; font-weight: bold; color: white;">
                                                    !
                                                </div>
                                            </td>
                                            <td style="vertical-align: middle; padding-left: 10px;">
                                                <div>Respuestas que requieren</div>
                                                <div>una aclaración adicional</div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>

                                <!-- Columna 3 -->
                                <td style="vertical-align: middle; font-size: 12px; padding: 5px;">
                                    <table cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
                                        <tr>
                                            <td style="vertical-align: middle;">
                                                <div style="width: 20px; height: 20px; border-radius: 50%; background-color: rgb(206, 51, 51); text-align: center; line-height: 18px; font-weight: bold; color: white;">
                                                    %
                                                </div>
                                            </td>
                                            <td style="vertical-align: middle; padding-left: 10px;">
                                                <div>Respuesta similar dentro</div>
                                                <div>de la cuenta</div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>

                                <!-- Columna 4 vacía -->
                                <td style="width: 25%;">&nbsp;</td>
                            </tr>
                        </table>
                    </div>
                    <div class="contenedor-s general">
                        <div style="display: inline-block; text-align: left;">
                            <table style="margin: 0 auto;">
                              <tr>
                                <td style="vertical-align: middle; padding-right: 10px;">
                                  <img src="{{ public_path('storage/logos/logoAlobri.jpeg') }}" style="width: 30px;">
                                </td>
                                <td style="vertical-align: middle;">
                                  <div>General</div>
                                </td>
                              </tr>
                            </table>
                        </div>
                        <table>
                            <tr>
                                <!-- COLUMNA IZQUIERDA -->
                                <td style="width: 60%; vertical-align: top;">
                                    <div style="display: flex; align-items: center;">
                                        <!-- Círculo con logo -->
                                        <div style="width: 40px; height: 40px; border-radius: 50%; overflow: hidden; background-color: #e0e0e0; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                                            <img src="{{ public_path('storage/logos/logoAlobri.jpeg') }}" style="width: 24px; height: 24px;" />
                                        </div>
                                        <!-- Texto -->
                                        <div style="font-size: 12px;">
                                            <strong>Título</strong><br>
                                            Descripción o resumen breve aquí.
                                        </div>
                                    </div>
                                </td>

                                <!-- COLUMNA DERECHA -->
                                <td style="width: 40%; vertical-align: top; font-size: 12px;">
                                    Texto adicional, descripción extendida o detalles importantes que complementan la información.
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="contenedor-s record-criminal">
                        <div style="display: inline-block; text-align: left;">
                            <table style="margin: 0 auto;">
                              <tr>
                                <td style="vertical-align: middle; padding-right: 10px;">
                                  <img src="{{ public_path('storage/logos/logoAlobri.jpeg') }}" style="width: 30px;">
                                </td>
                                <td style="vertical-align: middle;">
                                  <div>Record-Criminal</div>
                                </td>
                              </tr>
                            </table>
                        </div>
                    </div>
                    <div class="contenedor-s desvinculacion">
                        <div style="display: inline-block; text-align: left;">
                            <table style="margin: 0 auto;">
                              <tr>
                                <td style="vertical-align: middle; padding-right: 10px;">
                                  <img src="{{ public_path('storage/logos/logoAlobri.jpeg') }}" style="width: 30px;">
                                </td>
                                <td style="vertical-align: middle;">
                                  <div>Desvinculación de la empresa</div>
                                </td>
                              </tr>
                            </table>
                        </div>
                    </div>
                    <div class="contenedor-s historial-manejo">
                        <div style="display: inline-block; text-align: left;">
                            <table style="margin: 0 auto;">
                              <tr>
                                <td style="vertical-align: middle; padding-right: 10px;">
                                  <img src="{{ public_path('storage/logos/logoAlobri.jpeg') }}" style="width: 30px;">
                                </td>
                                <td style="vertical-align: middle;">
                                  <div>Historial de Manejo</div>
                                </td>
                              </tr>
                            </table>
                        </div>
                    </div>
                    <div class="contenedor-s drogas">
                        <div style="display: inline-block; text-align: left;">
                            <table style="margin: 0 auto;">
                              <tr>
                                <td style="vertical-align: middle; padding-right: 10px;">
                                  <img src="{{ public_path('storage/logos/logoAlobri.jpeg') }}" style="width: 30px;">
                                </td>
                                <td style="vertical-align: middle;">
                                  <div>Drogas</div>
                                </td>
                              </tr>
                            </table>
                        </div>
                    </div>
                    <div class="contenedor-s alcohol">
                        <div style="display: inline-block; text-align: left;">
                            <table style="margin: 0 auto;">
                              <tr>
                                <td style="vertical-align: middle; padding-right: 10px;">
                                  <img src="{{ public_path('storage/logos/logoAlobri.jpeg') }}" style="width: 30px;">
                                </td>
                                <td style="vertical-align: middle;">
                                  <div>Alcohol</div>
                                </td>
                              </tr>
                            </table>
                        </div>
                    </div>
                    <div class="contenedor-s historia-laboral">
                        <div style="display: inline-block; text-align: left;">
                            <table style="margin: 0 auto;">
                              <tr>
                                <td style="vertical-align: middle; padding-right: 10px;">
                                  <img src="{{ public_path('storage/logos/logoAlobri.jpeg') }}" style="width: 30px;">
                                </td>
                                <td style="vertical-align: middle;">
                                  <div>Historial Laboral</div>
                                </td>
                              </tr>
                            </table>
                        </div>
                    </div>
                    <div class="contenedor-s seguridad-laboral">
                        <div style="display: inline-block; text-align: left;">
                            <table style="margin: 0 auto;">
                              <tr>
                                <td style="vertical-align: middle; padding-right: 10px;">
                                  <img src="{{ public_path('storage/logos/logoAlobri.jpeg') }}" style="width: 30px;">
                                </td>
                                <td style="vertical-align: middle;">
                                  <div>Seguridad Laboral</div>
                                </td>
                              </tr>
                            </table>
                        </div>
                    </div>
            </section>

        <div class="contenedor-seccion nota">
            <p>La información adjunta es confidencial y solo debe compartirse con las partes autorizadas. <br>
                Los resultados reportados aquí están basados en el total de respuestas brindadas durante la evaluación. <br>
                Estos resultados deberían utilizarse como una herramienta de soporte en la toma de decisiones, mas no como la única base para tomar decisiones de selección.
            </p>
        </div>
        <div class="deco-final"></div>
        <table class="deco-table">
            <tr>
                <td class="deco-td"><div class="circulo azul-oscuro"></div></td>
                <td class="deco-td"><div class="circulo azul-claro"></div></td>
                <td class="deco-td"><div class="circulo azul"></div></td>
                <td class="deco-td"><div class="circulo rojo"></div></td>
            </tr>
        </table>
    </div>
</body>
</html>