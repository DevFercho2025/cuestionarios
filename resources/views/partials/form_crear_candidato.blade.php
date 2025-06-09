    <head>
        <style>
            select.browser-default {
            background-color: transparent;
            border: 1px solid rgb(89, 91, 117);
            border-radius: 10px;
            color: #B2B3CA;
            font-size: 14px;
            outline: none;
            transition: border-color 0.3s ease;
            margin-top: 2px;
            width: 100%;
            height: 48px;
        }

        select.browser-default option {
            background-color: #21243d; 
            color: #cbd5f7; 
        }

        .select-container {
        position: relative;
        width: 100%;
        }


        .select-label {
            position: absolute;
            top: 0;
            left: 12px;
            padding: 0 6px;
            font-size: 0.8125rem;
            background-color: #30334e;
            color: rgba(var(--bs-body-color-rgb), 1);
            transform: translateY(-40%);
            pointer-events: none; 
        }

        </style>
    </head>
    
    <h4>Añade un candidato</h4>
        <div id="wizard-registro-candidato" class="bs-stepper mt-2 linear">
          <div class="bs-stepper-header">

            <div class="step" data-target="#identificacion">
              <button type="button" class="step-trigger flex-lg-wrap gap-lg-2 px-lg-0">
                <span class="bs-stepper-circle"><i class="ri-check-line"></i></span>
                <span class="bs-stepper-label ms-lg-0">
                  <span class="d-flex flex-column gap-1 text-lg-center">
                    <span class="bs-stepper-title">Identificación</span>
                    <span class="bs-stepper-subtitle">Nombre del candidato</span>
                  </span>
                </span>
              </button>
            </div>
            <!-- aria-selected="false" o true-->
            <div class="line mt-lg-n4 mb-lg-3"></div>
            <div class="step" data-target="#detalles-personales">
              <button type="button" class="step-trigger flex-lg-wrap gap-lg-2 px-lg-0">
                <span class="bs-stepper-circle"><i class="ri-check-line"></i></span>
                <span class="bs-stepper-label ms-lg-0">
                  <span class="d-flex flex-column gap-1 text-lg-center">
                    <span class="bs-stepper-title">Detalles</span>
                    <span class="bs-stepper-subtitle">Otra información personal</span>
                  </span>
                </span>
              </button>
            </div>
            
            <div class="line mt-lg-n4 mb-lg-3"></div>
            <div class="step" data-target="#ubicacion-contacto">
              <button type="button" class="step-trigger flex-lg-wrap gap-lg-2 px-lg-0">
                <span class="bs-stepper-circle"><i class="ri-check-line"></i></span>
                <span class="bs-stepper-label ms-lg-0">
                  <span class="d-flex flex-column gap-1 text-lg-center">
                    <span class="bs-stepper-title">Contexto adicional</span>
                    <span class="bs-stepper-subtitle">Añade ubicación y contacto</span>
                  </span>
                </span>
              </button>
            </div>
          </div>


          <div class="bs-stepper-content">
            <form id="wizard-registro-candidato-form"
              method="POST"
              action="{{ route('candidatos.store') }}">
              @csrf

              <!--Paso 1: Nombre del candidato-->
              <div id="identificacion" class="content dstepper-block fv-plugins-bootstrap5 fv-plugins-framework">
                <div class="content-header mb-4">
                  <h6 class="mb-0">Identificación</h6>
                </div>

                <div class="row g-5">
                  <div class="col-sm-12 fv-plugins-icon-container">
                    <div class="form-floating form-floating-outline">
                      <input type="text" id="candidate-firstName" name="firstname"
                             class="form-control" placeholder="Ingrese el nombre del candidato">
                      <label for="candidate-firstName">Nombre</label>
                    </div>
                  <div id="firstname-error" class="invalid-feedback"></div></div>
                  
                  <div class="col-sm-6">
                    <div class="input-group input-group-merge">
                      <div class="form-floating form-floating-outline">
                        <input type="text" id="candidate-lastname-1" name="lastname-1"
                               class="form-control" placeholder="Ingrese el apellido paterno">
                        <label for="candidate-lastname-1">Apellido Paterno</label>
                      </div>
                    </div>
                  <div id="lastname-error" class="invalid-feedback"></div></div>
                  
                  <div class="col-sm-6">
                    <div class="input-group input-group-merge">
                      <div class="form-floating form-floating-outline">
                        <input type="text" id="candidate-lastname-2" name="lastname-2"
                               class="form-control" placeholder="Ingrese el apellido materno">
                        <label for="candidate-lastname-2">Apellido Materno</label>
                      </div>
                      <span class="input-group-text cursor-pointer" id="NoAplica">N/A</span>
                    </div>
                  <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>


                  <div class="col-12 d-flex justify-content-between">
                    <button class="btn btn-outline-secondary btn-prev waves-effect" disabled>
                      <i class="ri-arrow-left-line me-sm-1 me-0"></i>
                      <span class="align-middle d-sm-inline-block d-none">Anterior</span>
                    </button>
                    <button type="button" class="btn btn-primary btn-next waves-effect waves-light" id="next-step-nombre"
                      onclick="saveDataAndContinue('identificacion','detalles-personales')">
                      <span class="align-middle d-sm-inline-block d-none me-sm-1">Siguiente</span>
                      <i class="ri-arrow-right-line"></i>
                    </button>
                  </div>
                </div>
              </div>

              <!-- Paso 2: Otros detalles personales -->
              <div id="detalles-personales" class="content fv-plugins-bootstrap5 fv-plugins-framework">
                <div class="content-header mb-4">
                  <h6 class="mb-0">Detalles personales</h6>
                </div>

                <div class="row g-5">
                  <div class="col-sm-12">
                    <div class="form-floating form-floating-outline">
                      <input type="email" id="user-email" name="email"
                      class="form-control" placeholder="nombre@ejemplo.com"/>
                      <label for="user-email">Correo electrónico</label>
                    </div>
                  <div id="email-error" class="invalid-feedback"></div></div>

                  <div class="col-sm-6 fv-plugins-icon-container">
                    <div class="form-floating form-floating-outline mb-6">
                        <div class="select-container">
                            <label for="candidate-genero-legal" name="gen" class="select-label">Género legal</label>
                            <select class="browser-default" id="candidate-genero-legal" >
                                <option value="" disabled selected>  Elija una opción</option>
                                <option value="F">  Femenino</option>
                                <option value="M">  Masculino</option>
                            </select>
                        </div>
                        <!--<select class="browser-default" id="candidate-genero-legal" name="gen">
                          <option value="" disabled selected>Elija una opción</option>
                          <option value="F">Femenino</option>
                          <option value="M">Masculino</option>
                        </select>
                        <label for="candidate-genero-legal">Género Legal</label>-->
                      </div>
                  <div id="genero-error" class="invalid-feedback"></div></div>
                  
                  <div class="col-sm-6 fv-plugins-icon-container">
                    <div class="form-floating form-floating-outline mb-6">
                      <input  type="date" id="nacimiento-candidato" name="birthdate" class="form-control">
                      <label for="nacimiento-candidato">Fecha de Nacimiento</label>
                    </div>
                  <div id="nacimiento-error" class="invalid-feedback"></div></div>

                 <div class="col-12 d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary btn-prev waves-effect"
                      onclick="goToForm('identificacion')">
                      <i class="ri-arrow-left-line me-sm-1 me-0"></i>
                      <span class="align-middle d-sm-inline-block d-none">Anterior</span>
                    </button>
                    <button type="button" class="btn btn-primary btn-next waves-effect waves-light"
                      onclick="saveDataAndContinue('detalles-personales','ubicacion-contacto')">
                        <span class="align-middle d-sm-inline-block d-none me-sm-1">Siguiente</span>
                        <i class="ri-arrow-right-line"></i>
                    </button>
                  </div>
                </div>
              </div>

              <!--Paso 3: Ubicación y contacto -->
              <div id="ubicacion-contacto" class="content fv-plugins-bootstrap5 fv-plugins-framework">
                <div class="content-header mb-4">
                  <h6 class="mb-0">Contexto adicional</h6>
                  <small>Ubicación y contacto</small>
                </div>
                <div class="row g-5">
                  <div class="col-sm-12">
                    <div class="form-floating form-floating-outline mb-6">
                        
                        <select class="browser-default" id="pais-candidato" name="pais">
                          <option selected="">Elija una opción</option>
                          <option value="MX">México</option>
                          <option value="US">Estados Unidos</option>
                          <option value="ES">España</option>
                          <option value="AR">Argentina</option>
                          <option value="CO">Colombia</option>
                          <option value="CL">Chile</option>
                          <option value="PE">Perú</option>
                        </select>
                        <label for="pais-candidato">Pais</label>
                      </div>
                  <div id="pais-error" class="invalid-feedback"></div></div>
                  

                  <div class="col-sm-6">
                    <div class="form-floating form-floating-outline">
                      <input type="text" id="candidate-postalcode" name="postalcode"
                      class="form-control" placeholder="Ingrese el código postal del candidato">
                      <label for="candidate-postalcode">Código Postal</label>
                    </div>
                  <div id="postalcode-error" class="invalid-feedback"></div></div>


                  <div class="col-sm-6">
                    <div class="form-floating form-floating-outline">
                      <div class="input-group input-group-merge">
                        <span id="basic-icon-default-phone2" class="input-group-text"><i class="ri-phone-fill"></i></span>
                        <input type="tel" id="candidate-cellphone" name="cellphone"
                          pattern="[0-9]{10}" maxlength="10" oninput="this.value = this.value.replace(/\D/g, '')"
                          class="form-control" placeholder="Ingrese el celular del candidato">
                      </div>
                    <div id="cellphone-error" class="invalid-feedback"></div></div>
                  </div>

                 <div class="col-12 d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary btn-prev waves-effect"
                      onclick="goToForm('detalles-personales')">
                      <i class="ri-arrow-left-line me-sm-1 me-0"></i>
                      <span class="align-middle d-sm-inline-block d-none">Anterior</span>
                    </button>
                    <button type="submit" class="btn btn-primary btn-next waves-effect waves-light"
                        onclick="validateInfo()">
                        <span class="align-middle d-sm-inline-block d-none me-sm-1">Siguiente</span>
                        <i class="ri-arrow-right-line"></i>
                    </button>
                  </div>

                </div>
              </div>

              <input type="hidden" id="input-genero_legal"     name="genero_legal" />
              <input type="hidden" id="input-nacimiento"       name="nacimiento" />
              <input type="hidden" id="input-pais"             name="pais" />
              <input type="hidden" id="input-codigo_postal"    name="codigo_postal" />
              <input type="hidden" id="input-telefono"         name="telefono" />
              <input type="hidden" id="input-firstname"        name="firstname" />
              <input type="hidden" id="input-lastname"         name="lastname" />
              <input type="hidden" id="input-email"            name="email" />
            </form>
          </div>
        </div>
        
<script>
    let formData = {
        //info adicional candidato
        genero_legal: null,
        nacimiento: null,
        pais: null,
        codigo_postal: null,
        telefono: null,

        // Datos de usuario
        firstname: null,
        lastname: null,
        email: null,
    };

    document.addEventListener('DOMContentLoaded', () => {

        // Inicializar BS-Stepper
        setTimeout(() => {
            try {
                const wizard = document.querySelector('#wizard-registro-candidato');
                if (wizard) {
                    window.bsStepper = new window.Stepper(wizard, { linear: true });
                    Array.from(wizard.querySelectorAll('.btn-next'))
                        .filter(btn => !btn.hasAttribute('onclick'))
                        .forEach(btn => btn.addEventListener('click', () => window.bsStepper.next()));
                    Array.from(wizard.querySelectorAll('.btn-prev'))
                        .filter(btn => !btn.hasAttribute('onclick'))
                        .forEach(btn => btn.addEventListener('click', () => window.bsStepper.previous()));
                }
            } catch (err) {
                console.error('Error al inicializar el stepper:', err);
            }
        }, 500);

        // Campos ocultos: rellenar antes de enviar
        const form = document.getElementById('wizard-registro-candidato-form');
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            if (!validateInfo()) {
                return;
            }
            //info adicional candidato
            document.getElementById('input-genero_legal').value = formData.genero_legal;
            document.getElementById('input-nacimiento').value = formData.nacimiento;
            document.getElementById('input-pais').value = formData.pais;
            document.getElementById('input-codigo_postal').value = formData.codigo_postal;
            document.getElementById('input-telefono').value = formData.telefono;

            // Datos de usuario
            document.getElementById('input-firstname').value = formData.firstname;
            document.getElementById('input-lastname').value = formData.lastname;
            document.getElementById('input-email').value = formData.email;
            console.log("Enviando formulario...");
            const formDataObj = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formDataObj, // Enviar los datos del formulario
                headers: {
                    'Accept': 'application/json', // Esperamos una respuesta JSON
                }
            })
                .then(response => response.json()) // Parsear la respuesta JSON
                .then(data => {
                    if (data.success) {
                        form.reset();
                        formData = {
                            genero_legal: null,
                            nacimiento: null,
                            pais: null,
                            codigo_postal: null,
                            telefono: null,
                            firstname: null,
                            lastname: null,
                            email: null,
                        };

                        // Reiniciar el stepper al primer paso si deseas
                        if (window.bsStepper) {
                            window.bsStepper.to(1);
                        }
                        // Mostrar un mensaje de éxito con SweetAlert2
                        Swal.fire({
                            icon: 'success',
                            title: '¡Candidato creado exitosamente!',
                            text: 'El candidato ha sido creado correctamente.',
                            confirmButtonText: 'Aceptar'
                        });
                    } else {
                        // Si ocurre un error, mostrar el mensaje de error con SweetAlert2
                        Swal.fire({
                            icon: 'error',
                            title: 'Error al crear al candidato',
                            text: 'Hubo un error al crear al candidato: ' + data.message,
                            confirmButtonText: 'Aceptar'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error al enviar el formulario:', error);
                    // Mostrar un error con SweetAlert2 en caso de que algo falle en la petición
                    Swal.fire({
                        icon: 'error',
                        title: 'Hubo un error al enviar el formulario',
                        text: 'Inténtalo nuevamente más tarde.',
                        confirmButtonText: 'Aceptar'
                    });
                });
        });


        const nextButtonNombre = document.getElementById('next-step-nombre');
        if (nextButtonNombre) {
            nextButtonNombre.addEventListener('click', () => {
                saveDataAndContinue('identificacion', 'detalles-personales');
            });
        }

        document.getElementById('NoAplica').addEventListener('click', function () {
            const lastname2Input = document.getElementById('candidate-lastname-2');
            lastname2Input.value = 'N/A';
        });

    });

    function goToForm(formId) {
        try {
            if (!window.bsStepper) return;
            const steps = Array.from(document.querySelectorAll('#wizard-registro-candidato .step'));
            const idx = steps.findIndex(s => s.dataset.target === '#' + formId);
            if (idx !== -1) window.bsStepper.to(idx + 1);
        } catch (err) {
            console.error('Stepper navigation error:', err);
        }
    }

    function saveDataAndContinue(cur, next) {
        let ok = true;
        if (cur === 'identificacion') {
            const fn = document.getElementById('candidate-firstName').value.trim();
            const ln1 = document.getElementById('candidate-lastname-1').value.trim();
            const ln2 = document.getElementById('candidate-lastname-2').value.trim();

            document.getElementById('firstname-error').innerText = '';
            document.getElementById('lastname-error').innerText = '';

            if (!fn) {
                document.getElementById('firstname-error').innerText = 'El nombre es obligatorio';
                ok = false;
            }
            if (!ln1) {
                document.getElementById('lastname-error').innerText = 'El primer apellido es obligatorio';
                ok = false;
            }

            formData.firstname = fn;

            if (ln2 && ln2 !== 'N/A') {
                formData.lastname = `${ln1} ${ln2}`;
            } else {
                formData.lastname = ln1;
            }
        }
        if (cur === 'detalles-personales') {
            const email = document.getElementById('user-email').value.trim();
            const genero = document.getElementById('candidate-genero-legal').value.trim();
            const nacimiento = document.getElementById('nacimiento-candidato').value.trim();

            document.getElementById('email-error').innerText = '';
            document.getElementById('genero-error').innerText = '';
            document.getElementById('nacimiento-error').innerText = '';

            if (!email) {
                document.getElementById('email-error').innerText = 'El correo electrónico es obligatorio';
                ok = false;
            }
            if (!genero || genero === 'Elija una opción') {
                document.getElementById('genero-error').innerText = 'El género es obligatorio';
                ok = false;
            }
            if (!nacimiento) {
                document.getElementById('nacimiento-error').innerText = 'La fecha de nacimiento es obligatoria';
                ok = false;
            }

            // Si todo es correcto, guarda los datos
            if (ok) {
                formData.email = email;
                formData.genero_legal = genero;
                formData.nacimiento = nacimiento;
            }
        }
        if (ok) {
            goToForm(next);
        }
    }

    function validateInfo() {
        let ok = true;

        const pais = document.getElementById('pais-candidato').value.trim();
        const postalcode = document.getElementById('candidate-postalcode').value.trim();
        const cellphone = document.getElementById('candidate-cellphone').value.trim();

        document.getElementById('pais-error').innerText = '';
        document.getElementById('postalcode-error').innerText = '';
        document.getElementById('cellphone-error').innerText = '';

        if (!pais || pais === 'Elija una opción') {
            document.getElementById('pais-error').innerText = 'El país es obligatorio';
            ok = false;
        }
        if (!postalcode) {
            document.getElementById('postalcode-error').innerText = 'El código postal es obligatorio';
            ok = false;
        }
        if (!cellphone) {
            document.getElementById('cellphone-error').innerText = 'El número de celular es obligatorio';
            ok = false;
        } else if (!/^\d{10}$/.test(cellphone)) {
            document.getElementById('cellphone-error').innerText = 'El número de celular debe tener 10 dígitos';
            ok = false;
        }

        if (ok) {
            formData.pais = pais;
            formData.codigo_postal = postalcode;
            formData.telefono = cellphone;
        }

        return ok;
    }

    window.goToForm = goToForm;
    window.saveDataAndContinue = saveDataAndContinue;
    window.validateInfo = validateInfo;

    window.abrirModalCandidato = function() {
    const modalElement = document.getElementById('modalCandidato');
    if (!modalElement) {
        console.error('Modal no encontrado');
        return;
    }
    const modal = new bootstrap.Modal(modalElement);
    modal.show();
    };
</script>