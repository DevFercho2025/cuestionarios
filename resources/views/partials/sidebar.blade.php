<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        
        <div style="display: flex; justify-content: center; padding: 10px;">
            <img
                src="{{ asset('assets/img/Alobri/alobri-light.png') }}"
                alt="Logo"
                height="30px"
                class="app-brand-img"
                data-app-light-img="Alobri/Alobri-light.png"
                data-app-dark-img="Alobri/Alobri-dark.png"
            />
        </div>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M8.47365 11.7183C8.11707 12.0749 8.11707 12.6531 8.47365 13.0097L12.071 16.607C12.4615 16.9975 12.4615 17.6305 12.071 18.021C11.6805 18.4115 11.0475 18.4115 10.657 18.021L5.83009 13.1941C5.37164 12.7356 5.37164 11.9924 5.83009 11.5339L10.657 6.707C11.0475 6.31653 11.6805 6.31653 12.071 6.707C12.4615 7.09747 12.4615 7.73053 12.071 8.121L8.47365 11.7183Z"
                    fill-opacity="0.9" />
                <path
                    d="M14.3584 11.8336C14.0654 12.1266 14.0654 12.6014 14.3584 12.8944L18.071 16.607C18.4615 16.9975 18.4615 17.6305 18.071 18.021C17.6805 18.4115 17.0475 18.4115 16.657 18.021L11.6819 13.0459C11.3053 12.6693 11.3053 12.0587 11.6819 11.6821L16.657 6.707C17.0475 6.31653 17.6805 6.31653 18.071 6.707C18.4615 7.09747 18.4615 7.73053 18.071 8.121L14.3584 11.8336Z"
                    fill-opacity="0.4" />
            </svg>
        </a>
    </div>
    
    <div class="menu-inner-shadow"></div>

<style>
    .menu-vertical .menu-item button.menu-link:hover {
        background-color:  rgba(38, 43, 67, 0.08) !important;
    }
    .button.menu-link{
        display: block; /* Hace que el elemento ocupe todo el ancho disponible */
    width: 100%;
    }
</style>
    <ul class="menu-inner py-1">
        <!-- Dashboards -->
        @if((auth()->user()->config?->role?->type === 'Admin') || (auth()->user()->config?->role?->type === 'Super Admin'))
            <li class="menu-item">
                <a href="{{ route('admin.index') }}" class="menu-link">
                    <div data-i18n="Inicio">Inicio</div>
                </a>
            </li>
            <li class="menu-item active open">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ri-user-line"></i>
                    <div data-i18n="Candidatos">Candidatos</div>
                </a>
                <ul class="menu-sub">
                    <!-- Candidato con vacante -->
                    <li class="menu-item">
                        <a href="#" class="menu-link" onclick="event.preventDefault(); document.getElementById('form-con-vacante').submit();">
                            <div data-i18n="Candidatos con vacante">Candidato con vacante</div>
                        </a>
                        <form id="form-con-vacante" action="{{ route('candidatos.index') }}" method="POST" style="display: none;">
                            @csrf
                            <input type="hidden" name="conVacante" value="1">
                        </form>
                    </li>

                    <!-- Candidato sin vacante -->
                    <li class="menu-item">
                        <a href="#" class="menu-link" onclick="event.preventDefault(); document.getElementById('form-sin-vacante').submit();">
                            <div data-i18n="Candidatos sin vacante">Candidato sin vacante</div>
                        </a>
                        <form id="form-sin-vacante" action="{{ route('candidatos.index') }}" method="POST" style="display: none;">
                            @csrf
                            <input type="hidden" name="conVacante" value="0">
                        </form>
                    </li>
                    
                    <li class="menu-item">
                        <a href="{{ route('evaluaciones.index') }}" class="menu-link">
                            <div data-i18n="Códigos de acceso">Códigos de acceso</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('resultados.index') }}" class="menu-link">
                            <div data-i18n="Estatus de las evaluaciones">Ver resultados</div>
                        </a>
                    </li>
                </ul>
            </li>
            @if(auth()->user()->config?->role?->type === 'Super Admin')
                <li class="menu-item active open">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ri-survey-line"></i>
                        <div data-i18n="Evaluaciones">Evaluaciones</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item">
                            <a href="{{ route('categoriasTipos.index') }}" class="menu-link">
                                <div data-i18n="Categorías y tipos"></div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('pruebas.index') }}" class="menu-link">
                                <div data-i18n="Pruebas"></div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('secciones.index') }}" class="menu-link">
                                <div data-i18n="Secciones"></div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-item active open">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ri-questionnaire-line me-2"></i> 
                        <div data-i18n="Preguntas"></div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item">
                            <a href="{{ route('preguntas.index') }}" class="menu-link">
                                <div data-i18n="Preguntas que existen"></div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('respuestas.index') }}" class="menu-link">
                                <div data-i18n="Respuestas que existen"></div>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
        @endif
    </ul>


<!--
    <ul class="menu-inner py-1">
        Dashboards
        <li class="menu-item active open">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ri-home-smile-line"></i>
                <div data-i18n="Usuarios">Usuarios</div>
            </a>
            <ul class="menu-sub">
                @if(auth()->user()->config?->role?->type === 'Admin')
                <li class="menu-item">
                    <a href="{//{route ('candidate.resultados')}}" class="menu-link">
                        <div data-i18n="Resultados">Resultados</div>
                    </a>
                </li>
                @endif

                
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Roles">Roles</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Usuarios">Usuarios</div>
                    </a>
                </li>
                @if(auth()->user()->config?->role?->type === 'Candidate')
                <li class="menu-item">
                    <a href="{//{route ('candidate.dashboard')}}" class="menu-link">
                        <div data-i18n="Evaluaciones">Evaluaciones</div>
                    </a>
                </li>
                @endif
            </ul>
        </li>

    </ul>
-->
</aside>
<!-- / Menu -->
