<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/css/pdf.css') }}">
    <title>Metricas de Resultado</title>
</head>
<body>
    
    @foreach($metricas as $metrica)
        @php
            $left = is_numeric($metrica['puntuacion']) ? max(0, $metrica['puntuacion'] - 1) : 0;
        @endphp
        <div class="contenedor-metrica">
            <h5 style="color:darkcyan; font-size:14;">{{ $metrica['titulo']}}</h5>

            <div class="seccion-metrica" id="seccion-metrica">
                <div class="linea-metrica" style="width: 952px">
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
                                    <div class="puntuacion" style="left: {{ $left}}%;">
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
</body>
</html>