@extends('layout.app')
    @php
        $candidato = session('candidato', []);
        $rango_inicio = $rango_inicio ?? 1;
        $rango_fin = $rango_fin ?? 35;
        $cameraRequired = $cameraRequired;
        $locationRequired = $locationRequired;
    @endphp
    @section('content')
    <!-- Esto es para verificar que los datos del candidato se guardaron
    <p>Nombre: {{ $candidato['nombre'] ?? 'No ingresado' }}</p>
    <p>Correo: {{ $candidato['correo'] ?? 'No ingresado' }}</p>
    <p>Género: {{ $candidato['genero'] ?? 'No seleccionado' }}</p>-->
    <div id="contenedorForm">
        
    </div>
    @endsection
    <style>
        .swal2-container {
            z-index: 9999 !important;
        }
    </style>

@push('scripts')
    <script>
        const RUTA_GUARDAR_RESPUESTAS = "{{ route('guardar.respuestas') }}";
    </script>
    <script src="{{ asset('js/ubicacion.js') }}"></script>
    <script>
        let rangoInicio = {{ $rango_inicio }};
        let rangoFin = {{ $rango_fin }};

        let seccionId = @json($section_id);
        let testId = @json($test_id);

        let cameraRequired = {{ $cameraRequired }};
        let locationRequired = {{ $locationRequired }};
    </script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            M.AutoInit(); // Inicia todos los componentes automáticamente
        });
    </script>
    @if(isset($rango_inicio) && $rango_inicio < 35)
        <script>
            solicitarPermisos();
            function solicitarPermisos() {
                if (cameraRequired === 0 && locationRequired === 0) {
                    //si fue configurado que cámara y ubicación no se requieren, seguir.
                    permisosConcedidos();
                    return;
                }

                Swal.fire({
                    title: "Checking...",
                    html: `<p style="font-size: 20px; color: red;">
                                Para continuar, necesitamos:<br>
                                ${locationRequired ? 'acceso a tu ubicación.<br> Esta información se usará únicamente para registrar el lugar desde donde se llena esta evaluación.' : ''}
                                ${cameraRequired ? 'acceso a tu cámara.<br> Las fotos tomadas con la cámara se utilizarán para monitorear tu progreso durante la evaluación. Estas imágenes son necesarias para el seguimiento y no serán compartidas públicamente.' : ''}
                        </p>`,
                    text: "Por favor espera mientras obtenemos los permisos.",
                    imageUrl: "https://www.epgdlaw.com/wp-content/uploads/2017/09/ajax-loader.gif",
                    showConfirmButton: false, 
                    allowOutsideClick: false,
                    didOpen: () => {
                        if (locationRequired) {
                            navigator.geolocation.getCurrentPosition(permitido, error); //esto da el mensaje al usuario
                    
                            function permitido(posicion) {
                                console.log("Ubicación obtenida:", posicion.coords.latitude, posicion.coords.longitude);
                                const lat = posicion.coords.latitude;
                                const lon = posicion.coords.longitude;
                                obtenerCiudadPais(lat, lon);
                                if (cameraRequired) {
                                    obtenerCamara();
                                } else {
                                    permisosConcedidos();
                                }
                            }
                            function error(err){
                                console.log("no se dio permiso para la ubicación")
                                instruccionesPermisos();
                            }
                        } else if (cameraRequired) {
                            obtenerCamara();
                        }
                    }
                });
            }

            function obtenerCamara() {
                navigator.mediaDevices.getUserMedia({ video: true })
                    .then((stream) => {
                        console.log("Permiso de cámara concedido", stream);
                        permisosConcedidos();
                    })
                    .catch((error) => {
                        console.log("Cámara denegada");
                        instruccionesPermisos();
                });
            }
            function instruccionesPermisos(){
                Swal.fire({
                    icon: 'error',
                    title: 'No es posible continuar',
                    html: `<p>Debes habilitar los permisos de 
                        ${locationRequired ? 'ubicación' : ''} 
                        ${cameraRequired && locationRequired ? ' y camara ' : ''} 
                        ${cameraRequired && !locationRequired ? 'cámara' : ''}
                        para realizar tu evaluación de candidato.
                        <span style="color: blue;">Una vez habilites los permisos, da clic a Intentar de nuevo</span>
                        <br><br>
                        ${cameraRequired ? 'Asegúrate te tener una cámara conectada.' : ''}
                        </p>`,
                    imageUrl: "images/instruccionesHabilitarPermiso.png",
                    allowOutsideClick: false,
                    confirmButtonText: 'Intentar de nuevo'
                }).then((result) => {
                    if (result.isConfirmed) {
                        solicitarPermisos();
                        }
                    });
                }

            function permisosConcedidos(){
                Swal.fire({
                        icon: "success",
                        title: `${locationRequired || cameraRequired ? "Permisos concedidos" : 'Iniciando evaluación'}`,
                        text: "Puedes continuar.",
                        showConfirmButton: false, 
                        allowOutsideClick: false,
                        timer: 2000,

                        willClose: () => {
                            //esto cambia la url para que ya no sea "permisos-preliminares"
                            history.pushState(null, "", "/formulario-prueba-candidato");
                            //Esta es una petición AJAX
                            cargarForm(seccionId);
                        }

                    });
            }
        </script>
    @elseif(isset($rango_inicio) && $rango_inicio > 35)
        <script>
            Swal.fire({
                title: 'Nueva Sección',
                text: 'Estás en la siguiente sección.',
                icon: 'success',
                confirmButtonText: 'Iniciar'
                
            }).then(() => {
                document.getElementById("contenidoPagina").style.display = "block";

                cargarForm(seccionId);
        });
        </script>
    @endif
        <script>
            function cargarForm(seccionId) {
                let url = "{{ route('candidate.cargar.formulario') }}?section_id=" + seccionId + "&test_id=" + testId + "&cameraRequired=" + cameraRequired 
              + "&locationRequired=" + locationRequired;

                fetch(url)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`Error de HTTP: ${response.status}`);
                        }
                        return response.text();
                    })
                    .then(html => {
                        // Inserta el formulario en el contenedor
                        document.getElementById("contenedorForm").innerHTML = html;
                        cargarScriptsForm();
                    })
                    .catch(error => console.error("Error al cargar el formulario:", error));
            }
        </script>

        <script>
            
            function cargarScriptsForm() {
                const scripts = [
                    "{{ asset('js/mostrarPreg.js') }}",
                    "{{ asset('js/progresoEv.js') }}",

                    //preguntas de emparejamiento
                    "{{ asset('js/pares.js') }}",
                    "https://cdnjs.cloudflare.com/ajax/libs/leader-line/1.0.8/leader-line.min.js",

                    //pregunta V o F con ordenamiento de palabras
                    "../../assets/vendor/libs/sortablejs/sortable.js",
                    "{{ asset('js/ordenarPalabras.js') }}",

                    //Glosario de Cleaver
                    "{{ asset('js/glosario.js') }}"
                ];

                if (cameraRequired === 1) {
                    scripts.push("{{ asset('js/camTemp.js') }}");
                }

                scripts.forEach(src => {
                    const s = document.createElement('script');
                    s.src = src;
                    s.async = false;
                    document.body.appendChild(s);
                });
            }
        </script>
@endpush