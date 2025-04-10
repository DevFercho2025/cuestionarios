@extends('layout.app')
@section('content')
<style>
    body {
        background-color: #f5f5f5;
        display: flex;
        min-height: 100vh;
        flex-direction: column;
    }

    main {
        flex: 1 0 auto;
        padding: 20px 0;
    }

    .card {
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .paso-container {
        display: flex;
        justify-content: center;
        margin: 30px 0;
        position: relative;
    }

    .paso {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 50px;
        width: 50px;
        color: #9e9e9e;
        border: 4px solid #e0e0e0;
        border-radius: 50%;
        font-size: 22px;
        font-weight: 500;
        background: white;
        z-index: 2;
        margin: 0 40px;
        transition: all 0.3s ease;
    }

    .paso.activo {
        border-color: transparent;
        color: #2196F3;
        outline: 4px solid #2196F3;
    }

    .barra-progreso {
        position: absolute;
        top: 50%;
        width: 70%;
        height: 4px;
        background: #e0e0e0;
        z-index: 1;
    }

    .indicador {
        position: absolute;
        height: 100%;
        width: 0%;
        background: #2196F3;
        transition: width 0.3s ease-in-out;
    }

    .seccion-form {
        display: none;
    }

    .seccion-form.activa {
        display: block;
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .layout-container {
        display: flex;
        align-items: stretch;
        max-width: 1200px;
        margin: 0 auto;
    }

    .form-section {
        flex: 1;
        padding: 20px;
    }

    .logo-section {
        width: 300px;
        background-color: #fff;
        border-radius: 0 8px 8px 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 20px;
        box-shadow: 4px 0 10px rgba(0,0,0,0.1);
    }

    .logo-section img {
        max-width: 100%;
        height: auto;
    }

    .input-field .helper-text {
        color: #f44336;
    }

    .form-title {
        color: #2196F3;
        margin-bottom: 30px;
        font-weight: 300;
    }

    .btn-navegar {
        margin: 0 10px;
    }

    .asterisco-obligatorio {
        color: #f44336;
        margin-right: 5px;
    }

    /* Adaptación para móviles */
    @media (max-width: 992px) {
        .layout-container {
            flex-direction: column-reverse;
        }

        .logo-section {
            width: 100%;
            border-radius: 8px 8px 0 0;
            padding: 10px;
            margin-bottom: 20px;
        }

        .form-section {
            width: 100%;
        }

        .paso {
            margin: 0 20px;
        }

        .barra-progreso {
            width: 60%;
        }
    }
</style>
<main>
    <div class="layout-container">
        <div class="form-section card">
            <div class="card-content">
                <h4 class="form-title center-align">Registro de Candidatos</h4>

                <div class="paso-container">
                    <div class="paso activo">1</div>
                    <div class="paso">2</div>
                    <div class="paso">3</div>
                    <div class="barra-progreso">
                        <div class="indicador"></div>
                    </div>
                </div>

                <form action="{{ route('candidatos.store') }}" method="POST" id="registro-form">
                    @csrf

                    <!-- Sección 1 -->
                    <div class="seccion-form activa">
                        <div class="row">
                            <div class="col s12 m4">
                                <div class="input-field">
                                    <i class="material-icons prefix">person</i>
                                    <input type="text" id="nombre" name="nombre" class="validate" required pattern="[^\d]+" oninput="this.value = this.value.replace(/\d/g, '')">
                                    <label for="nombre"><span class="asterisco-obligatorio">*</span>Nombre</label>
                                    <span class="helper-text" data-error="Este campo es requerido y no debe contener números"></span>
                                </div>
                            </div>

                            <div class="col s12 m4">
                                <div class="input-field">
                                    <i class="material-icons prefix">person_outline</i>
                                    <input type="text" id="apellidoPaterno" name="apellidoPaterno" class="validate" required pattern="[^\d]+" oninput="this.value = this.value.replace(/\d/g, '')">
                                    <label for="apellidoPaterno"><span class="asterisco-obligatorio">*</span>Apellido Paterno</label>
                                    <span class="helper-text" data-error="Este campo es requerido y no debe contener números"></span>
                                </div>
                            </div>

                            <div class="col s12 m4">
                                <div class="input-field">
                                    <div class="input-field">
                                        <i class="material-icons prefix">person_outline</i>
                                        <input type="text" id="apellidoMaterno" name="apellidoMaterno" class="validate" required pattern="[^\d]+" oninput="this.value = this.value.replace(/\d/g, '')">
                                        <label for="apellidoMaterno"><span class="asterisco-obligatorio">*</span>Apellido Materno</label>
                                        <span class="helper-text" data-error="Este campo es requerido y no debe contener números"></span>
                                    </div>
                                    <button type="button" id="btnNoAplica" class="btn-flat waves-effect right">No aplica</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección 2 -->
                    <div class="seccion-form">
                        <div class="row">
                            <div class="col s12 m7">
                                <div class="input-field">
                                    <i class="material-icons prefix">email</i>
                                    <input type="email" id="correo" name="correo" class="validate" required>
                                    <label for="correo"><span class="asterisco-obligatorio">*</span>Correo Electrónico</label>
                                    <span class="helper-text" data-error="Ingrese un correo electrónico válido"></span>
                                </div>
                            </div>

                            <div class="col s12 m5">
                                <div class="input-field">
                                    <i class="material-icons prefix">cake</i>
                                    <input type="text" id="fechaNacimiento" name="fechaNacimiento" class="datepicker" required>
                                    <label for="fechaNacimiento"><span class="asterisco-obligatorio">*</span>Fecha de Nacimiento</label>
                                    <span class="helper-text" data-error="Este campo es requerido"></span>
                                </div>
                            </div>
                        </div>

                        <div class="input-field">
                            <i class="material-icons prefix">wc</i>
                            <select id="genero" name="genero" required>
                                <option value="" disabled selected>Seleccione una opción</option>
                                <option value="masculino">Masculino</option>
                                <option value="femenino">Femenino</option>
                            </select>
                            <label><span class="asterisco-obligatorio">*</span>Género Legal</label>
                        </div>
                    </div>

                    <!-- Sección 3 -->
                    <div class="seccion-form">
                        <div class="input-field">
                            <i class="material-icons prefix">public</i>
                            <select id="pais" name="pais" required>
                                <option value="" disabled selected>Seleccione una opción</option>
                                <option value="MX">México</option>
                                <option value="US">Estados Unidos</option>
                                <option value="ES">España</option>
                                <option value="AR">Argentina</option>
                                <option value="CO">Colombia</option>
                                <option value="CL">Chile</option>
                                <option value="PE">Perú</option>
                                <!-- Más opciones aquí -->
                            </select>
                            <label><span class="asterisco-obligatorio">*</span>País</label>
                        </div>

                        <div class="row">
                            <div class="col s12 m6">
                                <div class="input-field">
                                    <i class="material-icons prefix">location_on</i>
                                    <input type="text" id="codigoPostal" name="codigoPostal" class="validate" required>
                                    <label for="codigoPostal"><span class="asterisco-obligatorio">*</span>Código Postal</label>
                                    <span class="helper-text" data-error="Este campo es requerido"></span>
                                </div>
                            </div>

                            <div class="col s12 m6">
                                <div class="input-field">
                                    <i class="material-icons prefix">phone</i>
                                    <input type="tel" id="celular" name="celular" class="validate" required pattern="[0-9]{10}" maxlength="10" oninput="this.value = this.value.replace(/\D/g, '')">
                                    <label for="celular"><span class="asterisco-obligatorio">*</span>Celular</label>
                                    <span class="helper-text" data-error="Ingrese un número de 10 dígitos"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="center-align" style="margin-top: 30px;">
                        <button type="button" id="seccionAnterior" class="btn waves-effect waves-light grey lighten-1 btn-navegar" disabled>
                            <i class="material-icons left">navigate_before</i>Volver
                        </button>
                        <button type="button" id="seccionSiguiente" class="btn waves-effect waves-light blue btn-navegar">
                            Siguiente<i class="material-icons right">navigate_next</i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="logo-section card">
            <img src="{{ asset('storage/logos/logoAlobri.jpeg') }}" alt="Logo de la empresa" id="logo-empresa">
            <!--<div class="card-content" style="padding-top: 20px;">
                <p class="center-align grey-text text-darken-1">Registro de Candidatos</p>
            </div>-->
        </div>
    </div>
</main>
@endsection


@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar componentes de Materialize
        M.AutoInit();

        // Configuración especial para datepicker
        var datePickerOptions = {
            format: 'yyyy-mm-dd',
            yearRange: 70,
            maxDate: new Date(new Date().getFullYear() - 18, 11, 31), // Asume mayoría de edad 18 años
            i18n: {
                months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
                cancel: 'Cancelar',
                clear: 'Limpiar',
                done: 'Aceptar'
            }
        };

        var datepickers = document.querySelectorAll('.datepicker');
        M.Datepicker.init(datepickers, datePickerOptions);
    });

    // Variables para el formulario multi-paso
    const pasos = document.querySelectorAll(".paso");
    const barraProgreso = document.querySelector(".indicador");
    const secciones = document.querySelectorAll(".seccion-form");
    const botonAnterior = document.getElementById("seccionAnterior");
    const botonSiguiente = document.getElementById("seccionSiguiente");

    let pasoActual = 1;

    // Función para validar los campos de la sección actual
    function validarSeccionActual() {
        const camposRequeridos = secciones[pasoActual - 1].querySelectorAll("[required]");
        let pasoValido = true;

        camposRequeridos.forEach((campo) => {
            if (!campo.value.trim()) {
                // Usar validación de Materialize
                campo.classList.add("invalid");
                pasoValido = false;
            } else {
                campo.classList.remove("invalid");
                campo.classList.add("valid");
            }
        });

        return pasoValido;
    }

    // Actualizar la visualización según el paso actual
    function actualizarPasos() {
        // Actualizar círculos de pasos
        pasos.forEach((paso, index) => {
            if (index < pasoActual) {
                paso.classList.add("activo");
            } else {
                paso.classList.remove("activo");
            }
        });

        // Actualizar secciones visibles
        secciones.forEach((seccion) => seccion.classList.remove("activa"));
        secciones[pasoActual - 1].classList.add("activa");

        // Actualizar barra de progreso
        barraProgreso.style.width = `${((pasoActual - 1) / (pasos.length - 1)) * 100}%`;

        // Actualizar botones
        if (pasoActual === 1) {
            botonAnterior.disabled = true;
            botonAnterior.classList.add("disabled");
            botonSiguiente.textContent = "Siguiente";
            botonSiguiente.innerHTML = 'Siguiente<i class="material-icons right">navigate_next</i>';
        } else if (pasoActual === pasos.length) {
            botonAnterior.disabled = false;
            botonAnterior.classList.remove("disabled");
            botonSiguiente.textContent = "Enviar";
            botonSiguiente.innerHTML = 'Enviar<i class="material-icons right">send</i>';
        } else {
            botonAnterior.disabled = false;
            botonAnterior.classList.remove("disabled");
            botonSiguiente.textContent = "Siguiente";
            botonSiguiente.innerHTML = 'Siguiente<i class="material-icons right">navigate_next</i>';
        }
    }

    // Evento para el botón Siguiente
    botonSiguiente.addEventListener("click", function() {
        if (pasoActual < pasos.length) {
            // Validar los campos de la sección actual antes de avanzar
            if (!validarSeccionActual()) return;

            pasoActual++;
            actualizarPasos();
        } else {
            // Último paso, mostrar confirmación antes de enviar
            Swal.fire({
                title: '¿Deseas continuar?',
                html: 'Al continuar aceptas nuestra <a href="https://ejemplo.com/privacidad" target="_blank">política de privacidad</a>.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Aceptar y Enviar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#2196F3',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Enviar el formulario
                    document.getElementById("registro-form").submit();
                }
            });
        }
    });

    // Evento para el botón Anterior
    botonAnterior.addEventListener("click", function() {
        if (pasoActual > 1) {
            pasoActual--;
            actualizarPasos();
        }
    });

    // Botón "No aplica" para apellido materno
    document.getElementById("btnNoAplica").addEventListener("click", function() {
        const campo = document.getElementById("apellidoMaterno");
        campo.value = "No aplica";
        campo.classList.remove("invalid");
        campo.classList.add("valid");

        // Actualizar etiquetas de Materialize
        M.updateTextFields();
    });

    // Detectar color predominante del logo
    window.onload = function() {
        const img = document.getElementById("logo-empresa");

        if (!img) {
            console.error("La imagen no se encontró en el DOM.");
            return;
        }

        // Esperar a que la imagen cargue
        img.onload = function() {
            const canvas = document.createElement("canvas");
            const ctx = canvas.getContext("2d");

            canvas.width = img.naturalWidth;
            canvas.height = img.naturalHeight;
            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

            try {
                const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                const pixels = imageData.data;

                const colorCounts = {};
                let mostFrequentColor = "";
                let maxCount = 0;

                // Analizar solo una parte de los píxeles para rendimiento
                const step = 10; // Analizar cada 10 píxeles

                for (let i = 0; i < pixels.length; i += 4 * step) {
                    const r = pixels[i];
                    const g = pixels[i + 1];
                    const b = pixels[i + 2];
                    const a = pixels[i + 3];

                    // Ignorar píxeles transparentes
                    if (a < 200) continue;

                    const rgb = `${r},${g},${b}`;
                    colorCounts[rgb] = (colorCounts[rgb] || 0) + 1;

                    if (colorCounts[rgb] > maxCount) {
                        maxCount = colorCounts[rgb];
                        mostFrequentColor = rgb;
                    }
                }

                // Aplicar el color de fondo predominante con un poco de transparencia
                document.querySelector(".logo-section").style.backgroundColor = `rgba(${mostFrequentColor}, 0.1)`;

                // Si el color es oscuro, cambiar el color del texto a claro
                const [r, g, b] = mostFrequentColor.split(",").map(Number);
                if (r + g + b < 380) { // Umbral para determinar si es oscuro
                    document.querySelectorAll(".logo-section .grey-text").forEach(el => {
                        el.classList.remove("grey-text", "text-darken-1");
                        el.classList.add("white-text");
                    });
                }
            } catch(e) {
                console.error("Error al procesar la imagen:", e);
            }
        };
    };
</script>

@endsection
