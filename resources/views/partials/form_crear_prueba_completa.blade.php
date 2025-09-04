<head>
    <style>
        .modal-fullheight .modal-content {
            height: 65vh;
            overflow-y: auto;
        }
        .bs-stepper {
            border: none !important;
            box-shadow: none !important;
        }

        .swal2-container.swal2-top-end,
        .swal2-container.swal2-bottom-end,
        .swal2-container.swal2-top,
        .swal2-container.swal2-bottom,
        .swal2-container.swal2-center {
        z-index: 20000 !important;
        }

        .swal2-popup.swal2-toast {
            background: #30334e !important;
            color: #ffffff !important;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.8) !important;
            z-index: 1100 !important;
        }

        /*DOMINOS*/
        .contenedor-dinamico-domino .lista-fichas {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .contenedor-dinamico-domino.respuesta-input {
            width: 67px;
            height: 110px;
        }

        /*Imagen al elegir organización de fichas*/
        .help-icon {
            cursor: pointer;
            margin-left: 5px;
            font-weight: bold;
            border: 1px solid #ccc;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            background: #3d4e81;
            position: relative;
            color: white;
            
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .tooltip-img {
            display: none;
            position: absolute;
            top: 120%;
            left: 50%;
            transform: translateX(-50%);
            border: 1px solid #ccc;
            background: #fff;
            padding: 4px;
            z-index: 100;
            width: 150px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        .tooltip-img img {
            max-width: 100%;
            height: auto;
            display: block;
        }

        .help-icon:hover .tooltip-img {
            display: block;
        }
        
            /*FICHAS*/
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

        /* Para pregunta de Terman con Checkbox, al seleccionar "Opuestos" o "Iguales" */
        .checkbox-label {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 10px;
            border: 2px solid transparent;
            border-radius: 5px;
            cursor: pointer;
            transition: border 0.3s;
        }

        /* Aplica el borde al label cuando el checkbox dentro está marcado */
        .checkbox-label:has(input[type="checkbox"]:checked) {
            border-color: #666cff;
        }

        /*Para NEGO (viñetas)*/
        .grid-vignette .vignette-cell {
            border: 1px solid #ccc;
            cursor: pointer;
            transition: 0.2s;
            position: relative;
        }
        .grid-vignette .vignette-cell:hover {
            background: rgba(0,123,255,0.1);
        }
        .grid-vignette .vignette-cell.selected::after {
            content: "El candidato debe rellenar esta parte de la viñeta";
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 0.8rem;
            color: #007bff;
            text-align: center;
            width: 90%;
        }
    </style>


</head>
<!-- Modal Bootstrap con contenido Materialize -->

<div class="modal fade" id="ventana-crear-prueba" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-fullheight">
        <div class="modal-content">
            <div class="modal-header">
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="wizard-make-test" class="bs-stepper mt-2 linear">
                    <!--Header con pasos visuales-->
                    <div class="bs-stepper-header">
                        <div class="step" data-target="#add-test">
                            <button type="button" class="step-trigger flex-lg-wrap gap-lg-2 px-lg-0">
                                <span class="bs-stepper-circle"><i class="ri-check-line"></i></span>
                                <span class="bs-stepper-label ms-lg-0">
                                    <span class="d-flex flex-column gap-1 text-lg-center">
                                        <span class="bs-stepper-title">Crea una Prueba</span>
                                        <span class="bs-stepper-subtitle">Elije a qué categoría y tipo pertenece</span>
                                    </span>
                                </span>
                            </button>
                        </div>
                        
                        <div class="line mt-lg-n4 mb-lg-3"></div>
                        <div class="step" data-target="#add-sections">
                            <button type="button" class="step-trigger flex-lg-wrap gap-lg-2 px-lg-0">
                                <span class="bs-stepper-circle"><i class="ri-check-line"></i></span>
                                <span class="bs-stepper-label ms-lg-0">
                                    <span class="d-flex flex-column gap-1 text-lg-center">
                                        <span class="bs-stepper-title">secciones</span>
                                        <span class="bs-stepper-subtitle">Crea secciones para la nueva prueba</span>
                                    </span>
                                </span>
                            </button>
                        </div>
                            
                        <div class="line mt-lg-n4 mb-lg-3"></div>
                        <div class="step" data-target="#add-questions">
                            <button type="button" class="step-trigger flex-lg-wrap gap-lg-2 px-lg-0">
                                <span class="bs-stepper-circle"><i class="ri-check-line"></i></span>
                                <span class="bs-stepper-label ms-lg-0">
                                    <span class="d-flex flex-column gap-1 text-lg-center">
                                        <span class="bs-stepper-title">Preguntas</span>
                                        <span class="bs-stepper-subtitle">Añade preguntas y sus respuestas a una sección</span>
                                    </span>
                                </span>
                            </button>
                        </div>
                    </div>

                    <div class="bs-stepper-content">
                        <!--#1-->
                        <div id="add-test" class="content fade">
                            <div class="card">
                                <!--<h5 class="card-header">Crear Test</h5>-->
                                <div class="card-body">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input id="test-titulo" type="text" class="form-control" placeholder="Título" required>
                                        <label for="test-titulo">Título</label>
                                    </div>

                                    <div class="form-floating form-floating-outline mb-4">
                                        <select id="test-categoria" class="form-select" required>
                                        </select>
                                        <label for="test-categoria">Categoría</label>
                                    </div>

                                    <div class="form-floating form-floating-outline mb-4">
                                        <select id="test-tipo" class="form-select" required>
                                        </select>
                                        <label for="test-tipo">Tipo</label>
                                    </div>

                                    <div class="form-floating form-floating-outline mb-4">
                                        <textarea id="test-instrucciones" class="form-control" placeholder="Escriba acá las instrucciones generales de la evaluación" rows="4" style="min-height: 100px;"></textarea>
                                        <label for="test-instrucciones">Instrucciones</label>
                                    </div>

                                    <button id="btn-crear-test" class="btn btn-primary w-100 mt-2">Crear prueba</button>
                                </div>
                            </div>
                        </div>

                        <!--#2-->
                        <div id="add-sections" class="content fade">
                            <div class="card mt-2">
                                <!--<h5 class="card-header">Crear Sección</h5-->
                                <div class="card-body">
                                    <div id="crear-seccion-form">
                                        <div class="form-floating form-floating-outline mb-4">
                                            <input id="seccion-titulo" type="text" class="form-control" placeholder="Título" required>
                                            <label for="seccion-titulo">Título</label>
                                        </div>

                                        <div class="form-floating form-floating-outline mb-4">
                                            <input id="seccion-bloque" type="number" class="form-control" placeholder="Bloque" required>
                                            <label for="seccion-bloque">Bloque</label>
                                        </div>

                                        <div class="form-floating form-floating-outline mb-4">
                                            <select id="seccion-test-id" class="form-select" required>
                                                <option disabled selected>Selecciona una prueba</option>
                                            </select>
                                            <label for="seccion-test-id">Prueba a la que pertenece</label>
                                        </div>

                                        <div class="form-floating form-floating-outline mb-4">
                                            <input type="text" id="seccion-tiempo" class="form-control" placeholder="Tiempo (hh:mm:ss)" value="00:00:00" required>
                                            <label for="seccion-tiempo">Tiempo (hh:mm:ss)</label>
                                        </div>

                                        <div class="form-floating form-floating-outline mb-4">
                                            <textarea id="seccion-instrucciones" class="form-control" placeholder="Escriba acá las instrucciones específicas de la sección" rows="4" style="min-height: 100px;"></textarea>
                                            <label for="seccion-instrucciones">Instrucciones</label>
                                        </div>

                                        <button id="btn-crear-seccion" class="btn btn-secondary w-100 mt-2">Crear sección</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--#3-->
                        <div id="add-questions" class="content fade">
                            <div class="col-md-12">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" id="tabs-secciones" role="tablist">
                                    <!--Aquí van pestañas de secciones creadas-->
                                </ul>

                                <!-- Tab content -->
                                <div class="tab-content mt-3" id="contenido-secciones">
                                    <!--Contenido para crear preguntas y sus respuestas-->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Botón para secciones-->
                    <button type="button"
                            class="btn btn-primary position-absolute d-none"
                            style="bottom: 1rem; right: 1rem;"
                            id="btn-avanzar-secciones">
                        <span class="align-middle d-sm-inline-block d-none me-sm-1">
                             Ya creé todas las secciones que necesito
                        </span>
                        <i class="ri-arrow-right-line"></i>

                    <!--Botón para cerrar ventana-->
                    <button type="button"
                            class="btn btn-primary position-absolute d-none"
                            style="bottom: 1rem; right: 1rem;"
                            id="btn-terminar">
                        <span class="align-middle d-sm-inline-block d-none me-sm-1">
                             Ya terminé
                        </span>
                        <i class="ri-arrow-right-line"></i>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script>
<script src="{{ asset('js/Dominos.js') }}"></script>
<script>
    let bsModal;
    let letraActualMultiple = 97; //Inicia con "a", para respuestas múltiples
    let testEnProgreso = false;
    let numBeck = 0;

    document.addEventListener('DOMContentLoaded', function () {

        let stepper = new Stepper(document.querySelector('#wizard-make-test'), {
            linear: true,
            animation: true
        });
        stepper.to(1);

        //Abrir ventana
        document.getElementById('TestBtn').addEventListener('click', function () {
            Promise.all([
                cargarCategoriasYTipos(),
                cargarPruebas()
            ]).then(() => {
                bsModal = new bootstrap.Modal(document.getElementById('ventana-crear-prueba'));
                bsModal.show();

                testEnProgreso = true;
                const testBtn = document.getElementById('TestBtn');
                if (testEnProgreso) {
                    testBtn.textContent = "Continuar creando test";
                }
            });
        });

        //Cerrar ventana
        document.getElementById('btn-terminar').addEventListener('click', function () {
            bsModal.hide();
            stepper.to(1);

            //limpiar campos
            document.getElementById('test-titulo').value = '';
            document.getElementById('test-categoria').selectedIndex = 0;
            document.getElementById('test-tipo').selectedIndex = 0;

            testEnProgreso = false;
            document.getElementById('TestBtn').textContent = "Crear nuevo test";
        })

        //crear un test
        document.getElementById('btn-crear-test').addEventListener('click', function () {
            const titulo = document.getElementById('test-titulo').value.trim();
            if (titulo === '') {
                alert('El título es obligatorio');
                return;
            }

            const data = {
                titulo: titulo,
                categoria_id: document.getElementById('test-categoria').value,
                tipo_id: document.getElementById('test-tipo').value,
                instrucciones: document.getElementById('test-instrucciones').value,
                _token: '{{ csrf_token() }}',
            };

            jQuery.ajax({
                url: `{{ url('psicometricas/admin/pruebas') }}`,
                type: "POST",
                data: data,
                dataType: "json",
                success: function (response) {
                    Swal.fire({
                        toast: true,
                        position: 'bottom-end',
                        icon: 'success',
                        title: '¡Test creado!',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        customClass: {
                            popup: 'custom-toast'
                        },
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });
                    let table = jQuery('#testsTable').DataTable();
                    table.ajax.reload(null, false);

                    const nuevoTestId = response.test.id;

                    //avanzar a paso #2
                    stepper.next();
                    const btnAvanzar = document.getElementById('btn-avanzar-secciones');
                    btnAvanzar.classList.remove('d-none');

                    //seleccionar test recién creado en el select de crear sección
                    cargarPruebas().then(() => {
                        jQuery('#seccion-test-id').val(nuevoTestId);
                    });
                    
                },
                error: function (xhr) {
                    let errorMsg = 'No se pudo crear el nuevo test.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    alert(errorMsg);
                }
            });
        });

        document.addEventListener('input', function (e) {
            if (e.target.id === 'test-instrucciones') {
                e.target.style.height = 'auto';
                e.target.style.height = (e.target.scrollHeight) + 'px';
            }
        });

        //crear una Sección
        document.getElementById('btn-crear-seccion').addEventListener('click', function () {
            const data = {
                title: document.getElementById('seccion-titulo').value,
                block: document.getElementById('seccion-bloque').value,
                test_id: document.getElementById('seccion-test-id').value,
                time_at: document.getElementById('seccion-tiempo').value,
                instructions: document.getElementById('seccion-instrucciones').value,
                _token: '{{ csrf_token() }}'
            };

            jQuery.ajax({
                url: "{{ route('secciones.store') }}",
                type: "POST",
                data: data,
                dataType: "json",
                success: function (response) {
                    Swal.fire({
                        toast: true,
                        position: 'bottom-end',
                        icon: 'success',
                        title: '¡Sección creada',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        customClass: {
                            popup: 'custom-toast'
                        },
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });
                    let table = jQuery('#testsTable').DataTable();
                    table.ajax.reload(null, false);

                    agregarPestañaDeSeccion(response.seccion);
                },
                error: function (xhr) {
                    let errorMsg = 'No se pudo crear la sección.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    alert(errorMsg);
                }
            });
        });

        document.getElementById('seccion-tiempo').addEventListener('input', function () {
            const input = $(this);
            let value = input.val();
            let cursorPosition = input.prop("selectionStart"); //Posición actual del cursor

            //Filtra caracteres no válidos y mantiene sólo números y dos puntos
            value = value.replace(/[^0-9:]/g, "");

            //Divide el valor en partes (horas, minutos, segundos)
            const partes = value.split(":");
            const horas = partes[0]?.slice(0, 2) || "00";
            const minutos = partes[1]?.slice(0, 2) || "00";
            const segundos = partes[2]?.slice(0, 2) || "00";

            //Reconstruye el valor con el formato correcto
            const nuevoValor = `${horas}:${minutos}:${segundos}`;
            input.val(nuevoValor);

            //Ajuste de la posición del cursor según la cantidad de dígitos ingresados
            if (cursorPosition <= 2) {
                if (horas.length === 2 && cursorPosition === 2) {
                    cursorPosition = 3; // Mueve el cursor después del primer ":"
                }
            } else if (cursorPosition <= 5) {
                if (minutos.length === 2 && cursorPosition === 5) {
                    cursorPosition = 6; // Mueve el cursor después del segundo ":"
                }
            } else if (cursorPosition <= 8) {
                cursorPosition = Math.min(cursorPosition, 8);
            }

            // Ajusta el cursor para que se posicione correctamente
            input.prop("selectionStart", cursorPosition);
            input.prop("selectionEnd", cursorPosition);
        });

        //botón para avanzar tras crear varias secciones
        document.getElementById('btn-avanzar-secciones').addEventListener('click', function () {
            stepper.next();
            const btnAvanzar = document.getElementById('btn-avanzar-secciones');
            btnAvanzar.classList.add('d-none');

            const btnterminar = document.getElementById('btn-terminar');
            btnterminar.classList.remove('d-none');
        });

        
        let letraActualCharCode = 97; //Inicia con "a", para las respuestas de cleaver
        //crear una pregunta
        document.body.addEventListener('click', function (event) {
            //guardar pregunta
            if (event.target && event.target.id.startsWith('btn-crear-pregunta-')) {
                const button = event.target;
                const seccionId = button.id.replace('btn-crear-pregunta-', '');

                const texto = document.querySelector(`#pregunta-texto-${seccionId}`).value;
                const tipo = document.querySelector(`#pregunta-tipo-id-${seccionId}`).value;
                const requerida = document.querySelector(`#pregunta-requerida-${seccionId}`).checked;

                const contenedor = document.querySelector(`#seccion-${seccionId}`);
                const testId = contenedor.getAttribute('data-test-id');
                const sectionId = contenedor.getAttribute('data-section-id');
                
                const { respuestas, archivos, valid } = obtenerRespuestas(sectionId);
                if (!texto || !tipo || !valid || respuestas.length === 0) {
                    Swal.fire('Error', 'Debes completar todos los campos de la pregunta y al menos una respuesta válida.', 'warning');
                    return;
                }

                const inputFile = document.querySelector(`#question-picture-${seccionId}`);
                const archivo = inputFile.files[0];

                const formData = new FormData();
                formData.append('question', texto);
                formData.append('test_id', testId);
                formData.append('section_id', sectionId);
                formData.append('question_type_id', tipo);
                formData.append('required', requerida ? 1 : 0);
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('answers', JSON.stringify(respuestas));

                //imagen pregunta
                if (archivo) {
                    formData.append('picture', archivo);
                }
                
                //imagenes respuestas
                archivos.forEach((archivoObj, index) => {
                    if (archivoObj && archivoObj.file) {
                        formData.append(`answer_files[${index}]`, archivoObj.file);
                    }
                });

                jQuery.ajax({
                    url: "{{ route('preguntas.store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    success: function (response) {
                        Swal.fire({
                            toast: true,
                            position: 'bottom-end',
                            icon: 'success',
                            title: '¡Pregunta creada!',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            customClass: {
                                popup: 'custom-toast'
                            },
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        }).then(() => {
                            //limpiar campos
                            document.querySelector(`#pregunta-texto-${seccionId}`).value = '';
                            document.querySelector(`#pregunta-tipo-id-${seccionId}`).selectedIndex = 0;
                            document.querySelector(`#pregunta-requerida-${seccionId}`).checked = false;
                            document.querySelector(`#contenedor-respuestas-previo-${seccionId}`).innerHTML = '';
                        });
                    },
                    error: function (xhr) {
                        if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                            let messages = Object.values(xhr.responseJSON.errors).flat();
                            Swal.fire({
                                icon: 'error',
                                title: 'Error de validación',
                                html: messages.join('<br>'),
                            });
                        } else {
                            Swal.fire('Error', 'No se pudo crear la pregunta con sus respuestas.', 'error');
                        }
                    }
                });

            }

            //ver cómo es la escala likert
            if (event.target && event.target.classList.contains('ver-likert')) {
                const btn = event.target;
                const wrapper = btn.closest('.likert-wrapper');
                const select = wrapper.querySelector('select[id^="likert-scale-size"]');
                const container = wrapper.querySelector('div[id^="likert-options-container"]');

                if (!select || !container) return;

                const value = parseInt(select.value);
                container.innerHTML = '';

                if (![1,2,3,4,5,6,7,8].includes(value)) {
                    container.innerHTML = '<p style="color: red;">Seleccione una escala válida.</p>';
                    return;
                }

                labels = {
                    1: ['Totalmente en desacuerdo', 'En desacuerdo', 'De acuerdo', 'Totalmente de acuerdo'],
                    2: ['Totalmente en desacuerdo', 'En desacuerdo', 'Neutral', 'De acuerdo', 'Totalmente de acuerdo'],
                    3: ['Completamente falso para mí', 'Bastante falso para mí', 'Ni verdadero ni falso para mí', 'Bastante verdadero para mí', 'Completamente verdadro para mí'], //BFQ
                    4: ['En absoluto', 'Levemente', 'Moderadamente', 'Severamente'], //BAI
                    5: ['Me desagrada mucho', 'no me gusta','Me es indiferente','Me gusta','Me gusta mucho'], //Hereford
                    6: ['Me gusta','Me es indiferente o tengo dudas','No me gusta','No conozco esa actividad o profesión'], //IPP
                    7: ['Mucho','Poco','Nada'],
                    8: ['Muy característico de mí','Bastante característico de mí','Algo característico de mí','Algo no característico de mí','Bastante poco característico de mí','Muy poco característico de mí']
                };

                labels[value].forEach(label => {
                    container.insertAdjacentHTML('beforeend', `
                        <div class="respuesta-input d-flex gap-2 align-items-center mb-2">
                            <input type="text" class="form-control answer-text" value="${label}" readonly style="flex:4;">
                        </div>`);
                });
            }

            //añadir respuesta en múltiple, reacción forzada, pares, cleaver, zavik, barsit (completar num)
            if (event.target && event.target.id.startsWith('add-respuesta-btn-')) {
                const sectionId = event.target.id.replace('add-respuesta-btn-', '');
                const container = document.getElementById(`respuestas-dinamicas-${sectionId}`);

                if (!container) return;

                const uId = Date.now() + '-' + Math.floor(Math.random() * 1000);

                // Detectar tipo de pregunta:
                const tipo = parseInt(container.dataset.questionType || 1);
                let newRespuestaHTML = '';

                switch (tipo) {
                    case 3: // Pareamiento forzado
                        newRespuestaHTML = `
                            <div class="respuesta-input" style="display:flex; gap:10px; margin-bottom:10px; align-items:center;">
                                <input type="text" class="form-control answer-text-a" placeholder="Elemento A" required style="flex:2;">
                                <input type="text" class="form-control answer-text-b" placeholder="Elemento B" required style="flex:2;">
                                <button type="button" class="remove-respuesta btn btn-rojo btn-sm" title="Eliminar par">×</button>
                            </div>
                        `;
                        break;
                    case 8:
                        //reacción forzada
                        newRespuestaHTML = `
                            <div class="respuesta-input" style="display:flex; gap:10px; margin-bottom:10px; align-items:center;">
                                <input type="text" class="form-control option-text" placeholder="Opción" required style="flex:2;">
                                <input type="text" class="form-control answer-text" placeholder="Respuesta" required style="flex:2;">
                                <button type="button" class="remove-respuesta btn btn-rojo btn-sm" title="Eliminar respuesta">×</button>
                            </div>
                        `;
                        break;
                    case 6:
                        //Patrones visuales: Dominos
                        newRespuestaHTML = `
                            <div class="respuesta-input">
                                <input type="checkbox" class="form-check-input is-correct patron-domino" title="¿El candidato debe rellenar esta Ficha?">
                                <div class="contenedor ">
                                    <div class="fila" data-fila="1">
                                        <div class="contenedor-circulos" id="circulos-1-${uId}">
                                            <input class="circulo-input answer-text" type="number" id="input-f1-${uId}" min="0" max="6">
                                        </div>
                                    </div>
                                    <div class="fila" data-fila="2">
                                        <div class="contenedor-circulos" id="circulos-2-${uId}">
                                            <input class="circulo-input answer-text" type="number" id="input-f2-${uId}" min="0" max="6">
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="remove-respuesta btn btn-rojo btn-sm" style="margin-top:5px;" title="Eliminar Ficha">×</button>
                            </div>
                            `;
                        break;
                    case 14:
                        //Cleaver
                        let letra = String.fromCharCode(letraActualCharCode); //Obtener letra actual
                        newRespuestaHTML = '';
                        for (let i = 0; i < 4; i++) {
                            newRespuestaHTML += `
                                <div class="respuesta-input" style="display:flex; gap:10px; margin-bottom:10px; align-items:center; ${i === 0 ? 'margin-top:30px;' : ''}">
                                    <input type="text" class="form-control option-text" placeholder="Opción" value="${letra}" required style="flex:1;">
                                    <input type="text" class="form-control answer-text" placeholder="característica" required style="flex:3;">
                                </div>
                            `;
                        }
                        letraActualCharCode++; //Incrementa para la próxima vez
                        break;
                    case 15:
                        //ordenar por importancia (para Zavik y Hartman)
                        const totalActual = container.querySelectorAll('.respuesta-input').length;
                        const letraOpcion = String.fromCharCode(97 + totalActual); // siguiente letra
                        newRespuestaHTML = `
                            <div class="respuesta-input" style="display:flex; gap:10px; margin-bottom:10px; align-items:center;">
                                <input type="text" class="form-control option-text" placeholder="Opción" value="${letraOpcion}" required style="flex:1;">
                                <input type="text" class="form-control answer-text" placeholder="característica" required style="flex:3;">
                            </div>
                        `;

                        break;
                    case 16:
                        //patron numérico
                        newRespuestaHTML = `
                            <div class="respuesta-input" style="display:flex; gap:10px; margin-bottom:10px; align-items:center;">
                                <input type="number" class="form-control answer-text" placeholder="Respuesta" required style="flex:2;">
                                <input type="checkbox" class="form-check-input is-correct patron-num" title="¿El candidato debe rellenarla?">
                                <button type="button" class="remove-respuesta btn btn-rojo btn-sm" title="Eliminar respuesta">×</button>
                            </div>
                        `;
                        break;
                    case 17:
                        //Comparar palabras
                        newRespuestaHTML = `
                            <div class="respuesta-input" style="display:flex; gap:10px; margin-bottom:10px; align-items:center;">
                                <input type="text" class="form-control answer-text-a" placeholder="Palabra A" required style="flex:2;">
                                <input type="text" class="form-control answer-text-b" placeholder="Palabra B" required style="flex:2;">
                                <label class="checkbox-label">
                                    <input type="checkbox" class="form-check-input is-correct opposite" title="¿Estas palabras tienen significado Opuesto?">
                                    Opuestas
                                </label>
                                <label class="checkbox-label">
                                    <input type="checkbox" class="form-check-input is-correct same"title="¿Estas palabras tienen el mismo significado?">
                                    Iguales
                                </label>
                                <button type="button" class="remove-respuesta btn btn-rojo btn-sm" title="Eliminar par">×</button>
                            </div>
                        `;
                        break;
                    case 18:
                        //pdq, varias caracteristicas
                        let letraOO = String.fromCharCode(letraActualMultiple); //Obtener letra actual

                        newRespuestaHTML = `
                            <div class="respuesta-input" style="display:flex; gap:10px; margin-bottom:10px; align-items:center;">
                                <input type="text" class="form-control option-text" placeholder="Opción" value="${letraOO}" required style="flex:1;">
                                <input type="text" class="form-control answer-text" placeholder="Respuesta" required style="flex:2;">
                                <input type="file" class="form-control answer-file" style="flex:1;"">
                                <button type="button" class="remove-respuesta btn btn-rojo btn-sm" title="Eliminar respuesta">×</button>
                            </div>
                        `;

                        letraActualMultiple++;
                        break;
                    case 19:
                        //moss
                        let letraMoss = String.fromCharCode(letraActualMultiple); //Obtener letra actual

                        newRespuestaHTML = `
                            <div class="respuesta-input" style="display:flex; gap:10px; margin-bottom:10px; align-items:center;">
                                <input type="text" class="form-control option-text" placeholder="Opción" value="${letraMoss}" required style="flex:1;">
                                <input type="text" class="form-control answer-text" placeholder="Respuesta" required style="flex:2;">
                                
                                <input type="file" class="form-control answer-file" style="flex:2;"">
                                <input type="checkbox" class="form-check-input is-correct" title="¿Es correcta?">
                                <button type="button" class="remove-respuesta btn btn-rojo btn-sm" title="Eliminar respuesta">×</button>
                            </div>
                        `;

                        letraActualMultiple++;
                        break;
                    case 20:
                        let letraB = String.fromCharCode(letraActualMultiple);

                        //Depresión de Beck
                        newRespuestaHTML = `
                            <div class="respuesta-input" style="display:flex; gap:10px; margin-bottom:10px; align-items:center;">
                                <input type="text" class="form-control score-text" placeholder="Opción" value="${numBeck}" required style="flex:0.5;">
                                <input type="text" class="form-control option-text" placeholder="Opción" value="${letraB}" required style="flex:0.5;">
                                <input type="text" class="form-control answer-text" placeholder="Respuesta" required style="flex:3;">
                                <button type="button" class="remove-respuesta btn btn-rojo btn-sm" title="Eliminar respuesta">×</button>
                            </div>
                        `;

                        numBeck++;
                        letraActualMultiple++;
                        break;
                    case 21:
                        //# de columnas definido por el usuario
                        const inputCol = document.getElementById(`num-columnas-${sectionId}`);
                        const numCol = parseInt(inputCol?.value || 0);

                        if (!numCol || numCol < 1) {
                            alert("Por favor, indica cuántas columnas tiene esta pregunta antes de añadir respuestas.");
                            return;
                        }

                        const alreadyHasTitle = container.querySelector('.title-row');

                        //Si no hay títulos, generar una fila para ellos
                        if (!alreadyHasTitle) {
                            let titleRow = `<div class="respuesta-input title-row" style="display:flex; gap:10px; margin-bottom:10px; align-items:center; margin-right:52px;">`;

                            for (let i = 0; i < numCol; i++) {
                                titleRow += `
                                    <input type="text" class="form-control title-col" placeholder="Título de columna ${i + 1}" style="flex:4; font-weight:bold;">
                                `;
                            }

                            titleRow += `</div>`;
                            container.insertAdjacentHTML('beforeend', titleRow);
                            return;
                        }

                        //Fila de inputs de respuesta abierta
                        newRespuestaHTML = `<div class="respuesta-input" style="display:flex; gap:10px; margin-bottom:10px; align-items:center;">`;

                        for (let i = 0; i < numCol; i++) {
                            newRespuestaHTML += `
                                <input type="text" class="form-control answer-text" value="Respuesta abierta" readonly style="flex:4;">
                            `
                        }

                        newRespuestaHTML += `
                                            <button type="button" class="remove-respuesta btn btn-rojo btn-sm" title="Eliminar respuesta">×</button>
                                        </div>`;
                        break;
                    default: // Selección múltiple, otro tipo aún no definido.
                        let letraM = String.fromCharCode(letraActualMultiple); //Obtener letra actual

                        newRespuestaHTML = `
                            <div class="respuesta-input" style="display:flex; gap:10px; margin-bottom:10px; align-items:center;">
                                <input type="text" class="form-control option-text" placeholder="Opción" value="${letraM}" required style="flex:1;">
                                <input type="text" class="form-control answer-text" placeholder="Respuesta" required style="flex:2;">
                                <input type="file" class="form-control answer-file" style="flex:1;"">
                                <input type="checkbox" class="form-check-input is-correct" title="¿Es correcta?">
                                <button type="button" class="remove-respuesta btn btn-rojo btn-sm" title="Eliminar respuesta">×</button>
                            </div>
                        `;

                        letraActualMultiple++;
                        break;
                }

                if (tipo === 6) {
                    const tilesContainer = container.querySelector('.lista-fichas');
                    tilesContainer.insertAdjacentHTML('beforeend', newRespuestaHTML);

                    const nuevosDominos = container.querySelectorAll('.respuesta-input:last-child .contenedor');
                    nuevosDominos.forEach(domino => inicializarDomino(domino));

                } else {
                    container.insertAdjacentHTML('beforeend', newRespuestaHTML);
                }
                updateRemoveButtons(container);
            }

            //seleccionar qué parte de una viñeta debe rellenar el candidato.
            if (e.target.classList.contains('vignette-cell')) {
                const grid = e.target.closest('.grid-vignette');
                // quitar selección de todos
                grid.querySelectorAll('.vignette-cell').forEach(c => c.classList.remove('selected'));
                e.target.classList.add('selected');
            }

        });

        //mostrar tipo de respuesta al cambiar tipo de pregunta
        document.body.addEventListener('change', function (event) {
            if (event.target && event.target.id.startsWith('pregunta-tipo-id-')) {
                const select = event.target;
                const seccionId = select.id.replace('pregunta-tipo-id-', '');
                const tipo = parseInt(select.value);
                const contenedorPrevio = document.querySelector(`#contenedor-respuestas-previo-${seccionId}`);

                const selectedOption = select.options[select.selectedIndex];
                const description = selectedOption.dataset.description || '';

                const descDiv = document.getElementById(`descripcion-tipo-${seccionId}`);
                if (descDiv) {
                    descDiv.textContent = description;
                }

                letraActualMultiple = 97;
                numBeck = 0;

                const infoBtn = document.getElementById(`tipo-info-${seccionId}`);
                if (infoBtn) {
                        const oldTooltip = M.Tooltip.getInstance(infoBtn);
                        if (oldTooltip) {
                            oldTooltip.destroy();
                        }

                        infoBtn.setAttribute('data-tooltip', description);
                        infoBtn.setAttribute('title', description);

                        M.Tooltip.init(infoBtn);
                }

                if (!isNaN(tipo) && contenedorPrevio) {
                    contenedorPrevio.innerHTML = generateRespuestaHTML(tipo, seccionId);
                    updateRemoveButtons(contenedorPrevio);
                }
            }

            if (event.target.matches('.checkbox-label input[type="checkbox"]')) {
                const label = event.target.closest('.checkbox-label');
                if (event.target.checked) {
                    label.classList.add('active');
                } else {
                    label.classList.remove('active');
                }
            }

            if (event.target.classList.contains('opposite')) {
                const parent = event.target.closest('.respuesta-input');
                if (event.target.checked) parent.querySelector('.same').checked = false;
            }

            if (event.target.classList.contains('same')) {
                const parent = event.target.closest('.respuesta-input');
                if (event.target.checked) parent.querySelector('.opposite').checked = false;
            }
        });

        //Para dominos, mostrar inputs de cols y rows si se elige forma predeterminada
        document.addEventListener('change', e => {
            if (e.target.classList.contains('form-Domino')) {
                const wrapper = e.target.closest('.contenedor-dinamico-domino');
                const show = e.target.value === 'A';
                wrapper.querySelector('.input-cols').style.display = show ? 'inline-block' : 'none';
                wrapper.querySelector('.input-rows').style.display = show ? 'inline-block' : 'none';

                const tooltipImg = wrapper.querySelector('.tooltip-img img');
                switch (e.target.value) {
                    case 'A': tooltipImg.src = "{{ asset('assets/img/help-icons/default.png') }}"; break;
                    case 'B': tooltipImg.src = "{{ asset('assets/img/help-icons/spiral.png') }}"; break;
                    case 'C': tooltipImg.src = "{{ asset('assets/img/help-icons/star.png') }}"; break;
                    default:  tooltipImg.src = "";
                }
            }
        });
    });

    //cargar contenido para crear test
    function cargarCategoriasYTipos() {
        return jQuery.ajax({
                url: "{{ route('pruebas.categorias.tipos') }}",
                type: "GET",
                dataType: "json",
                success: function (categories) {
                    const $categoria = jQuery('#test-categoria');
                    const $tipo = jQuery('#test-tipo');

                    // Limpia las opciones actuales
                    $categoria.empty();
                    $tipo.empty();

                    //Agrega opción por defecto
                    $categoria.append('<option value="" disabled selected>Selecciona una categoría</option>');

                    categories.forEach(cat => {
                        $categoria.append(`<option value="${cat.id}">${cat.category_name}</option>`);
                    });

                    //primera categoría para llenar tipos
                    const firstCategory = categories[0];
                    const tipos = firstCategory ? firstCategory.test_types : [];

                    if (tipos.length > 0) {
                        tipos.forEach((type, index) => {
                            const selected = index === 0 ? 'selected' : '';
                            $tipo.append(`<option value="${type.id}" ${selected}>${type.type_name}</option>`);
                        });
                    } else {
                        $tipo.append('<option value="" disabled selected>No hay tipos</option>');
                    }

                    // Al cambiar la categoría, actualiza tipos
                    $categoria.off('change').on('change', function () {
                        const catId = jQuery(this).val();
                        const categoriaSeleccionada = categories.find(cat => cat.id == catId);
                        const tiposNuevaCategoria = categoriaSeleccionada ? categoriaSeleccionada.test_types : [];

                        $tipo.empty();

                        if (tiposNuevaCategoria.length > 0) {
                            tiposNuevaCategoria.forEach((type, index) => {
                                const selected = index === 0 ? 'selected' : '';
                                $tipo.append(`<option value="${type.id}" ${selected}>${type.type_name}</option>`);
                            });
                        } else {
                            $tipo.append('<option value="" disabled selected>No hay tipos</option>');
                        }
                    });
                },
                error: function () {
                    alert('Error al cargar categorías');
                }
        });
    }

    //Cargar contenido para crear sección
    function cargarPruebas() {
        return jQuery.ajax({
            url: "{{ route('tests.all') }}",
            type: "GET",
            dataType: "json",
            success: function (tests) {
                const $select = jQuery('#seccion-test-id');
                $select.empty().append('<option disabled selected>Selecciona una prueba</option>');
                tests.forEach(test => {
                    $select.append(`<option value="${test.id}">${test.test_title}</option>`);
                });
            },
            error: function () {
                alert('Error al cargar pruebas');
            }
        });
    }

    //agregar pestañas en el modal por cada sección creada
    function agregarPestañaDeSeccion(seccion) {
        const seccionId = 'seccion-' + seccion.id;
        const titulo = seccion.title;

        if (!document.getElementById('tabs-secciones') || !document.getElementById('contenido-secciones')) {
            console.warn('Contenedor de pestañas no encontrado');
            return;
        }

        const tab = `
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="${seccionId}-tab" data-bs-toggle="tab" data-bs-target="#${seccionId}" type="button" role="tab" aria-controls="${seccionId}" aria-selected="false">
                    ${titulo}
                </button>
            </li>`;

        const contenido = `
            <div class="tab-pane fade" id="${seccionId}" role="tabpanel" aria-labelledby="${seccionId}-tab"
                data-test-id="${seccion.test_id}" data-section-id="${seccion.id}">
                ${generarFormPreguntaHTML(seccion)}
            </div>`;

        jQuery('#tabs-secciones').append(tab);
        jQuery('#contenido-secciones').append(contenido);

        const tabTriggerEl = document.querySelector(`#${seccionId}-tab`);
        const tabTrigger = new bootstrap.Tab(tabTriggerEl);
        tabTrigger.show();

        cargarTiposDePregunta(`#pregunta-tipo-id-${seccion.id}`);
    }

    //cargar contenido para crear una pregunta
    function generarFormPreguntaHTML(seccion){
        return `
        <div class="card mt-3">
            <div class="card-body">
                <h6 class="mb-3"><strong>Crear pregunta</strong></h6>

                <div class="row mb-2">
                    <div class="form-floating form-floating-outline mb-4">
                        <input type="text" class="form-control" id="pregunta-texto-${seccion.id}" placeholder="Pregunta" required>
                        <label for="pregunta-texto-${seccion.id}">Pregunta</label>
                    </div>
                </div>

                <h6 class="mb-2">Si la pregunta lo requiere, selecciona una imagen.</h6>
                <div class="row mb-4">
                    <div class="col-md-12 d-flex align-items-center">
                        <input id="question-picture-${seccion.id}" type="file" class="form-control">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-9">
                        <div class="form-floating form-floating-outline">
                            <select class="form-select" id="pregunta-tipo-id-${seccion.id}" required>
                                <!-- Opciones se cargan dinámicamente -->
                            </select>
                            <label for="pregunta-tipo-id-${seccion.id}">Tipo de pregunta</label>
                        </div>
                    </div>

                    <div class="col-md-2 d-flex align-items-center">
                        <div class="form-check ms-2">
                            <input class="form-check-input" type="checkbox" value="1" id="pregunta-requerida-${seccion.id}">
                            <label class="form-check-label" for="pregunta-requerida-${seccion.id}">¿Requerida?</label>
                        </div>
                    </div>
                </div>
            
                

                <!-- Ver descripción del tipo de pregunta -->
                    <button type="button" class="btn btn-sm btn-outline-secondary tipo-info"
                        id="tipo-info-${seccion.id}"
                        data-tooltip="tooltip"
                        title="Selecciona un tipo para ver su descripción"
                        style="padding: 2px 6px; font-size: 12px; line-height: 1; min-width: 60px; max-width: auto;min-height: 48px; margin-bottom: 10px; border:none;">
                          ❔ <div id="descripcion-tipo-${seccion.id}" class="text-muted small mt-1" style="margin-left:5px;"></div>
                    </button>

                <!-- Contenedor para crear respuestas -->
                <div id="contenedor-respuestas-previo-${seccion.id}" class="mb-3">
                    <div class="text-muted small mb-2">Elige un tipo de pregunta para modificar las respuestas posibles...</div>
                </div>

                <button class="btn btn-secondary w-100" id="btn-crear-pregunta-${seccion.id}">Crear pregunta</button>

                <!-- Contenedor para mostrar preguntas creadas -->
                <div id="preguntas-creadas-${seccion.id}" class="mt-4"></div>
            </div>
        </div>`;
    }

    function cargarTiposDePregunta(selectSelector) {
        $.ajax({
            url: "{{ route('question_types.all') }}",
            type: "GET",
            dataType: "json",
            success: function (tipos) {
                const $select = $(selectSelector);
                $select.empty().append('<option disabled selected>Selecciona tipo</option>');
                tipos.forEach(tipo => {
                    $select.append(`<option value="${tipo.id}" data-description="${tipo.description || ''}">${tipo.name}</option>`);
                });
            },
            error: function () {
                alert("Error al cargar los tipos de pregunta.");
            }
        });
    }

    //Mostrar form para crear respuesta según el tipo de la pregunta ya creada
    function generateRespuestaHTML(questionType, sectionId) {
        const alreadyHasAddButton = !!document.getElementById('add-respuesta-btn');
        let html = '';


        switch (questionType) {
            case 2:
            // Escala tipo Likert (1 a 5)
                return `
                    <div class="likert-wrapper">
                        <div class="respuesta-input" id="likert-config" style="display:flex; gap:10px; margin-bottom:10px; align-items:center;">
                            <label style="font-weight: bold;">Tamaño de la escala:</label>
                            <select id="likert-scale-size" class="form-control" style="width: 200px;">
                                <option value="">Seleccione</option>
                                <option value="1">Escala de 4 puntos de acuerdo</option>
                                <option value="2">Escala de 5 puntos de acuerdo</option>
                                <option value="3">Escala de 5 puntos de verdadero/falso para BFQ</option>
                                <option value="4">Escala de 4 puntos de frecuencia para BAI</option>
                                <option value="5">Escala de 5 puntos de gusto para Hereford</option>
                                <option value="6">Escala de 4 puntos de gusto para IPP</option>
                                <option value="7">Escala de 3 puntos de aptitud para IPP</option>
                                <option value="8">Escala de 6 puntos para Rathus</option>
                            </select>
                            <button type="button" class="ver-likert btn btn-azul btn-sm" title="Ver las opciones de esta escala"> ? </button>
                        </div>
                        <div id="likert-options-container" style="margin-top: 10px;"></div>
                    </div>
                    `;
                break;
            case 3:
                //Pareamiento forzado
                    html += `<div id="respuestas-dinamicas-${sectionId}" data-question-type="3"></div>`;

                    if (!alreadyHasAddButton) {
                        html += `
                            <button type="button" id="add-respuesta-btn-${sectionId}" class="btn btn-azul mt-1" style="width:100%; margin-bottom:10px">
                                + Añadir respuesta
                            </button>
                        `;
                    }

                    return html;
                break;
            case 4:
                //doble opción
                    return `
                        <div class="respuesta-input" style="display:flex; gap:10px; margin-bottom:10px; align-items:center;">
                            <input type="text" class="form-control option-text" placeholder="Opción" value="a" required style="flex:2;">
                            <input type="text" class="form-control answer-text" placeholder="Respuesta" required style="flex:2;">
                            <input type="checkbox" class="form-check-input is-correct" title="¿Es correcta?">
                            <button type="button" class="remove-respuesta btn btn-rojo btn-sm" title="Eliminar respuesta">×</button>
                        </div>
                        <div class="respuesta-input" style="display:flex; gap:10px; margin-bottom:10px; align-items:center;">
                            <input type="text" class="form-control option-text" placeholder="Opción" value="b" required style="flex:2;">
                            <input type="text" class="form-control answer-text" placeholder="Respuesta" required style="flex:2;">
                            <input type="checkbox" class="form-check-input is-correct" title="¿Es correcta?">
                            <button type="button" class="remove-respuesta btn btn-rojo btn-sm" title="Eliminar respuesta">×</button>
                        </div>
                    `;
                break;
            case 5:
                //Verdadero o Falso
                    return `
                        <div class="ordenar">
                            ¿El candidato debe re-ordenar el texto de la pregunta? <input type="checkbox" class="form-check-input ordenar-checkbox" title="¿El candidato debe ordenar el texto?">
                        </div>
                        <div class="respuesta-input" style="display:flex; gap:10px; margin-bottom:10px; align-items:center;">
                            <input type="text" class="form-control option-text" value="a" readonly style="width: 60px;">
                            <input type="text" class="form-control answer-text" value="Verdadero" readonly required style="flex:2;">
                            <input type="checkbox" class="form-check-input is-correct" title="¿Es correcta?">
                        </div>
                        <div class="respuesta-input" style="display:flex; gap:10px; margin-bottom:10px; align-items:center;">
                            <input type="text" class="form-control option-text" value="b" readonly style="width: 60px;">
                            <input type="text" class="form-control answer-text" value="Falso" readonly required style="flex:2;">
                            <input type="checkbox" class="form-check-input is-correct" title="¿Es correcta?">
                        </div>
                    `;
                break;
            case 6:
                //Figuras incompletas
                    html += `<div id="respuestas-dinamicas-${sectionId}" data-question-type="${questionType}" class="contenedor-dinamico-domino">
                                
                                <div class="domino-config" style="margin-bottom: 10px; display: flex; flex-wrap: wrap; gap:10px;">
                                    <select id="form-Domino-${sectionId}" name="form-Domino-${sectionId}}" class="form-select form-Domino" style="flex:2;">
                                        <option value="">Seleccione la forma de los Dominos</option>
                                        <option value="A">Predeterminada</option>
                                        <option value="B">Espiral</option>
                                        <option value="C">Circular</option>
                                    </select>

                                   <div class="help-icon">?
                                        <div class="tooltip-img">
                                            <img src="{{ asset('assets/img/help-icons/default.png') }}" alt="Ejemplo de organización predeterminada">
                                        </div>
                                    </div>

                                    <input id="input-cols-${sectionId}" name="input-cols-${sectionId}" type="number" class="form-control input-cols" placeholder="Columnas" min="1" style="width:100px;display:none;">
                                    <input id="input-rows-${sectionId}" name="input-rows-${sectionId}" type="number" class="form-control input-rows" placeholder="Filas" min="1" style="width:100px;display:none;">
                                </div>

                                <div class="lista-fichas"></div>
                            </div>`;

                    // Botón para añadir nuevas respuestas
                    html += `
                        <button type="button" id="add-respuesta-btn-${sectionId}" class="btn btn-azul mt-1" style="width:100%; margin-bottom:10px;">
                            + Añadir una ficha de Domino
                        </button>
                    `;
                    return html;
                break;
            case 10:
                // Pregunta Abierta
                return `
                    <div class="respuesta-input" style="display:flex; gap:10px; margin-bottom:10px; align-items:center;">
                        <input type="text" class="form-control answer-text" value="Respuesta abierta" readonly style="flex:4;">
                    </div>
                `;
                break;
            case 22:
                // Pregunta Bender
                return `
                    <div class="respuesta-input" style="display:flex; gap:10px; margin-bottom:10px; align-items:center;">
                        <input type="text" class="form-control answer-text" value="Respuesta por foto de usuario" readonly style="flex:4;">
                    </div>
                `;
                break;
            case 14:
            case 15:
                //Cleaver o Zavik (Bloques de 4 características)
                    html += `<div id="respuestas-dinamicas-${sectionId}" data-question-type="${questionType}">`;

                    for (let i = 0; i < 4; i++) {
                        let letraOpcion = String.fromCharCode(97 + i); // 'a', 'b', 'c', 'd'
                        html += `
                            <div class="respuesta-input" style="display:flex; gap:10px; margin-bottom:10px; align-items:center; ${i === 0 ? 'margin-top:30px;' : ''}">
                                <input type="text" class="form-control option-text" placeholder="Opción" value="${letraOpcion}" required style="flex:1;">
                                <input type="text" class="form-control answer-text" placeholder="característica" required style="flex:3;">
                            </div>
                        `;
                    }
                    // Botón para añadir nuevas respuestas
                    html += `</div>
                        <button type="button" id="add-respuesta-btn-${sectionId}" class="btn btn-azul mt-1" style="width:100%; margin-bottom:10px;">
                            + Añadir un bloque de características
                        </button>
                    `;
                    return html;
                break;
            case 16:
                //patrón num (barsit)
                    html += `<div id="respuestas-dinamicas-${sectionId}" data-question-type="${questionType}"></div>`;

                    // Botón para añadir nuevas respuestas
                    html += `
                        <button type="button" id="add-respuesta-btn-${sectionId}" class="btn btn-azul mt-1" style="width:100%; margin-bottom:10px;">
                            + Añadir un número
                        </button>
                    `;
                    return html;
                break;
            case 17:
                //Comparar significados de palabras (Terman-Merrill)
                    html += `<div id="respuestas-dinamicas-${sectionId}" data-question-type="${questionType}"></div>`;

                    // Botón para añadir nuevas respuestas
                    html += `
                        <button type="button" id="add-respuesta-btn-${sectionId}" class="btn btn-azul mt-1" style="width:100%; margin-bottom:10px;">
                            + Añadir otro par de palabras
                        </button>
                    `;
                break;
            case 18:
                //varias caracteristicas (pdq, ipp, terman)
                    html += `
                            <div class="form-floating form-floating-outline mb-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="number" id="num-answers-allowed-${sectionId}" class="form-control" min="1" placeholder="Ej. 2">
                                    <label for="num-answers-allowed-${sectionId}">¿Cuál es el máximo de respuestas que el candidato puede marcar?</label>
                                </div>
                            </div>
                        `;

                    html += `<div id="respuestas-dinamicas-${sectionId}" data-question-type="${questionType}"></div>`;

                    // Botón para añadir nuevas respuestas
                    html += `
                        <button type="button" id="add-respuesta-btn-${sectionId}" class="btn btn-azul mt-1" style="width:100%; margin-bottom:10px;">
                            + Añadir respuesta
                        </button>
                    `;
                    return html;
                break;
            case 19:
                //moss
                html += `<select class="form-select aspecto mb-3">
                                <option value="">Seleccione una opción</option>
                                <option value="A">A. Habilidad en Supervisión.</option>
                                <option value="B">B. Capacidad de decisión en las relaciones humanas.</option>
                                <option value="C">C. Capacidad de evacuación de problemas interpersonales.</option>
                                <option value="D">D. Habilidad para establecer relaciones interpersonales.</option>
                                <option value="E">E. Sentido común y tacto en las relaciones interpersonales.</option>
                         </select>`
                
                html += `<div id="respuestas-dinamicas-${sectionId}" data-question-type="${questionType}"></div>`;

                    // Botón para añadir nuevas respuestas
                    html += `
                        <button type="button" id="add-respuesta-btn-${sectionId}" class="btn btn-azul mt-1" style="width:100%; margin-bottom:10px;">
                            + Añadir respuesta
                        </button>
                    `;
                break;
            case 21:
                    html += `
                            <div class="form-floating form-floating-outline mb-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="number" id="num-columnas-${sectionId}" class="form-control" min="1" placeholder="Ej. 2">
                                    <label for="num-columnas-${sectionId}">¿Cuántas columnas tiene esta pregunta?</label>
                                </div>
                            </div>
                        `;

                    html += `<div id="respuestas-dinamicas-${sectionId}" data-question-type="${questionType}"></div>`;

                    html += `
                        <button type="button" id="add-respuesta-btn-${sectionId}" class="btn btn-azul mt-1" style="width:100%; margin-bottom:10px;">
                            + Añadir respuestas
                        </button>
                    `;
                break;
            case 23:
                //dialogo en viñeta
                return `
                        <div class="vignette-wrapper" id="respuestas-dinamicas-${sectionId}" data-question-type="4">
                            <div class="grid-vignette" style="display:grid; grid-template-columns:1fr 1fr; grid-template-rows:1fr 1fr; width:400px; height:400px; background:#fff; border:2px solid #ccc;">
                                <div class="vignette-cell" data-pos="tl"></div>
                                <div class="vignette-cell" data-pos="tr"></div>
                                <div class="vignette-cell" data-pos="bl"></div>
                                <div class="vignette-cell" data-pos="br"></div>
                                <input type="file" class="form-control answer-file" style="flex:1;"">
                            </div>
                        </div>
                    `;
                break;
            default:
                //Selección múltiple(1), reacción forzada(8)
                    html += `<div id="respuestas-dinamicas-${sectionId}" data-question-type="${questionType}"></div>`;

                    // Botón para añadir nuevas respuestas
                    html += `
                        <button type="button" id="add-respuesta-btn-${sectionId}" class="btn btn-azul mt-1" style="width:100%; margin-bottom:10px;">
                            + Añadir respuesta
                        </button>
                    `;
                    return html;
                break;
            }

        return html;
    }

    //quitar una respuesta añadida
    function updateRemoveButtons(containerSelector) {
        const container = typeof containerSelector === 'string' ? document.querySelector(containerSelector) : containerSelector;
        if (!container) return;

        container.querySelectorAll('.remove-respuesta').forEach(btn => {
            btn.onclick = () => {
                if (container.querySelectorAll('.respuesta-input').length > 1) {
                    btn.parentElement.remove();
                    letraActualMultiple--;
                    numBeck--;
                }
            };
        });
    }


    function obtenerRespuestas(sectionId) { 

        const container = document.getElementById(`contenedor-respuestas-previo-${sectionId}`);
        if (!container) {
            console.warn(`Contenedor de respuestas no encontrado`);
            return;
        }
        const tipo = document.querySelector(`#pregunta-tipo-id-${sectionId}`);
        const questionType = parseInt(tipo.value || '1');

            const respuestas = [];
            const archivos = [];
            let valid = true;

            switch (questionType) {
                case 2: // Likert
                    const scaleSize = parseInt(document.getElementById('likert-scale-size').value);
                    if (!scaleSize || ![1, 2, 3, 4, 5, 6, 7, 8].includes(scaleSize)) {
                        valid = false;
                        break;
                    }

                    const labels = {
                        1: ['Totalmente en desacuerdo', 'En desacuerdo', 'De acuerdo', 'Totalmente de acuerdo'],
                        2: ['Totalmente en desacuerdo', 'En desacuerdo', 'Neutral', 'De acuerdo', 'Totalmente de acuerdo'],
                        3: ['Completamente falso para mí', 'Bastante falso para mí', 'Ni verdadero ni falso para mí', 'Bastante verdadero para mí', 'Completamente verdadro para mí'], //BFQ
                        4: ['En absoluto', 'Levemente', 'Moderadamente', 'Severamente'], //BAI
                        5: ['Me desagrada mucho', 'no me gusta','Me es indiferente','Me gusta','Me gusta mucho'], //Hereford
                        6: ['Me gusta','Me es indiferente o tengo dudas','No me gusta','No conozco esa actividad o profesión'], //IPP
                        7: ['Mucho','Poco','Nada'],
                        8: ['Muy característico de mí','Bastante característico de mí','Algo característico de mí','Algo no característico de mí','Bastante poco característico de mí','Muy poco característico de mí']
                    };

                    labels[scaleSize].forEach((label, index) => {

                        const extraData = {
                            scale_type: scaleSize,
                            label_index: index + 1
                        };

                         if (scaleSize === 6) {
                            if (index === 0) {
                                extraData.score = 2;
                            } else if (index === 2) {
                                extraData.score = 1;
                            } else {
                                extraData.score = 0;
                            }
                        }
                        
                        respuestas.push({
                            answer: label,
                            option: String.fromCharCode(97 + index),
                            is_correct: null,
                            extra_data: extraData
                        });
                    });
                    break;

                case 3: // Pareamiento forzado
                    document.querySelectorAll('.respuesta-input').forEach(input => {
                        const answerA = input.querySelector('.answer-text-a')?.value.trim();
                        const answerB = input.querySelector('.answer-text-b')?.value.trim();

                        if (answerA && answerB) {
                            const pairId = 'pair_' + Math.random().toString(36).substr(2, 9);
                            respuestas.push(
                                { answer: answerA, extra_data: { pair_id: pairId } },
                                { answer: answerB, extra_data: { pair_id: pairId } }
                            );
                        } else {
                             valid = false;
                        }
                    });
                    break;
                case 6: //Figuras incompletas: Dominos
                    container.querySelectorAll('.respuesta-input').forEach(input => {
                        const patronDom = input.querySelector('.patron-domino');
                        const fillable = patronDom?.checked || false;

                        const topCircles = input.querySelectorAll('.fila[data-fila="1"] .circulo').length;
                        const bottomCircles = input.querySelectorAll('.fila[data-fila="2"] .circulo').length;

                        const isTopValid = topCircles >= 0 && topCircles <= 6;
                        const isBottomValid = bottomCircles >= 0 && bottomCircles <= 6;

                        
                        const formSelect = document.querySelector(`#form-Domino-${sectionId}`);
                        const colsInput = document.querySelector(`#input-cols-${sectionId}`);
                        const rowsInput = document.querySelector(`#input-rows-${sectionId}`);
                        const formValue = formSelect?.value || '';
                        const cols = parseInt(colsInput?.value) || null;
                        const rows = parseInt(rowsInput?.value) || null;

                        if (isTopValid && isBottomValid) {
                            const extraData = {
                                top: topCircles,
                                bottom: bottomCircles,
                                fillable: fillable
                            };

                        if (formValue === 'B') {
                            extraData.shape = 'spiral';
                        } else if (formValue === 'C') {
                            extraData.shape = 'star';
                        } else if (formValue === 'A') {
                            extraData.shape = 'default';
                            if (cols) extraData.cols = cols;
                            if (rows) extraData.rows = rows;
                        }

                            respuestas.push({
                                answer: `${topCircles}-${bottomCircles}`,
                                option: null,
                                is_correct: null,
                                extra_data: extraData
                            });
                        } else {
                            valid = false;
                        }
                    });
                    break;
                default:
                    // Otros tipos que usan una sola respuesta por input
                    document.querySelectorAll('.respuesta-input').forEach(input => {
                        const answerEl = input.querySelector('.answer-text');
                        const optionEl = input.querySelector('.option-text');
                        const isCorrectEl = input.querySelector('.is-correct');

                        const answer = answerEl ? answerEl.value.trim() : '';
                        const option = optionEl ? optionEl.value.trim() : '';
                        
                        let is_correct = null;

                        if (questionType !== 8 && isCorrectEl) {
                            is_correct = isCorrectEl.checked ? 1 : 0;
                        }

                        switch (questionType) {
                            case 5: // Verdadero/Falso
                                if (answer && option) {
                                      const ordenarCheckbox = document.querySelector('.ordenar-checkbox');
                                    const debeOrdenar = ordenarCheckbox?.checked || false;
                                    respuestas.push({
                                        answer,
                                        option,
                                        is_correct,
                                        extra_data: {
                                            ordenar: debeOrdenar
                                        }
                                    });
                                } else {
                                    valid = false;
                                }
                                break;
                            case 10: // Abierta
                            case 22:
                                if (answer) respuestas.push({ answer });
                                else valid = false;
                                break;
                            case 16: //patron num
                                const patronNumEl = input.querySelector('.patron-num');
                                const fillable = patronNumEl?.checked || false;

                                if (answer) {
                                        respuestas.push({
                                            answer: answer,
                                            option: null,
                                            is_correct: null,
                                            extra_data: {
                                                fillable: fillable,
                                            }
                                        });
                                    }
                                break;
                            case 17: //comparar palabras
                                const answerA = input.querySelector('.answer-text-a')?.value.trim();
                                const answerB = input.querySelector('.answer-text-b')?.value.trim();

                                const oEl = input.querySelector('.opposite');
                                const iEl = input.querySelector('.same');

                                const isO = oEl?.checked || false;
                                const isI = iEl?.checked || false;

                                if (answerA && answerB && (isO !== isI)) {
                                    const answer = `${answerA} ${answerB}`;
                                    const comparison = isO ? 'opposite' : 'same';

                                    respuestas.push({
                                        answer: answer,
                                        option: null,
                                        is_correct: null,
                                        extra_data: {
                                            comparison: comparison
                                        }
                                    });
                                } else {
                                    valid = false;
                                }
                                break;
                            case 19:
                                const contenedor = document.querySelector(`#contenedor-respuestas-previo-${sectionId}`);
                                const AspectSelectEl = contenedor.querySelector('.aspecto');
                                const AspectValue = AspectSelectEl?.value || '';

                                if (answer && option && AspectValue) {
                                    respuestas.push({
                                        answer,
                                        option,
                                        is_correct,
                                        extra_data: {
                                            Aspecto: AspectValue
                                        }
                                    });
                                }
                                break;
                            case 20:
                                const scoreValue = input.querySelector('.score-text')?.value.trim();

                                if (answer && option && scoreValue) {
                                    respuestas.push({
                                        answer,
                                        option,
                                        is_correct,
                                        extra_data: {
                                            beck_score: scoreValue
                                        }
                                    });
                                }
                                break;
                            case 23: // Viñeta
                                const grid = container.querySelector('.grid-vignette');
                                if (grid) {
                                    const selected = grid.querySelector('.vignette-cell.selected');
                                    if (selected) {
                                        const dialog = selected.dataset.pos;

                                        respuestas.push({
                                            answer: "Viñeta seleccionada",
                                            option: null,
                                            is_correct: null,
                                            extra_data: {
                                                quadrant: dialog
                                            }
                                        });
                                    } else {
                                        valid = false;
                                    }

                                    const fileEl = grid.querySelector('.answer-file');
                                    if (fileEl && fileEl.files.length > 0) {
                                        archivos.push({ file: fileEl.files[0] });
                                    }
                                } else {
                                    valid = false;
                                }
                                break;
                                default:
                                const fileEl = input.querySelector('.answer-file');
                                const file = fileEl && fileEl.files.length > 0 ? fileEl.files[0] : null;
                                if (answer && option) {
                                    respuestas.push({ answer, option, is_correct });
                                    archivos.push({ file });
                                } else {
                                     valid = false;
                                }
                                break;
                        }
                    });
                break;
            }    

        return {respuestas, archivos, valid};
    }
</script>




