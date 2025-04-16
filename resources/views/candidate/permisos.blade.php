@extends('layout.app')
    @php
        $candidato = session('candidato', []);
        $rango_inicio = $rango_inicio ?? 1;
        $rango_fin = $rango_fin ?? 35;
    @endphp

    <!-- Esto es para verificar que los datos del candidato se guardaron
    <p>Nombre: {{ $candidato['nombre'] ?? 'No ingresado' }}</p>
    <p>Correo: {{ $candidato['correo'] ?? 'No ingresado' }}</p>
    <p>Género: {{ $candidato['genero'] ?? 'No seleccionado' }}</p>-->
    <div id="contenedorForm">
        
    </div>

@section('scripts')
    <script src="{{ asset('js/ubicacion.js') }}"></script>
    @if(isset($rango_inicio) && $rango_inicio < 35)
        <script>
            solicitarPermisos();
            function solicitarPermisos() {
                Swal.fire({
                    title: "Checking...",
                    html: `<p style="font-size: 20px; color: red;">
                                Para continuar, necesitamos tu ubicación y acceso a cámara. 
                                Esta información se usará únicamente para registrar el lugar desde donde se llena esta evaluación.
                                Las fotos tomadas con la cámara se utilizarán para monitorear tu progreso durante la evaluación. Estas imágenes son necesarias para el seguimiento y no serán compartidas públicamente.
                        </p>`,
                    text: "Por favor espera mientras obtenemos tu ubicación y acceso a cámara.",
                    imageUrl: "https://www.epgdlaw.com/wp-content/uploads/2017/09/ajax-loader.gif",
                    showConfirmButton: false, 
                    allowOutsideClick: false,
                    didOpen: () => {

                        navigator.geolocation.getCurrentPosition(permitido, error); //esto da el mensaje al usuario
                    
                        function permitido(posicion) {
                            console.log("Ubicación obtenida:", posicion.coords.latitude, posicion.coords.longitude);
                            const lat = posicion.coords.latitude;
                            const lon = posicion.coords.longitude;
                            obtenerCiudadPais(lat, lon);
                            obtenerCamara();
                        }
                        function error(err){
                            console.log("no se dio permiso para la ubicación")
                            instruccionesPermisos();
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
                    html: `<p>Debes habilitar los permisos de Ubicación y cámara para realizar tu evaluación de candidato. <span style="color: blue;">Una vez permitas el permiso, da clic a Intentar de nuevo</span></p>`,
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
                        title: "Permisos concedidos",
                        text: "Puedes continuar con el formulario.",
                        showConfirmButton: false, 
                        allowOutsideClick: false,
                        timer: 2000,

                        willClose: () => {
                            //esto cambia la url para que ya no sea "permisos-preliminares"
                            history.pushState(null, "", "/formulario-prueba-candidato");

                            //Esta es una petición AJAX
                            cargarForm();
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

                cargarForm();
        });
        </script>
        @endif

        <script>
            function cargarForm(){
                //vs marca esto como error pero está bien y funciona
                let rangoInicio = {{ $rango_inicio }};
                let rangoFin = {{ $rango_fin }};
                fetch("{{ route('candidate.cargar.formulario') }}?rango_inicio=" + rangoInicio + "&rango_fin=" + rangoFin)
                            .then(response => {
                                if (!response.ok) { //response.ok verifica solicites HTTP en js. da True si da código 200 o similar(respuesta exitosa)
                                    throw new Error(`Error de HTTP: ${response.status}`); 
                                }
                                return response.text();
                            })
                            .then(html => {
                                //inserta formulario
                                document.getElementById("contenedorForm").innerHTML = html;

                                cargarScripts("{{ asset('js/camTemp.js') }}", "Scripts de temporizador, cronómetro y cámara cargados.");
                                cargarScripts("{{ asset('js/progresoEv.js') }}", "Script de Circulo de Progreso cargado");
                                cargarScripts("{{ asset('js/mostrarPreg.js') }}", "Script preguntas cargado");
                            })
                            .catch(error => console.error("Error al cargar el formulario:", error));
            }

            function cargarScripts(src, msn) {
                let script = document.createElement("script");
                script.src = src;
                script.defer = true;
                script.onload = () => console.log(msn);
                document.body.appendChild(script);
            }
        </script>
@endsection