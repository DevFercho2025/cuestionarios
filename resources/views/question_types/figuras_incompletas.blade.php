<!--Completar manualmente qué figura sigue-->

<head>
    <style>
        .contenedor {
            width: 67px;
            height: 110px;
            border: 2px solid black;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            background: white;
        }

        .fila {
            flex: 1;
            border-top: 2px solid black;
            box-sizing: border-box;
        }

        .fila:first-child {
            border-top: none;
        }

        .contenedor-circulos {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .circulo {
            width: 9px;
            height: 9px;
            background-color: rgb(0, 0, 0);
            border-radius: 50%;
            position: absolute;
            transition: opacity 0.2s;
        }

        .circulo-input {
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 100%;
            height: 100%;
            font-size: 20px;
            font-weight: bold;
            color: black;

            /*visualmente invisible*/
            background: transparent;
            border: none;
            outline: none;
            padding: 0;
            margin: 0;
            text-align: center;
            z-index: 2;

            caret-color: black;
        }

        .contenedor-dinamico-domino {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .contenedor-dinamico-domino.respuesta-input {
            width: 67px;
            height: 110px;
        }
    </style>
</head>