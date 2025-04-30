@extends('layout.admin')
@section('content')

    <!-- Encabezado del Dashboard -->
    <!--<div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="d-flex align-items-center row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Bienvenido al Panel de Administración 🚀 </h5>
                            <p class="mb-4">Eres de: {{ auth()->user()->company?->name ?? 'Sin compañía asignada' }}</p>
                            <p class="mb-4">Gestione las diferentes secciones del sistema desde aquí.</p>

                            <a href="javascript:;" class="btn btn-sm btn-primary">Ver Estadísticas</a>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-right">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img
                                src="{{ asset('/assets/img/illustrations/sitting-girl-with-laptop-light.png') }}"
                                height="140"
                                alt="View Badge User"
                                data-app-dark-img="illustrations/sitting-girl-with-laptop-dark.png"
                                data-app-light-img="illustrations/sitting-girl-with-laptop-light.png"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>-->

    <!-- Tarjetas de Módulos -->
    <!--<div class="row">
        Secciones 
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="fw-medium d-block mb-1">Secciones</span>
                            <div class="d-flex align-items-center my-2">
                                <h4 class="mb-0 me-2">Gestión de Secciones</h4>
                            </div>
                            <p class="mb-0">Administre y organice las secciones del sistema</p>
                        </div>
                        <div class="avatar">
                        <span class="avatar-initial rounded bg-label-primary">
                            <i class="ri-dashboard-line fs-4"></i>
                        </span>
                        </div>
                    </div>
                    <div class="d-grid mt-3">
                        <a href="{{ route('secciones.index') }}" class="btn btn-primary waves-effect waves-light">
                            <i class="ri-arrow-right-line me-1"></i> Gestionar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        Preguntas 
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="fw-medium d-block mb-1">Preguntas</span>
                            <div class="d-flex align-items-center my-2">
                                <h4 class="mb-0 me-2">Banco de Preguntas</h4>
                            </div>
                            <p class="mb-0">Cree y administre las preguntas de las evaluaciones</p>
                        </div>
                        <div class="avatar">
                        <span class="avatar-initial rounded bg-label-info">
                            <i class="ri-question-line fs-4"></i>
                        </span>
                        </div>
                    </div>
                    <div class="d-grid mt-3">
                        <a href="{{ route('preguntas.index') }}" class="btn btn-info waves-effect waves-light">
                            <i class="ri-arrow-right-line me-1"></i> Gestionar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        Respuestas 
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="fw-medium d-block mb-1">Respuestas</span>
                            <div class="d-flex align-items-center my-2">
                                <h4 class="mb-0 me-2">Opciones de Respuesta</h4>
                            </div>
                            <p class="mb-0">Configure las opciones de respuesta para cada pregunta</p>
                        </div>
                        <div class="avatar">
                        <span class="avatar-initial rounded bg-label-success">
                            <i class="ri-message-3-line fs-4"></i>
                        </span>
                        </div>
                    </div>
                    <div class="d-grid mt-3">
                        <a href="{{ route('respuestas.index') }}" class="btn btn-success waves-effect waves-light">
                            <i class="ri-arrow-right-line me-1"></i> Gestionar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        Respuestas Correctas 
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="fw-medium d-block mb-1">Respuestas Correctas</span>
                            <div class="d-flex align-items-center my-2">
                                <h4 class="mb-0 me-2">Soluciones</h4>
                            </div>
                            <p class="mb-0">Defina las respuestas correctas para cada pregunta</p>
                        </div>
                        <div class="avatar">
                        <span class="avatar-initial rounded bg-label-warning">
                            <i class="ri-checkbox-circle-line fs-4"></i>
                        </span>
                        </div>
                    </div>
                    <div class="d-grid mt-3">
                        <a href="{{ route('respuestas_correctas.index') }}" class="btn btn-warning waves-effect waves-light">
                            <i class="ri-arrow-right-line me-1"></i> Gestionar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        Candidatos 
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="fw-medium d-block mb-1">Candidatos</span>
                            <div class="d-flex align-items-center my-2">
                                <h4 class="mb-0 me-2">Gestión de Participantes</h4>
                            </div>
                            <p class="mb-0">Administre la información de los candidatos evaluados</p>
                        </div>
                        <div class="avatar">
                        <span class="avatar-initial rounded bg-label-danger">
                            <i class="ri-user-line fs-4"></i>
                        </span>
                        </div>
                    </div>
                    <div class="d-grid mt-3">
                        <a href="{//{ route('candidatos.index') }}" class="btn btn-danger waves-effect waves-light">
                            <i class="ri-arrow-right-line me-1"></i> Gestionar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        Evaluaciones 
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="fw-medium d-block mb-1">Evaluaciones</span>
                            <div class="d-flex align-items-center my-2">
                                <h4 class="mb-0 me-2">Códigos de Evaluación</h4>
                            </div>
                            <p class="mb-0">Gestione los códigos de acceso a evaluaciones para candidatos</p>
                        </div>
                        <div class="avatar">
                        <span class="avatar-initial rounded bg-label-secondary">
                            <i class="ri-file-chart-line fs-4"></i>
                        </span>
                        </div>
                    </div>
                    <div class="d-grid mt-3">
                        <a href="{{ route('evaluaciones.index') }}" class="btn btn-secondary waves-effect waves-light">
                            <i class="ri-arrow-right-line me-1"></i> Gestionar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>-->

    <div class="card mb-4">
        <div class="d-flex align-items-end row">
          <div class="col-md-6 order-2 order-md-1">
            <div class="card-body">
              <h4 class="card-title mb-4">Bienvenido <span class="fw-bold">{{ auth()->user()->name }}</span></h4>
              <p class="card-title text-primary">Este es su panel de administración para {{ auth()->user()->company?->name ?? 'Sin compañía asignada' }}</p>
              <p class="mb-4">Gestione las diferentes secciones del sistema desde aquí.</p>
            </div>
          </div>
          <div class="col-md-6 text-center text-md-end order-1 order-md-2">
            <div class="card-body pb-0 px-0 pt-2">
              <img src="../../assets/img/illustrations/illustration-john-dark.png" height="186" class="scaleX-n1-rtl" alt="View Profile" data-app-light-img="illustrations/illustration-john-light.png" data-app-dark-img="illustrations/illustration-john-dark.png">
            </div>
          </div>
        </div>
      </div>
      <div class="row g-6">
        <div class="col-md-6 col-xxl-4">
            <div class="card h-100">
              <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">Estadísticas de Vacantes</h5>
                <div class="dropdown">
                  <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-1 waves-effect waves-light" type="button" id="projectStatus" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="ri-more-2-line ri-20px"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="projectStatus">
                    <a class="dropdown-item waves-effect" href="javascript:void(0);">Entry level</a>
                    <a class="dropdown-item waves-effect" href="javascript:void(0);">Senior level</a>
                    <a class="dropdown-item waves-effect" href="javascript:void(0);">Ejecutivo</a>
                  </div>
                </div>
              </div>
              <div class="d-flex justify-content-between p-4 border-bottom">
                <p class="mb-0 fs-xsmall">Vacante</p>
                <p class="mb-0 fs-xsmall">Cantidad de Postulados</p>
              </div>
              <div class="card-body">
                <ul class="p-0 m-0">
                  <li class="d-flex align-items-center mb-6">
                    <div class="avatar avatar-md flex-shrink-0 me-4">
                      <div class="avatar-initial bg-light-gray rounded-3">
                        <div>
                          <img src="../../assets/img/icons/misc/3d-illustration.png" alt="User" class="h-25">
                        </div>
                      </div>
                    </div>
                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                      <div class="me-2">
                        <h6 class="mb-1">Especialista en CiberSeguridad</h6>
                        <small>Para área de IT</small>
                      </div>
                      <div class="badge bg-label-primary rounded-pill">30</div>
                    </div>
                  </li>
                  <li class="d-flex align-items-center mb-6">
                    <div class="avatar avatar-md flex-shrink-0 me-4">
                      <div class="avatar-initial bg-light-gray rounded-3">
                        <div>
                          <img src="../../assets/img/icons/misc/finance-app-design.png" alt="User" class="h-25">
                        </div>
                      </div>
                    </div>
                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                      <div class="me-2">
                        <h6 class="mb-1">Diseñador UI/UX</h6>
                        <small>Para área de Tecnología</small>
                      </div>
                      <div class="badge bg-label-primary rounded-pill">20</div>
                    </div>
                  </li>
                  <li class="d-flex align-items-center mb-6">
                    <div class="avatar avatar-md flex-shrink-0 me-4">
                      <div class="avatar-initial bg-light-gray rounded-3">
                        <div>
                          <img src="../../assets/img/icons/misc/4-square.png" alt="User" class="h-25">
                        </div>
                      </div>
                    </div>
                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                      <div class="me-2">
                        <h6 class="mb-1">Analista Contable</h6>
                        <small>Para área de Administración y Finanzasn</small>
                      </div>
                      <div class="badge bg-label-primary rounded-pill">10</div>
                    </div>
                  </li>
                  <li class="d-flex align-items-center mb-6">
                    <div class="avatar avatar-md flex-shrink-0 me-4">
                      <div class="avatar-initial bg-light-gray rounded-3">
                        <div>
                          <img src="../../assets/img/icons/misc/delta-web-app.png" alt="User" class="h-25">
                        </div>
                      </div>
                    </div>
                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                      <div class="me-2">
                        <h6 class="mb-1">Enfermero</h6>
                        <small>Para área de Urgencias</small>
                      </div>
                      <div class="badge bg-label-primary rounded-pill">40</div>
                    </div>
                  </li>
                  <li class="d-flex align-items-center">
                    <div class="avatar avatar-md flex-shrink-0 me-4">
                      <div class="avatar-initial bg-light-gray rounded-3">
                        <div>
                          <img src="../../assets/img/icons/misc/ecommerce-website.png" alt="User" class="h-25">
                        </div>
                      </div>
                    </div>
                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                      <div class="me-2">
                        <h6 class="mb-1">Técnico en equipos biométicos</h6>
                        <small>Para área de Manteminiento biomédico</small>
                      </div>
                      <div class="badge bg-label-primary rounded-pill">5</div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>

          <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row g-6">
              

              <!-- Total Transactions & Report Chart -->
              <div class="col-12 col-xxl-8">
                <div class="card h-100">
                  <div class="row row-bordered g-0 h-100">
                    <div class="col-md-7 col-12 order-2 order-md-0">
                      <div class="card-header">
                        <h5 class="mb-0">Total Transactions</h5>
                      </div>
                      <div class="card-body" style="position: relative;">
                        <div id="totalTransactionChart" style="min-height: 218px;"><div id="apexcharts0x2uu9xq" class="apexcharts-canvas apexcharts0x2uu9xq apexcharts-theme-light" style="width: 495px; height: 218px;"><svg id="SvgjsSvg1584" width="495" height="218" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG1586" class="apexcharts-inner apexcharts-graphical" transform="translate(27, 38.27)"><defs id="SvgjsDefs1585"><linearGradient id="SvgjsLinearGradient1589" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop1590" stop-opacity="0.4" stop-color="rgba(216,227,240,0.4)" offset="0"></stop><stop id="SvgjsStop1591" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop><stop id="SvgjsStop1592" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop></linearGradient><clipPath id="gridRectMask0x2uu9xq"><rect id="SvgjsRect1594" width="450.1484375" height="178.73" x="-2" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="forecastMask0x2uu9xq"></clipPath><clipPath id="nonForecastMask0x2uu9xq"></clipPath><clipPath id="gridRectMarkerMask0x2uu9xq"><rect id="SvgjsRect1595" width="450.1484375" height="182.73" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><rect id="SvgjsRect1593" width="0" height="178.73" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke-dasharray="3" fill="url(#SvgjsLinearGradient1589)" class="apexcharts-xcrosshairs" y2="178.73" filter="none" fill-opacity="0.9"></rect><g id="SvgjsG1638" class="apexcharts-yaxis apexcharts-xaxis-inversed" rel="0"><g id="SvgjsG1639" class="apexcharts-yaxis-texts-g apexcharts-xaxis-inversed-texts-g" transform="translate(0, 0)"></g></g><g id="SvgjsG1615" class="apexcharts-xaxis apexcharts-yaxis-inversed"><g id="SvgjsG1616" class="apexcharts-xaxis-texts-g" transform="translate(0, -8.666666666666666)"><text id="SvgjsText1617" font-family="Helvetica, Arial, sans-serif" x="446.1484375" y="-8.270000000000003" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#7b7d95" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1619">300</tspan><title>300</title></text><text id="SvgjsText1620" font-family="Helvetica, Arial, sans-serif" x="371.69036458333335" y="-8.270000000000003" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#7b7d95" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1622">200</tspan><title>200</title></text><text id="SvgjsText1623" font-family="Helvetica, Arial, sans-serif" x="297.23229166666664" y="-8.270000000000003" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#7b7d95" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1625">100</tspan><title>100</title></text><text id="SvgjsText1626" font-family="Helvetica, Arial, sans-serif" x="222.77421875" y="-8.270000000000003" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#7b7d95" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1628">0</tspan><title>0</title></text><text id="SvgjsText1629" font-family="Helvetica, Arial, sans-serif" x="148.31614583333334" y="-8.270000000000003" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#7b7d95" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1631">100</tspan><title>100</title></text><text id="SvgjsText1632" font-family="Helvetica, Arial, sans-serif" x="73.85807291666669" y="-8.270000000000003" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#7b7d95" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1634">200</tspan><title>200</title></text><text id="SvgjsText1635" font-family="Helvetica, Arial, sans-serif" x="-0.6000000000000227" y="-8.270000000000003" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#7b7d95" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1637">300</tspan><title>300</title></text></g></g><g id="SvgjsG1640" class="apexcharts-grid"><g id="SvgjsG1641" class="apexcharts-gridlines-horizontal"></g><g id="SvgjsG1642" class="apexcharts-gridlines-vertical"><line id="SvgjsLine1643" x1="0" y1="0" x2="0" y2="178.73" stroke="#464964" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1644" x1="74.65807291666667" y1="0" x2="74.65807291666667" y2="178.73" stroke="#464964" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1645" x1="149.31614583333334" y1="0" x2="149.31614583333334" y2="178.73" stroke="#464964" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1646" x1="223.97421875000003" y1="0" x2="223.97421875000003" y2="178.73" stroke="#464964" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1647" x1="298.63229166666673" y1="0" x2="298.63229166666673" y2="178.73" stroke="#464964" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1648" x1="373.2903645833334" y1="0" x2="373.2903645833334" y2="178.73" stroke="#464964" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1649" x1="447.9484375000001" y1="0" x2="447.9484375000001" y2="178.73" stroke="#464964" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line></g><line id="SvgjsLine1651" x1="0" y1="178.73" x2="446.1484375" y2="178.73" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line><line id="SvgjsLine1650" x1="0" y1="1" x2="0" y2="178.73" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line></g><g id="SvgjsG1596" class="apexcharts-bar-series apexcharts-plot-series"><g id="SvgjsG1597" class="apexcharts-series" seriesName="LastxWeek" rel="1" data:realIndex="0"><path id="SvgjsPath1599" d="M 223.07421875000003 8.9365L 279.7914192708334 8.9365Q 284.7914192708334 8.9365 284.7914192708334 13.9365L 284.7914192708334 11.596357142857144Q 284.7914192708334 16.596357142857144 279.7914192708334 16.596357142857144L 279.7914192708334 16.596357142857144L 223.07421875000003 16.596357142857144L 223.07421875000003 16.596357142857144Q 223.07421875000003 16.596357142857144 223.07421875000003 16.596357142857144L 223.07421875000003 8.9365Q 223.07421875000003 8.9365 223.07421875000003 8.9365z" fill="rgba(102,108,255,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0x2uu9xq)" pathTo="M 223.07421875000003 8.9365L 279.7914192708334 8.9365Q 284.7914192708334 8.9365 284.7914192708334 13.9365L 284.7914192708334 11.596357142857144Q 284.7914192708334 16.596357142857144 279.7914192708334 16.596357142857144L 279.7914192708334 16.596357142857144L 223.07421875000003 16.596357142857144L 223.07421875000003 16.596357142857144Q 223.07421875000003 16.596357142857144 223.07421875000003 16.596357142857144L 223.07421875000003 8.9365Q 223.07421875000003 8.9365 223.07421875000003 8.9365z" pathFrom="M 223.07421875000003 8.9365L 223.07421875000003 8.9365L 223.07421875000003 16.596357142857144L 223.07421875000003 16.596357142857144L 223.07421875000003 16.596357142857144L 223.07421875000003 16.596357142857144L 223.07421875000003 16.596357142857144L 223.07421875000003 8.9365" cy="34.46935714285714" cx="284.7914192708334" j="0" val="83" barHeight="7.659857142857143" barWidth="61.71720052083334"></path><path id="SvgjsPath1600" d="M 223.07421875000003 34.46935714285714L 331.8420703125 34.46935714285714Q 336.8420703125 34.46935714285714 336.8420703125 39.46935714285714L 336.8420703125 37.12921428571428Q 336.8420703125 42.12921428571428 331.8420703125 42.12921428571428L 331.8420703125 42.12921428571428L 223.07421875000003 42.12921428571428L 223.07421875000003 42.12921428571428Q 223.07421875000003 42.12921428571428 223.07421875000003 42.12921428571428L 223.07421875000003 34.46935714285714Q 223.07421875000003 34.46935714285714 223.07421875000003 34.46935714285714z" fill="rgba(102,108,255,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0x2uu9xq)" pathTo="M 223.07421875000003 34.46935714285714L 331.8420703125 34.46935714285714Q 336.8420703125 34.46935714285714 336.8420703125 39.46935714285714L 336.8420703125 37.12921428571428Q 336.8420703125 42.12921428571428 331.8420703125 42.12921428571428L 331.8420703125 42.12921428571428L 223.07421875000003 42.12921428571428L 223.07421875000003 42.12921428571428Q 223.07421875000003 42.12921428571428 223.07421875000003 42.12921428571428L 223.07421875000003 34.46935714285714Q 223.07421875000003 34.46935714285714 223.07421875000003 34.46935714285714z" pathFrom="M 223.07421875000003 34.46935714285714L 223.07421875000003 34.46935714285714L 223.07421875000003 42.12921428571428L 223.07421875000003 42.12921428571428L 223.07421875000003 42.12921428571428L 223.07421875000003 42.12921428571428L 223.07421875000003 42.12921428571428L 223.07421875000003 34.46935714285714" cy="60.00221428571429" cx="336.8420703125" j="1" val="153" barHeight="7.659857142857143" barWidth="113.76785156250001"></path><path id="SvgjsPath1601" d="M 223.07421875000003 60.00221428571429L 376.4569140625 60.00221428571429Q 381.4569140625 60.00221428571429 381.4569140625 65.00221428571429L 381.4569140625 62.66207142857144Q 381.4569140625 67.66207142857144 376.4569140625 67.66207142857144L 376.4569140625 67.66207142857144L 223.07421875000003 67.66207142857144L 223.07421875000003 67.66207142857144Q 223.07421875000003 67.66207142857144 223.07421875000003 67.66207142857144L 223.07421875000003 60.00221428571429Q 223.07421875000003 60.00221428571429 223.07421875000003 60.00221428571429z" fill="rgba(102,108,255,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0x2uu9xq)" pathTo="M 223.07421875000003 60.00221428571429L 376.4569140625 60.00221428571429Q 381.4569140625 60.00221428571429 381.4569140625 65.00221428571429L 381.4569140625 62.66207142857144Q 381.4569140625 67.66207142857144 376.4569140625 67.66207142857144L 376.4569140625 67.66207142857144L 223.07421875000003 67.66207142857144L 223.07421875000003 67.66207142857144Q 223.07421875000003 67.66207142857144 223.07421875000003 67.66207142857144L 223.07421875000003 60.00221428571429Q 223.07421875000003 60.00221428571429 223.07421875000003 60.00221428571429z" pathFrom="M 223.07421875000003 60.00221428571429L 223.07421875000003 60.00221428571429L 223.07421875000003 67.66207142857144L 223.07421875000003 67.66207142857144L 223.07421875000003 67.66207142857144L 223.07421875000003 67.66207142857144L 223.07421875000003 67.66207142857144L 223.07421875000003 60.00221428571429" cy="85.53507142857143" cx="381.4569140625" j="2" val="213" barHeight="7.659857142857143" barWidth="158.3826953125"></path><path id="SvgjsPath1602" d="M 223.07421875000003 85.53507142857143L 425.53324218750004 85.53507142857143Q 430.53324218750004 85.53507142857143 430.53324218750004 90.53507142857143L 430.53324218750004 88.19492857142858Q 430.53324218750004 93.19492857142858 425.53324218750004 93.19492857142858L 425.53324218750004 93.19492857142858L 223.07421875000003 93.19492857142858L 223.07421875000003 93.19492857142858Q 223.07421875000003 93.19492857142858 223.07421875000003 93.19492857142858L 223.07421875000003 85.53507142857143Q 223.07421875000003 85.53507142857143 223.07421875000003 85.53507142857143z" fill="rgba(102,108,255,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0x2uu9xq)" pathTo="M 223.07421875000003 85.53507142857143L 425.53324218750004 85.53507142857143Q 430.53324218750004 85.53507142857143 430.53324218750004 90.53507142857143L 430.53324218750004 88.19492857142858Q 430.53324218750004 93.19492857142858 425.53324218750004 93.19492857142858L 425.53324218750004 93.19492857142858L 223.07421875000003 93.19492857142858L 223.07421875000003 93.19492857142858Q 223.07421875000003 93.19492857142858 223.07421875000003 93.19492857142858L 223.07421875000003 85.53507142857143Q 223.07421875000003 85.53507142857143 223.07421875000003 85.53507142857143z" pathFrom="M 223.07421875000003 85.53507142857143L 223.07421875000003 85.53507142857143L 223.07421875000003 93.19492857142858L 223.07421875000003 93.19492857142858L 223.07421875000003 93.19492857142858L 223.07421875000003 93.19492857142858L 223.07421875000003 93.19492857142858L 223.07421875000003 85.53507142857143" cy="111.06792857142857" cx="430.53324218750004" j="3" val="279" barHeight="7.659857142857143" barWidth="207.4590234375"></path><path id="SvgjsPath1603" d="M 223.07421875000003 111.06792857142857L 376.4569140625 111.06792857142857Q 381.4569140625 111.06792857142857 381.4569140625 116.06792857142857L 381.4569140625 113.72778571428572Q 381.4569140625 118.72778571428572 376.4569140625 118.72778571428572L 376.4569140625 118.72778571428572L 223.07421875000003 118.72778571428572L 223.07421875000003 118.72778571428572Q 223.07421875000003 118.72778571428572 223.07421875000003 118.72778571428572L 223.07421875000003 111.06792857142857Q 223.07421875000003 111.06792857142857 223.07421875000003 111.06792857142857z" fill="rgba(102,108,255,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0x2uu9xq)" pathTo="M 223.07421875000003 111.06792857142857L 376.4569140625 111.06792857142857Q 381.4569140625 111.06792857142857 381.4569140625 116.06792857142857L 381.4569140625 113.72778571428572Q 381.4569140625 118.72778571428572 376.4569140625 118.72778571428572L 376.4569140625 118.72778571428572L 223.07421875000003 118.72778571428572L 223.07421875000003 118.72778571428572Q 223.07421875000003 118.72778571428572 223.07421875000003 118.72778571428572L 223.07421875000003 111.06792857142857Q 223.07421875000003 111.06792857142857 223.07421875000003 111.06792857142857z" pathFrom="M 223.07421875000003 111.06792857142857L 223.07421875000003 111.06792857142857L 223.07421875000003 118.72778571428572L 223.07421875000003 118.72778571428572L 223.07421875000003 118.72778571428572L 223.07421875000003 118.72778571428572L 223.07421875000003 118.72778571428572L 223.07421875000003 111.06792857142857" cy="136.6007857142857" cx="381.4569140625" j="4" val="213" barHeight="7.659857142857143" barWidth="158.3826953125"></path><path id="SvgjsPath1604" d="M 223.07421875000003 136.6007857142857L 331.8420703125 136.6007857142857Q 336.8420703125 136.6007857142857 336.8420703125 141.6007857142857L 336.8420703125 139.26064285714284Q 336.8420703125 144.26064285714284 331.8420703125 144.26064285714284L 331.8420703125 144.26064285714284L 223.07421875000003 144.26064285714284L 223.07421875000003 144.26064285714284Q 223.07421875000003 144.26064285714284 223.07421875000003 144.26064285714284L 223.07421875000003 136.6007857142857Q 223.07421875000003 136.6007857142857 223.07421875000003 136.6007857142857z" fill="rgba(102,108,255,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0x2uu9xq)" pathTo="M 223.07421875000003 136.6007857142857L 331.8420703125 136.6007857142857Q 336.8420703125 136.6007857142857 336.8420703125 141.6007857142857L 336.8420703125 139.26064285714284Q 336.8420703125 144.26064285714284 331.8420703125 144.26064285714284L 331.8420703125 144.26064285714284L 223.07421875000003 144.26064285714284L 223.07421875000003 144.26064285714284Q 223.07421875000003 144.26064285714284 223.07421875000003 144.26064285714284L 223.07421875000003 136.6007857142857Q 223.07421875000003 136.6007857142857 223.07421875000003 136.6007857142857z" pathFrom="M 223.07421875000003 136.6007857142857L 223.07421875000003 136.6007857142857L 223.07421875000003 144.26064285714284L 223.07421875000003 144.26064285714284L 223.07421875000003 144.26064285714284L 223.07421875000003 144.26064285714284L 223.07421875000003 144.26064285714284L 223.07421875000003 136.6007857142857" cy="162.13364285714286" cx="336.8420703125" j="5" val="153" barHeight="7.659857142857143" barWidth="113.76785156250001"></path><path id="SvgjsPath1605" d="M 223.07421875000003 162.13364285714286L 279.7914192708334 162.13364285714286Q 284.7914192708334 162.13364285714286 284.7914192708334 167.13364285714286L 284.7914192708334 164.7935Q 284.7914192708334 169.7935 279.7914192708334 169.7935L 279.7914192708334 169.7935L 223.07421875000003 169.7935L 223.07421875000003 169.7935Q 223.07421875000003 169.7935 223.07421875000003 169.7935L 223.07421875000003 162.13364285714286Q 223.07421875000003 162.13364285714286 223.07421875000003 162.13364285714286z" fill="rgba(102,108,255,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0x2uu9xq)" pathTo="M 223.07421875000003 162.13364285714286L 279.7914192708334 162.13364285714286Q 284.7914192708334 162.13364285714286 284.7914192708334 167.13364285714286L 284.7914192708334 164.7935Q 284.7914192708334 169.7935 279.7914192708334 169.7935L 279.7914192708334 169.7935L 223.07421875000003 169.7935L 223.07421875000003 169.7935Q 223.07421875000003 169.7935 223.07421875000003 169.7935L 223.07421875000003 162.13364285714286Q 223.07421875000003 162.13364285714286 223.07421875000003 162.13364285714286z" pathFrom="M 223.07421875000003 162.13364285714286L 223.07421875000003 162.13364285714286L 223.07421875000003 169.7935L 223.07421875000003 169.7935L 223.07421875000003 169.7935L 223.07421875000003 169.7935L 223.07421875000003 169.7935L 223.07421875000003 162.13364285714286" cy="187.6665" cx="284.7914192708334" j="6" val="83" barHeight="7.659857142857143" barWidth="61.71720052083334"></path></g><g id="SvgjsG1606" class="apexcharts-series" seriesName="ThisxWeek" rel="2" data:realIndex="1"><path id="SvgjsPath1608" d="M 218.07421875000003 8.9365L 160.61343750000003 8.9365Q 155.61343750000003 8.9365 155.61343750000003 13.9365L 155.61343750000003 11.596357142857144Q 155.61343750000003 16.596357142857144 160.61343750000003 16.596357142857144L 160.61343750000003 16.596357142857144L 218.07421875000003 16.596357142857144L 218.07421875000003 16.596357142857144Q 218.07421875000003 16.596357142857144 218.07421875000003 16.596357142857144L 218.07421875000003 8.9365Q 218.07421875000003 8.9365 218.07421875000003 8.9365z" fill="rgba(114,225,40,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMask0x2uu9xq)" pathTo="M 218.07421875000003 8.9365L 160.61343750000003 8.9365Q 155.61343750000003 8.9365 155.61343750000003 13.9365L 155.61343750000003 11.596357142857144Q 155.61343750000003 16.596357142857144 160.61343750000003 16.596357142857144L 160.61343750000003 16.596357142857144L 218.07421875000003 16.596357142857144L 218.07421875000003 16.596357142857144Q 218.07421875000003 16.596357142857144 218.07421875000003 16.596357142857144L 218.07421875000003 8.9365Q 218.07421875000003 8.9365 218.07421875000003 8.9365z" pathFrom="M 218.07421875000003 8.9365L 218.07421875000003 8.9365L 218.07421875000003 16.596357142857144L 218.07421875000003 16.596357142857144L 218.07421875000003 16.596357142857144L 218.07421875000003 16.596357142857144L 218.07421875000003 16.596357142857144L 218.07421875000003 8.9365" cy="34.46935714285714" cx="160.61343750000003" j="0" val="-84" barHeight="7.659857142857143" barWidth="-62.460781250000004"></path><path id="SvgjsPath1609" d="M 218.07421875000003 34.46935714285714L 107.07562500000002 34.46935714285714Q 102.07562500000002 34.46935714285714 102.07562500000002 39.46935714285714L 102.07562500000002 37.12921428571428Q 102.07562500000002 42.12921428571428 107.07562500000002 42.12921428571428L 107.07562500000002 42.12921428571428L 218.07421875000003 42.12921428571428L 218.07421875000003 42.12921428571428Q 218.07421875000003 42.12921428571428 218.07421875000003 42.12921428571428L 218.07421875000003 34.46935714285714Q 218.07421875000003 34.46935714285714 218.07421875000003 34.46935714285714z" fill="rgba(114,225,40,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMask0x2uu9xq)" pathTo="M 218.07421875000003 34.46935714285714L 107.07562500000002 34.46935714285714Q 102.07562500000002 34.46935714285714 102.07562500000002 39.46935714285714L 102.07562500000002 37.12921428571428Q 102.07562500000002 42.12921428571428 107.07562500000002 42.12921428571428L 107.07562500000002 42.12921428571428L 218.07421875000003 42.12921428571428L 218.07421875000003 42.12921428571428Q 218.07421875000003 42.12921428571428 218.07421875000003 42.12921428571428L 218.07421875000003 34.46935714285714Q 218.07421875000003 34.46935714285714 218.07421875000003 34.46935714285714z" pathFrom="M 218.07421875000003 34.46935714285714L 218.07421875000003 34.46935714285714L 218.07421875000003 42.12921428571428L 218.07421875000003 42.12921428571428L 218.07421875000003 42.12921428571428L 218.07421875000003 42.12921428571428L 218.07421875000003 42.12921428571428L 218.07421875000003 34.46935714285714" cy="60.00221428571429" cx="107.07562500000002" j="1" val="-156" barHeight="7.659857142857143" barWidth="-115.99859375000001"></path><path id="SvgjsPath1610" d="M 218.07421875000003 60.00221428571429L 62.460781250000025 60.00221428571429Q 57.460781250000025 60.00221428571429 57.460781250000025 65.00221428571429L 57.460781250000025 62.66207142857144Q 57.460781250000025 67.66207142857144 62.460781250000025 67.66207142857144L 62.460781250000025 67.66207142857144L 218.07421875000003 67.66207142857144L 218.07421875000003 67.66207142857144Q 218.07421875000003 67.66207142857144 218.07421875000003 67.66207142857144L 218.07421875000003 60.00221428571429Q 218.07421875000003 60.00221428571429 218.07421875000003 60.00221428571429z" fill="rgba(114,225,40,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMask0x2uu9xq)" pathTo="M 218.07421875000003 60.00221428571429L 62.460781250000025 60.00221428571429Q 57.460781250000025 60.00221428571429 57.460781250000025 65.00221428571429L 57.460781250000025 62.66207142857144Q 57.460781250000025 67.66207142857144 62.460781250000025 67.66207142857144L 62.460781250000025 67.66207142857144L 218.07421875000003 67.66207142857144L 218.07421875000003 67.66207142857144Q 218.07421875000003 67.66207142857144 218.07421875000003 67.66207142857144L 218.07421875000003 60.00221428571429Q 218.07421875000003 60.00221428571429 218.07421875000003 60.00221428571429z" pathFrom="M 218.07421875000003 60.00221428571429L 218.07421875000003 60.00221428571429L 218.07421875000003 67.66207142857144L 218.07421875000003 67.66207142857144L 218.07421875000003 67.66207142857144L 218.07421875000003 67.66207142857144L 218.07421875000003 67.66207142857144L 218.07421875000003 60.00221428571429" cy="85.53507142857143" cx="62.460781250000025" j="2" val="-216" barHeight="7.659857142857143" barWidth="-160.6134375"></path><path id="SvgjsPath1611" d="M 218.07421875000003 85.53507142857143L 13.384453125000022 85.53507142857143Q 8.384453125000022 85.53507142857143 8.384453125000022 90.53507142857143L 8.384453125000022 88.19492857142858Q 8.384453125000022 93.19492857142858 13.384453125000022 93.19492857142858L 13.384453125000022 93.19492857142858L 218.07421875000003 93.19492857142858L 218.07421875000003 93.19492857142858Q 218.07421875000003 93.19492857142858 218.07421875000003 93.19492857142858L 218.07421875000003 85.53507142857143Q 218.07421875000003 85.53507142857143 218.07421875000003 85.53507142857143z" fill="rgba(114,225,40,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMask0x2uu9xq)" pathTo="M 218.07421875000003 85.53507142857143L 13.384453125000022 85.53507142857143Q 8.384453125000022 85.53507142857143 8.384453125000022 90.53507142857143L 8.384453125000022 88.19492857142858Q 8.384453125000022 93.19492857142858 13.384453125000022 93.19492857142858L 13.384453125000022 93.19492857142858L 218.07421875000003 93.19492857142858L 218.07421875000003 93.19492857142858Q 218.07421875000003 93.19492857142858 218.07421875000003 93.19492857142858L 218.07421875000003 85.53507142857143Q 218.07421875000003 85.53507142857143 218.07421875000003 85.53507142857143z" pathFrom="M 218.07421875000003 85.53507142857143L 218.07421875000003 85.53507142857143L 218.07421875000003 93.19492857142858L 218.07421875000003 93.19492857142858L 218.07421875000003 93.19492857142858L 218.07421875000003 93.19492857142858L 218.07421875000003 93.19492857142858L 218.07421875000003 85.53507142857143" cy="111.06792857142857" cx="13.384453125000022" j="3" val="-282" barHeight="7.659857142857143" barWidth="-209.689765625"></path><path id="SvgjsPath1612" d="M 218.07421875000003 111.06792857142857L 62.460781250000025 111.06792857142857Q 57.460781250000025 111.06792857142857 57.460781250000025 116.06792857142857L 57.460781250000025 113.72778571428572Q 57.460781250000025 118.72778571428572 62.460781250000025 118.72778571428572L 62.460781250000025 118.72778571428572L 218.07421875000003 118.72778571428572L 218.07421875000003 118.72778571428572Q 218.07421875000003 118.72778571428572 218.07421875000003 118.72778571428572L 218.07421875000003 111.06792857142857Q 218.07421875000003 111.06792857142857 218.07421875000003 111.06792857142857z" fill="rgba(114,225,40,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMask0x2uu9xq)" pathTo="M 218.07421875000003 111.06792857142857L 62.460781250000025 111.06792857142857Q 57.460781250000025 111.06792857142857 57.460781250000025 116.06792857142857L 57.460781250000025 113.72778571428572Q 57.460781250000025 118.72778571428572 62.460781250000025 118.72778571428572L 62.460781250000025 118.72778571428572L 218.07421875000003 118.72778571428572L 218.07421875000003 118.72778571428572Q 218.07421875000003 118.72778571428572 218.07421875000003 118.72778571428572L 218.07421875000003 111.06792857142857Q 218.07421875000003 111.06792857142857 218.07421875000003 111.06792857142857z" pathFrom="M 218.07421875000003 111.06792857142857L 218.07421875000003 111.06792857142857L 218.07421875000003 118.72778571428572L 218.07421875000003 118.72778571428572L 218.07421875000003 118.72778571428572L 218.07421875000003 118.72778571428572L 218.07421875000003 118.72778571428572L 218.07421875000003 111.06792857142857" cy="136.6007857142857" cx="62.460781250000025" j="4" val="-216" barHeight="7.659857142857143" barWidth="-160.6134375"></path><path id="SvgjsPath1613" d="M 218.07421875000003 136.6007857142857L 107.07562500000002 136.6007857142857Q 102.07562500000002 136.6007857142857 102.07562500000002 141.6007857142857L 102.07562500000002 139.26064285714284Q 102.07562500000002 144.26064285714284 107.07562500000002 144.26064285714284L 107.07562500000002 144.26064285714284L 218.07421875000003 144.26064285714284L 218.07421875000003 144.26064285714284Q 218.07421875000003 144.26064285714284 218.07421875000003 144.26064285714284L 218.07421875000003 136.6007857142857Q 218.07421875000003 136.6007857142857 218.07421875000003 136.6007857142857z" fill="rgba(114,225,40,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMask0x2uu9xq)" pathTo="M 218.07421875000003 136.6007857142857L 107.07562500000002 136.6007857142857Q 102.07562500000002 136.6007857142857 102.07562500000002 141.6007857142857L 102.07562500000002 139.26064285714284Q 102.07562500000002 144.26064285714284 107.07562500000002 144.26064285714284L 107.07562500000002 144.26064285714284L 218.07421875000003 144.26064285714284L 218.07421875000003 144.26064285714284Q 218.07421875000003 144.26064285714284 218.07421875000003 144.26064285714284L 218.07421875000003 136.6007857142857Q 218.07421875000003 136.6007857142857 218.07421875000003 136.6007857142857z" pathFrom="M 218.07421875000003 136.6007857142857L 218.07421875000003 136.6007857142857L 218.07421875000003 144.26064285714284L 218.07421875000003 144.26064285714284L 218.07421875000003 144.26064285714284L 218.07421875000003 144.26064285714284L 218.07421875000003 144.26064285714284L 218.07421875000003 136.6007857142857" cy="162.13364285714286" cx="107.07562500000002" j="5" val="-156" barHeight="7.659857142857143" barWidth="-115.99859375000001"></path><path id="SvgjsPath1614" d="M 218.07421875000003 162.13364285714286L 160.61343750000003 162.13364285714286Q 155.61343750000003 162.13364285714286 155.61343750000003 167.13364285714286L 155.61343750000003 164.7935Q 155.61343750000003 169.7935 160.61343750000003 169.7935L 160.61343750000003 169.7935L 218.07421875000003 169.7935L 218.07421875000003 169.7935Q 218.07421875000003 169.7935 218.07421875000003 169.7935L 218.07421875000003 162.13364285714286Q 218.07421875000003 162.13364285714286 218.07421875000003 162.13364285714286z" fill="rgba(114,225,40,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMask0x2uu9xq)" pathTo="M 218.07421875000003 162.13364285714286L 160.61343750000003 162.13364285714286Q 155.61343750000003 162.13364285714286 155.61343750000003 167.13364285714286L 155.61343750000003 164.7935Q 155.61343750000003 169.7935 160.61343750000003 169.7935L 160.61343750000003 169.7935L 218.07421875000003 169.7935L 218.07421875000003 169.7935Q 218.07421875000003 169.7935 218.07421875000003 169.7935L 218.07421875000003 162.13364285714286Q 218.07421875000003 162.13364285714286 218.07421875000003 162.13364285714286z" pathFrom="M 218.07421875000003 162.13364285714286L 218.07421875000003 162.13364285714286L 218.07421875000003 169.7935L 218.07421875000003 169.7935L 218.07421875000003 169.7935L 218.07421875000003 169.7935L 218.07421875000003 169.7935L 218.07421875000003 162.13364285714286" cy="187.6665" cx="160.61343750000003" j="6" val="-84" barHeight="7.659857142857143" barWidth="-62.460781250000004"></path></g><g id="SvgjsG1598" class="apexcharts-datalabels" data:realIndex="0"></g><g id="SvgjsG1607" class="apexcharts-datalabels" data:realIndex="1"></g></g><line id="SvgjsLine1652" x1="0" y1="0" x2="446.1484375" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1653" x1="0" y1="0" x2="446.1484375" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG1654" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG1655" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG1656" class="apexcharts-point-annotations"></g></g><g id="SvgjsG1587" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend" style="max-height: 109px;"></div><div class="apexcharts-tooltip apexcharts-theme-light"><div class="apexcharts-tooltip-title" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"></div><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(102, 108, 255);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div><div class="apexcharts-tooltip-series-group" style="order: 2;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(114, 225, 40);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light"><div class="apexcharts-yaxistooltip-text"></div></div></div></div>
                      <div class="resize-triggers"><div class="expand-trigger"><div style="width: 536px; height: 239px;"></div></div><div class="contract-trigger"></div></div></div>
                    </div>
                    <div class="col-md-5 col-12">
                      <div class="card-header">
                        <div class="d-flex justify-content-between">
                          <h5 class="mb-1">Report</h5>
                          <div class="dropdown">
                            <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-1 waves-effect waves-light" type="button" id="totalTransaction" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="ri-more-2-line ri-20px"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="totalTransaction">
                              <a class="dropdown-item waves-effect" href="javascript:void(0);">Refresh</a>
                              <a class="dropdown-item waves-effect" href="javascript:void(0);">Share</a>
                              <a class="dropdown-item waves-effect" href="javascript:void(0);">Update</a>
                            </div>
                          </div>
                        </div>
                        <p class="mb-0 card-subtitle">Last month transactions $234.40k</p>
                      </div>
                      <div class="card-body pt-6">
                        <div class="row">
                          <div class="col-6 border-end">
                            <div class="d-flex flex-column align-items-center">
                              <div class="avatar">
                                <div class="avatar-initial bg-label-success rounded-3">
                                  <div class="ri-pie-chart-2-line ri-24px"></div>
                                </div>
                              </div>
                              <p class="mt-3 mb-1">This Week</p>
                              <h6 class="mb-0">+82.45%</h6>
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="d-flex flex-column align-items-center">
                              <div class="avatar">
                                <div class="avatar-initial bg-label-primary rounded-3">
                                  <div class="ri-money-dollar-circle-line ri-24px"></div>
                                </div>
                              </div>
                              <p class="mt-3 mb-1">This Week</p>
                              <h6 class="mb-0">-24.86%</h6>
                            </div>
                          </div>
                        </div>
                        <hr class="my-5">
                        <div class="d-flex justify-content-around align-items-center flex-wrap gap-2">
                          <div>
                            <p class="mb-1">Performance</p>
                            <h6 class="mb-0">+94.15%</h6>
                          </div>
                          <div>
                            <button class="btn btn-primary waves-effect waves-light" type="button">view report</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!--/ Total Transactions & Report Chart -->

              <!-- Performance Chart -->
              <div class="col-12 col-xxl-4 col-md-6">
                <div class="card h-100">
                  <div class="card-header">
                    <div class="d-flex justify-content-between">
                      <h5 class="mb-1">Performance</h5>
                      <div class="dropdown">
                        <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-1 waves-effect waves-light" type="button" id="performanceDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="ri-more-2-line ri-20px"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="performanceDropdown">
                          <a class="dropdown-item waves-effect" href="javascript:void(0);">Last 28 Days</a>
                          <a class="dropdown-item waves-effect" href="javascript:void(0);">Last Month</a>
                          <a class="dropdown-item waves-effect" href="javascript:void(0);">Last Year</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card-body" style="position: relative;">
                    <div id="performanceChart" style="min-height: 302px;"><div id="apexchartsdqsex8qg" class="apexcharts-canvas apexchartsdqsex8qg apexcharts-theme-light" style="width: 407px; height: 287px;"><svg id="SvgjsSvg1659" width="407" height="287" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><foreignObject x="0" y="0" width="407" height="287"><div class="apexcharts-legend apexcharts-align-center apx-legend-position-bottom" xmlns="http://www.w3.org/1999/xhtml" style="inset: auto 0px 1px; position: absolute; max-height: 143.5px;"><div class="apexcharts-legend-series" rel="1" seriesname="Income" data:collapsed="false" style="margin: 2px 16px;"><span class="apexcharts-legend-marker" rel="1" data:collapsed="false" style="background: rgb(253, 181, 40) !important; color: rgb(253, 181, 40); height: 10px; width: 10px; left: -5px; top: 0px; border-width: 0px; border-color: rgb(255, 255, 255); border-radius: 12px;"></span><span class="apexcharts-legend-text" rel="1" i="0" data:default-text="Income" data:collapsed="false" style="color: rgb(178, 179, 202); font-size: 15px; font-weight: 400; font-family: Inter;">Income</span></div><div class="apexcharts-legend-series" rel="2" seriesname="NetxWorth" data:collapsed="false" style="margin: 2px 16px;"><span class="apexcharts-legend-marker" rel="2" data:collapsed="false" style="background: rgb(102, 108, 255) !important; color: rgb(102, 108, 255); height: 10px; width: 10px; left: -5px; top: 0px; border-width: 0px; border-color: rgb(255, 255, 255); border-radius: 12px;"></span><span class="apexcharts-legend-text" rel="2" i="1" data:default-text="Net%20Worth" data:collapsed="false" style="color: rgb(178, 179, 202); font-size: 15px; font-weight: 400; font-family: Inter;">Net Worth</span></div></div><style type="text/css">	
      
    .apexcharts-legend {	
      display: flex;	
      overflow: auto;	
      padding: 0 10px;	
    }	
    .apexcharts-legend.apx-legend-position-bottom, .apexcharts-legend.apx-legend-position-top {	
      flex-wrap: wrap	
    }	
    .apexcharts-legend.apx-legend-position-right, .apexcharts-legend.apx-legend-position-left {	
      flex-direction: column;	
      bottom: 0;	
    }	
    .apexcharts-legend.apx-legend-position-bottom.apexcharts-align-left, .apexcharts-legend.apx-legend-position-top.apexcharts-align-left, .apexcharts-legend.apx-legend-position-right, .apexcharts-legend.apx-legend-position-left {	
      justify-content: flex-start;	
    }	
    .apexcharts-legend.apx-legend-position-bottom.apexcharts-align-center, .apexcharts-legend.apx-legend-position-top.apexcharts-align-center {	
      justify-content: center;  	
    }	
    .apexcharts-legend.apx-legend-position-bottom.apexcharts-align-right, .apexcharts-legend.apx-legend-position-top.apexcharts-align-right {	
      justify-content: flex-end;	
    }	
    .apexcharts-legend-series {	
      cursor: pointer;	
      line-height: normal;	
    }	
    .apexcharts-legend.apx-legend-position-bottom .apexcharts-legend-series, .apexcharts-legend.apx-legend-position-top .apexcharts-legend-series{	
      display: flex;	
      align-items: center;	
    }	
    .apexcharts-legend-text {	
      position: relative;	
      font-size: 14px;	
    }	
    .apexcharts-legend-text *, .apexcharts-legend-marker * {	
      pointer-events: none;	
    }	
    .apexcharts-legend-marker {	
      position: relative;	
      display: inline-block;	
      cursor: pointer;	
      margin-right: 3px;	
      border-style: solid;
    }	
        
    .apexcharts-legend.apexcharts-align-right .apexcharts-legend-series, .apexcharts-legend.apexcharts-align-left .apexcharts-legend-series{	
      display: inline-block;	
    }	
    .apexcharts-legend-series.apexcharts-no-click {	
      cursor: auto;	
    }	
    .apexcharts-legend .apexcharts-hidden-zero-series, .apexcharts-legend .apexcharts-hidden-null-series {	
      display: none !important;	
    }	
    .apexcharts-inactive-legend {	
      opacity: 0.45;	
    }</style></foreignObject><g id="SvgjsG1661" class="apexcharts-inner apexcharts-graphical" transform="translate(12, 30)"><defs id="SvgjsDefs1660"><clipPath id="gridRectMaskdqsex8qg"><rect id="SvgjsRect1664" width="375.90625" height="204" x="-2" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="forecastMaskdqsex8qg"></clipPath><clipPath id="nonForecastMaskdqsex8qg"></clipPath><clipPath id="gridRectMarkerMaskdqsex8qg"><rect id="SvgjsRect1665" width="375.90625" height="208" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><g id="SvgjsG1720" class="apexcharts-grid"><g id="SvgjsG1721" class="apexcharts-gridlines-horizontal" style="display: none;"><line id="SvgjsLine1723" x1="0" y1="0" x2="371.90625" y2="0" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1724" x1="0" y1="51" x2="371.90625" y2="51" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1725" x1="0" y1="102" x2="371.90625" y2="102" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1726" x1="0" y1="153" x2="371.90625" y2="153" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1727" x1="0" y1="204" x2="371.90625" y2="204" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line></g><g id="SvgjsG1722" class="apexcharts-gridlines-vertical" style="display: none;"></g><line id="SvgjsLine1729" x1="0" y1="204" x2="371.90625" y2="204" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line><line id="SvgjsLine1728" x1="0" y1="1" x2="0" y2="204" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line></g><g id="SvgjsG1666" class="apexcharts-radar-series apexcharts-plot-series" transform="translate(185.953125, 102)"><polygon id="SvgjsPolygon1708" points="0,-104.32142857142857 90.3450073019409,-52.1607142857143 90.34500730194091,52.16071428571426 1.2775690358247924e-14,104.32142857142857 -90.34500730194087,52.160714285714334 -90.34500730194094,-52.160714285714214 " fill="none" stroke="#464964" stroke-width="1"></polygon><polygon id="SvgjsPolygon1709" points="0,-78.24107142857143 67.75875547645568,-39.12053571428572 67.75875547645569,39.1205357142857 9.581767768685943e-15,78.24107142857143 -67.75875547645566,39.12053571428575 -67.7587554764557,-39.120535714285666 " fill="none" stroke="#464964" stroke-width="1"></polygon><polygon id="SvgjsPolygon1710" points="0,-52.160714285714285 45.17250365097045,-26.08035714285715 45.172503650970455,26.08035714285713 6.387845179123962e-15,52.160714285714285 -45.172503650970434,26.080357142857167 -45.17250365097047,-26.080357142857107 " fill="none" stroke="#464964" stroke-width="1"></polygon><polygon id="SvgjsPolygon1711" points="0,-26.080357142857142 22.586251825485224,-13.040178571428575 22.586251825485228,13.040178571428566 3.193922589561981e-15,26.080357142857142 -22.586251825485217,13.040178571428584 -22.586251825485235,-13.040178571428553 " fill="none" stroke="#464964" stroke-width="1"></polygon><polygon id="SvgjsPolygon1712" points="0,0 0,0 0,0 0,0 0,0 0,0 " fill="none" stroke="#464964" stroke-width="1"></polygon><line id="SvgjsLine1702" x1="0" y1="-104.32142857142857" x2="0" y2="0" stroke="#464964" stroke-dasharray="0" stroke-linecap="butt"></line><line id="SvgjsLine1703" x1="90.3450073019409" y1="-52.1607142857143" x2="0" y2="0" stroke="#464964" stroke-dasharray="0" stroke-linecap="butt"></line><line id="SvgjsLine1704" x1="90.34500730194091" y1="52.16071428571426" x2="0" y2="0" stroke="#464964" stroke-dasharray="0" stroke-linecap="butt"></line><line id="SvgjsLine1705" x1="1.2775690358247924e-14" y1="104.32142857142857" x2="0" y2="0" stroke="#464964" stroke-dasharray="0" stroke-linecap="butt"></line><line id="SvgjsLine1706" x1="-90.34500730194087" y1="52.160714285714334" x2="0" y2="0" stroke="#464964" stroke-dasharray="0" stroke-linecap="butt"></line><line id="SvgjsLine1707" x1="-90.34500730194094" y1="-52.160714285714214" x2="0" y2="0" stroke="#464964" stroke-dasharray="0" stroke-linecap="butt"></line><g id="SvgjsG1713" class="apexcharts-xaxis"><text id="SvgjsText1714" font-family="Inter" x="0" y="-114.32142857142857" text-anchor="middle" dominant-baseline="auto" font-size="15px" font-weight="400" fill="#7b7d95" class="apexcharts-datalabel" cx="0" cy="-114.32142857142857" style="font-family: Inter;">Jan</text><text id="SvgjsText1715" font-family="Inter" x="100.3450073019409" y="-52.1607142857143" text-anchor="start" dominant-baseline="auto" font-size="15px" font-weight="400" fill="#7b7d95" class="apexcharts-datalabel" cx="100.3450073019409" cy="-52.1607142857143" style="font-family: Inter;">Feb</text><text id="SvgjsText1716" font-family="Inter" x="100.34500730194091" y="52.16071428571426" text-anchor="start" dominant-baseline="auto" font-size="15px" font-weight="400" fill="#7b7d95" class="apexcharts-datalabel" cx="100.34500730194091" cy="52.16071428571426" style="font-family: Inter;">Mar</text><text id="SvgjsText1717" font-family="Inter" x="1.2775690358247924e-14" y="114.32142857142857" text-anchor="middle" dominant-baseline="auto" font-size="15px" font-weight="400" fill="#7b7d95" class="apexcharts-datalabel" cx="1.2775690358247924e-14" cy="114.32142857142857" style="font-family: Inter;">Apr</text><text id="SvgjsText1718" font-family="Inter" x="-100.34500730194087" y="52.160714285714334" text-anchor="end" dominant-baseline="auto" font-size="15px" font-weight="400" fill="#7b7d95" class="apexcharts-datalabel" cx="-100.34500730194087" cy="52.160714285714334" style="font-family: Inter;">May</text><text id="SvgjsText1719" font-family="Inter" x="-100.34500730194094" y="-52.160714285714214" text-anchor="end" dominant-baseline="auto" font-size="15px" font-weight="400" fill="#7b7d95" class="apexcharts-datalabel" cx="-100.34500730194094" cy="-52.160714285714214" style="font-family: Inter;">Jun</text></g><g id="SvgjsG1668" class="apexcharts-series" data:longestSeries="true" seriesName="Income" rel="1" data:realIndex="0"><path id="SvgjsPath1671" d="M 0 -60.85416666666667L 0 -60.85416666666667L 67.75875547645568 -39.12053571428572L 60.230004867960595 34.773809523809504L 1.0114088200279607e-14 82.58779761904762L -56.46562956371305 32.60044642857146L -67.7587554764557 -39.120535714285666Z" fill="none" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-radar" index="0" pathTo="M 0 -60.85416666666667L 0 -60.85416666666667L 67.75875547645568 -39.12053571428572L 60.230004867960595 34.773809523809504L 1.0114088200279607e-14 82.58779761904762L -56.46562956371305 32.60044642857146L -67.7587554764557 -39.120535714285666Z" pathFrom="M 0 0"></path><path id="SvgjsPath1672" d="M 0 -60.85416666666667L 0 -60.85416666666667L 67.75875547645568 -39.12053571428572L 60.230004867960595 34.773809523809504L 1.0114088200279607e-14 82.58779761904762L -56.46562956371305 32.60044642857146L -67.7587554764557 -39.120535714285666Z" fill="rgba(253,181,40,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-radar" index="0" pathTo="M 0 -60.85416666666667L 0 -60.85416666666667L 67.75875547645568 -39.12053571428572L 60.230004867960595 34.773809523809504L 1.0114088200279607e-14 82.58779761904762L -56.46562956371305 32.60044642857146L -67.7587554764557 -39.120535714285666Z" pathFrom="M 0 0"></path><g id="SvgjsG1669" class="apexcharts-series-markers-wrap"><g id="SvgjsG1674" class="apexcharts-series-markers"><circle id="SvgjsCircle1673" r="0" cx="0" cy="-60.85416666666667" class="apexcharts-marker" stroke="#ffffff" fill="#fdb528" fill-opacity="1" stroke-width="1" stroke-opacity="1" rel="0" j="0" index="0" default-marker-size="0"></circle></g><g id="SvgjsG1676" class="apexcharts-series-markers"><circle id="SvgjsCircle1675" r="0" cx="67.75875547645568" cy="-39.12053571428572" class="apexcharts-marker" stroke="#ffffff" fill="#fdb528" fill-opacity="1" stroke-width="1" stroke-opacity="1" rel="1" j="1" index="0" default-marker-size="0"></circle></g><g id="SvgjsG1678" class="apexcharts-series-markers"><circle id="SvgjsCircle1677" r="0" cx="60.230004867960595" cy="34.773809523809504" class="apexcharts-marker" stroke="#ffffff" fill="#fdb528" fill-opacity="1" stroke-width="1" stroke-opacity="1" rel="2" j="2" index="0" default-marker-size="0"></circle></g><g id="SvgjsG1680" class="apexcharts-series-markers"><circle id="SvgjsCircle1679" r="0" cx="1.0114088200279607e-14" cy="82.58779761904762" class="apexcharts-marker" stroke="#ffffff" fill="#fdb528" fill-opacity="1" stroke-width="1" stroke-opacity="1" rel="3" j="3" index="0" default-marker-size="0"></circle></g><g id="SvgjsG1682" class="apexcharts-series-markers"><circle id="SvgjsCircle1681" r="0" cx="-56.46562956371305" cy="32.60044642857146" class="apexcharts-marker" stroke="#ffffff" fill="#fdb528" fill-opacity="1" stroke-width="1" stroke-opacity="1" rel="4" j="4" index="0" default-marker-size="0"></circle></g><g id="SvgjsG1684" class="apexcharts-series-markers"><circle id="SvgjsCircle1683" r="0" cx="-67.7587554764557" cy="-39.120535714285666" class="apexcharts-marker" stroke="#ffffff" fill="#fdb528" fill-opacity="1" stroke-width="1" stroke-opacity="1" rel="5" j="5" index="0" default-marker-size="0"></circle></g><g class="apexcharts-series-markers"><circle id="SvgjsCircle1735" r="0" cx="0" cy="0" class="apexcharts-marker wjt4iqidt" stroke="#ffffff" fill="#fdb528" fill-opacity="1" stroke-width="1" stroke-opacity="1" default-marker-size="0"></circle></g></g></g><g id="SvgjsG1685" class="apexcharts-series" data:longestSeries="true" seriesName="NetxWorth" rel="2" data:realIndex="1"><path id="SvgjsPath1688" d="M 0 -95.62797619047619L 0 -95.62797619047619L 54.20700438116454 -31.296428571428578L 46.67825377266948 26.949702380952374L 6.920165610717625e-15 56.507440476190474L -75.28750608495073 43.46726190476194L -56.465629563713094 -32.60044642857139Z" fill="none" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-radar" index="1" pathTo="M 0 -95.62797619047619L 0 -95.62797619047619L 54.20700438116454 -31.296428571428578L 46.67825377266948 26.949702380952374L 6.920165610717625e-15 56.507440476190474L -75.28750608495073 43.46726190476194L -56.465629563713094 -32.60044642857139Z" pathFrom="M 0 0"></path><path id="SvgjsPath1689" d="M 0 -95.62797619047619L 0 -95.62797619047619L 54.20700438116454 -31.296428571428578L 46.67825377266948 26.949702380952374L 6.920165610717625e-15 56.507440476190474L -75.28750608495073 43.46726190476194L -56.465629563713094 -32.60044642857139Z" fill="rgba(102,108,255,0.9)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-radar" index="1" pathTo="M 0 -95.62797619047619L 0 -95.62797619047619L 54.20700438116454 -31.296428571428578L 46.67825377266948 26.949702380952374L 6.920165610717625e-15 56.507440476190474L -75.28750608495073 43.46726190476194L -56.465629563713094 -32.60044642857139Z" pathFrom="M 0 0"></path><g id="SvgjsG1686" class="apexcharts-series-markers-wrap"><g id="SvgjsG1691" class="apexcharts-series-markers"><circle id="SvgjsCircle1690" r="0" cx="0" cy="-95.62797619047619" class="apexcharts-marker" stroke="#ffffff" fill="#666cff" fill-opacity="1" stroke-width="1" stroke-opacity="1" rel="0" j="0" index="1" default-marker-size="0"></circle></g><g id="SvgjsG1693" class="apexcharts-series-markers"><circle id="SvgjsCircle1692" r="0" cx="54.20700438116454" cy="-31.296428571428578" class="apexcharts-marker" stroke="#ffffff" fill="#666cff" fill-opacity="1" stroke-width="1" stroke-opacity="1" rel="1" j="1" index="1" default-marker-size="0"></circle></g><g id="SvgjsG1695" class="apexcharts-series-markers"><circle id="SvgjsCircle1694" r="0" cx="46.67825377266948" cy="26.949702380952374" class="apexcharts-marker" stroke="#ffffff" fill="#666cff" fill-opacity="1" stroke-width="1" stroke-opacity="1" rel="2" j="2" index="1" default-marker-size="0"></circle></g><g id="SvgjsG1697" class="apexcharts-series-markers"><circle id="SvgjsCircle1696" r="0" cx="6.920165610717625e-15" cy="56.507440476190474" class="apexcharts-marker" stroke="#ffffff" fill="#666cff" fill-opacity="1" stroke-width="1" stroke-opacity="1" rel="3" j="3" index="1" default-marker-size="0"></circle></g><g id="SvgjsG1699" class="apexcharts-series-markers"><circle id="SvgjsCircle1698" r="0" cx="-75.28750608495073" cy="43.46726190476194" class="apexcharts-marker" stroke="#ffffff" fill="#666cff" fill-opacity="1" stroke-width="1" stroke-opacity="1" rel="4" j="4" index="1" default-marker-size="0"></circle></g><g id="SvgjsG1701" class="apexcharts-series-markers"><circle id="SvgjsCircle1700" r="0" cx="-56.465629563713094" cy="-32.60044642857139" class="apexcharts-marker" stroke="#ffffff" fill="#666cff" fill-opacity="1" stroke-width="1" stroke-opacity="1" rel="5" j="5" index="1" default-marker-size="0"></circle></g><g class="apexcharts-series-markers"><circle id="SvgjsCircle1736" r="0" cx="0" cy="0" class="apexcharts-marker wx9bwd26v" stroke="#ffffff" fill="#666cff" fill-opacity="1" stroke-width="1" stroke-opacity="1" default-marker-size="0"></circle></g></g></g><g id="SvgjsG1667" class="apexcharts-yaxis"></g><g id="SvgjsG1670" class="apexcharts-datalabels" data:realIndex="0"></g><g id="SvgjsG1687" class="apexcharts-datalabels" data:realIndex="1"></g></g><line id="SvgjsLine1730" x1="0" y1="0" x2="371.90625" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1731" x1="0" y1="0" x2="371.90625" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG1732" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG1733" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG1734" class="apexcharts-point-annotations"></g></g><g id="SvgjsG1662" class="apexcharts-annotations"></g></svg><div class="apexcharts-tooltip apexcharts-theme-light"><div class="apexcharts-tooltip-title" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"></div><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(253, 181, 40);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div><div class="apexcharts-tooltip-series-group" style="order: 2;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(102, 108, 255);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light"><div class="apexcharts-yaxistooltip-text"></div></div></div></div>
                  <div class="resize-triggers"><div class="expand-trigger"><div style="width: 448px; height: 423px;"></div></div><div class="contract-trigger"></div></div></div>
                </div>
              </div>
              <!--/ Performance Chart -->

              <!-- Project Statistics -->
              <div class="col-md-6 col-xxl-4">
                <div class="card h-100">
                  <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Project Statistics</h5>
                    <div class="dropdown">
                      <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-1 waves-effect waves-light" type="button" id="projectStatus" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ri-more-2-line ri-20px"></i>
                      </button>
                      <div class="dropdown-menu dropdown-menu-end" aria-labelledby="projectStatus">
                        <a class="dropdown-item waves-effect" href="javascript:void(0);">Last 28 Days</a>
                        <a class="dropdown-item waves-effect" href="javascript:void(0);">Last Month</a>
                        <a class="dropdown-item waves-effect" href="javascript:void(0);">Last Year</a>
                      </div>
                    </div>
                  </div>
                  <div class="d-flex justify-content-between p-4 border-bottom">
                    <p class="mb-0 fs-xsmall">NAME</p>
                    <p class="mb-0 fs-xsmall">BUDGET</p>
                  </div>
                  <div class="card-body">
                    <ul class="p-0 m-0">
                      <li class="d-flex align-items-center mb-6">
                        <div class="avatar avatar-md flex-shrink-0 me-4">
                          <div class="avatar-initial bg-light-gray rounded-3">
                            <div>
                              <img src="../../assets/img/icons/misc/3d-illustration.png" alt="User" class="h-25">
                            </div>
                          </div>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                          <div class="me-2">
                            <h6 class="mb-1">3D Illustration</h6>
                            <small>Blender Illustration</small>
                          </div>
                          <div class="badge bg-label-primary rounded-pill">$6,500</div>
                        </div>
                      </li>
                      <li class="d-flex align-items-center mb-6">
                        <div class="avatar avatar-md flex-shrink-0 me-4">
                          <div class="avatar-initial bg-light-gray rounded-3">
                            <div>
                              <img src="../../assets/img/icons/misc/finance-app-design.png" alt="User" class="h-25">
                            </div>
                          </div>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                          <div class="me-2">
                            <h6 class="mb-1">Finance App Design</h6>
                            <small>Figma UI Kit</small>
                          </div>
                          <div class="badge bg-label-primary rounded-pill">$4,290</div>
                        </div>
                      </li>
                      <li class="d-flex align-items-center mb-6">
                        <div class="avatar avatar-md flex-shrink-0 me-4">
                          <div class="avatar-initial bg-light-gray rounded-3">
                            <div>
                              <img src="../../assets/img/icons/misc/4-square.png" alt="User" class="h-25">
                            </div>
                          </div>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                          <div class="me-2">
                            <h6 class="mb-1">4 Square</h6>
                            <small>Android Application</small>
                          </div>
                          <div class="badge bg-label-primary rounded-pill">$44,500</div>
                        </div>
                      </li>
                      <li class="d-flex align-items-center mb-6">
                        <div class="avatar avatar-md flex-shrink-0 me-4">
                          <div class="avatar-initial bg-light-gray rounded-3">
                            <div>
                              <img src="../../assets/img/icons/misc/delta-web-app.png" alt="User" class="h-25">
                            </div>
                          </div>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                          <div class="me-2">
                            <h6 class="mb-1">Delta Web App</h6>
                            <small>React Dashboard</small>
                          </div>
                          <div class="badge bg-label-primary rounded-pill">$12,690</div>
                        </div>
                      </li>
                      <li class="d-flex align-items-center">
                        <div class="avatar avatar-md flex-shrink-0 me-4">
                          <div class="avatar-initial bg-light-gray rounded-3">
                            <div>
                              <img src="../../assets/img/icons/misc/ecommerce-website.png" alt="User" class="h-25">
                            </div>
                          </div>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                          <div class="me-2">
                            <h6 class="mb-1">eCommerce Website</h6>
                            <small>Vue + Laravel</small>
                          </div>
                          <div class="badge bg-label-primary rounded-pill">$10,850</div>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <!--/ Project Statistics -->

              <!-- Multiple widgets -->
              <div class="col-md-6 col-xxl-4">
                <div class="row g-4">
                  <!-- Total Revenue chart -->
                  <div class="col-md-6 col-sm-6">
                    <div class="card h-100">
                      <div class="card-header pb-xl-8">
                        <div class="d-flex align-items-center mb-1 flex-wrap">
                          <h5 class="mb-0 me-1">$42.5k</h5>
                          <p class="mb-0 text-danger">-22%</p>
                        </div>
                        <span class="d-block card-subtitle">Total Revenue</span>
                      </div>
                      <div class="card-body" style="position: relative;">
                        <div id="totalRevenue" style="min-height: 115px;"><div id="apexchartsshqaqunol" class="apexcharts-canvas apexchartsshqaqunol apexcharts-theme-light" style="width: 175px; height: 115px;"><svg id="SvgjsSvg1737" width="175" height="115" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg apexcharts-zoomable" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG1739" class="apexcharts-inner apexcharts-graphical" transform="translate(15.740000000000002, 10)"><defs id="SvgjsDefs1738"><linearGradient id="SvgjsLinearGradient1742" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop1743" stop-opacity="0.4" stop-color="rgba(216,227,240,0.4)" offset="0"></stop><stop id="SvgjsStop1744" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop><stop id="SvgjsStop1745" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop></linearGradient><clipPath id="gridRectMaskshqaqunol"><rect id="SvgjsRect1747" width="183.00000000000003" height="105" x="-17.740000000000002" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="forecastMaskshqaqunol"></clipPath><clipPath id="nonForecastMaskshqaqunol"></clipPath><clipPath id="gridRectMarkerMaskshqaqunol"><rect id="SvgjsRect1748" width="151.52" height="109" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><rect id="SvgjsRect1746" width="0" height="105" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke-dasharray="3" fill="url(#SvgjsLinearGradient1742)" class="apexcharts-xcrosshairs" y2="105" filter="none" fill-opacity="0.9"></rect><g id="SvgjsG1772" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG1773" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g></g><g id="SvgjsG1781" class="apexcharts-grid"><g id="SvgjsG1782" class="apexcharts-gridlines-horizontal"></g><g id="SvgjsG1783" class="apexcharts-gridlines-vertical"></g><line id="SvgjsLine1785" x1="0" y1="105" x2="147.52" y2="105" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line><line id="SvgjsLine1784" x1="0" y1="1" x2="0" y2="105" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line></g><g id="SvgjsG1749" class="apexcharts-bar-series apexcharts-plot-series"><g id="SvgjsG1750" class="apexcharts-series" rel="1" seriesName="Earning" data:realIndex="0"><path id="SvgjsPath1754" d="M -11.801599999999999 105L -11.801599999999999 48Q -11.801599999999999 42 -5.801599999999999 42L -6 42Q 0 42 0 48L 0 48L 0 105Q 0 105 0 105L -11.801599999999999 105Q -11.801599999999999 105 -11.801599999999999 105z" fill="rgba(102,108,255,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskshqaqunol)" pathTo="M -11.801599999999999 105L -11.801599999999999 48Q -11.801599999999999 42 -5.801599999999999 42L -6 42Q 0 42 0 48L 0 48L 0 105Q 0 105 0 105L -11.801599999999999 105Q -11.801599999999999 105 -11.801599999999999 105z" pathFrom="M -11.801599999999999 105L -11.801599999999999 105L 0 105L 0 105L 0 105L 0 105L 0 105L -11.801599999999999 105" cy="42" cx="0" j="0" val="120" barHeight="63" barWidth="11.801599999999999"></path><path id="SvgjsPath1756" d="M 37.37173333333333 105L 37.37173333333333 6Q 37.37173333333333 0 43.37173333333333 0L 43.17333333333333 0Q 49.17333333333333 0 49.17333333333333 6L 49.17333333333333 6L 49.17333333333333 105Q 49.17333333333333 105 49.17333333333333 105L 37.37173333333333 105Q 37.37173333333333 105 37.37173333333333 105z" fill="rgba(102,108,255,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskshqaqunol)" pathTo="M 37.37173333333333 105L 37.37173333333333 6Q 37.37173333333333 0 43.37173333333333 0L 43.17333333333333 0Q 49.17333333333333 0 49.17333333333333 6L 49.17333333333333 6L 49.17333333333333 105Q 49.17333333333333 105 49.17333333333333 105L 37.37173333333333 105Q 37.37173333333333 105 37.37173333333333 105z" pathFrom="M 37.37173333333333 105L 37.37173333333333 105L 49.17333333333333 105L 49.17333333333333 105L 49.17333333333333 105L 49.17333333333333 105L 49.17333333333333 105L 37.37173333333333 105" cy="0" cx="49.17333333333333" j="1" val="200" barHeight="105" barWidth="11.801599999999999"></path><path id="SvgjsPath1758" d="M 86.54506666666667 105L 86.54506666666667 32.25Q 86.54506666666667 26.25 92.54506666666667 26.25L 92.34666666666666 26.25Q 98.34666666666666 26.25 98.34666666666666 32.25L 98.34666666666666 32.25L 98.34666666666666 105Q 98.34666666666666 105 98.34666666666666 105L 86.54506666666667 105Q 86.54506666666667 105 86.54506666666667 105z" fill="rgba(102,108,255,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskshqaqunol)" pathTo="M 86.54506666666667 105L 86.54506666666667 32.25Q 86.54506666666667 26.25 92.54506666666667 26.25L 92.34666666666666 26.25Q 98.34666666666666 26.25 98.34666666666666 32.25L 98.34666666666666 32.25L 98.34666666666666 105Q 98.34666666666666 105 98.34666666666666 105L 86.54506666666667 105Q 86.54506666666667 105 86.54506666666667 105z" pathFrom="M 86.54506666666667 105L 86.54506666666667 105L 98.34666666666666 105L 98.34666666666666 105L 98.34666666666666 105L 98.34666666666666 105L 98.34666666666666 105L 86.54506666666667 105" cy="26.25" cx="98.34666666666666" j="2" val="150" barHeight="78.75" barWidth="11.801599999999999"></path><path id="SvgjsPath1760" d="M 135.7184 105L 135.7184 48Q 135.7184 42 141.7184 42L 141.52 42Q 147.52 42 147.52 48L 147.52 48L 147.52 105Q 147.52 105 147.52 105L 135.7184 105Q 135.7184 105 135.7184 105z" fill="rgba(102,108,255,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskshqaqunol)" pathTo="M 135.7184 105L 135.7184 48Q 135.7184 42 141.7184 42L 141.52 42Q 147.52 42 147.52 48L 147.52 48L 147.52 105Q 147.52 105 147.52 105L 135.7184 105Q 135.7184 105 135.7184 105z" pathFrom="M 135.7184 105L 135.7184 105L 147.52 105L 147.52 105L 147.52 105L 147.52 105L 147.52 105L 135.7184 105" cy="42" cx="147.52" j="3" val="120" barHeight="63" barWidth="11.801599999999999"></path><g id="SvgjsG1752" class="apexcharts-bar-goals-markers" style="pointer-events: none"><g id="SvgjsG1753" className="apexcharts-bar-goals-groups"></g><g id="SvgjsG1755" className="apexcharts-bar-goals-groups"></g><g id="SvgjsG1757" className="apexcharts-bar-goals-groups"></g><g id="SvgjsG1759" className="apexcharts-bar-goals-groups"></g></g></g><g id="SvgjsG1761" class="apexcharts-series" rel="2" seriesName="Expense" data:realIndex="1"><path id="SvgjsPath1765" d="M 0 105L 0 73.19999999999999Q 0 67.19999999999999 6 67.19999999999999L 5.801599999999999 67.19999999999999Q 11.801599999999999 67.19999999999999 11.801599999999999 73.19999999999999L 11.801599999999999 73.19999999999999L 11.801599999999999 105Q 11.801599999999999 105 11.801599999999999 105L 0 105Q 0 105 0 105z" fill="rgba(253,181,40,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMaskshqaqunol)" pathTo="M 0 105L 0 73.19999999999999Q 0 67.19999999999999 6 67.19999999999999L 5.801599999999999 67.19999999999999Q 11.801599999999999 67.19999999999999 11.801599999999999 73.19999999999999L 11.801599999999999 73.19999999999999L 11.801599999999999 105Q 11.801599999999999 105 11.801599999999999 105L 0 105Q 0 105 0 105z" pathFrom="M 0 105L 0 105L 11.801599999999999 105L 11.801599999999999 105L 11.801599999999999 105L 11.801599999999999 105L 11.801599999999999 105L 0 105" cy="61.19999999999999" cx="11.801599999999999" j="0" val="72" barHeight="37.800000000000004" barWidth="11.801599999999999"></path><path id="SvgjsPath1767" d="M 49.17333333333333 105L 49.17333333333333 48Q 49.17333333333333 42 55.17333333333333 42L 54.97493333333333 42Q 60.97493333333333 42 60.97493333333333 48L 60.97493333333333 48L 60.97493333333333 105Q 60.97493333333333 105 60.97493333333333 105L 49.17333333333333 105Q 49.17333333333333 105 49.17333333333333 105z" fill="rgba(253,181,40,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMaskshqaqunol)" pathTo="M 49.17333333333333 105L 49.17333333333333 48Q 49.17333333333333 42 55.17333333333333 42L 54.97493333333333 42Q 60.97493333333333 42 60.97493333333333 48L 60.97493333333333 48L 60.97493333333333 105Q 60.97493333333333 105 60.97493333333333 105L 49.17333333333333 105Q 49.17333333333333 105 49.17333333333333 105z" pathFrom="M 49.17333333333333 105L 49.17333333333333 105L 60.97493333333333 105L 60.97493333333333 105L 60.97493333333333 105L 60.97493333333333 105L 60.97493333333333 105L 49.17333333333333 105" cy="36" cx="60.974933333333325" j="1" val="120" barHeight="63" barWidth="11.801599999999999"></path><path id="SvgjsPath1769" d="M 98.34666666666666 105L 98.34666666666666 84.75Q 98.34666666666666 78.75 104.34666666666666 78.75L 104.14826666666666 78.75Q 110.14826666666666 78.75 110.14826666666666 84.75L 110.14826666666666 84.75L 110.14826666666666 105Q 110.14826666666666 105 110.14826666666666 105L 98.34666666666666 105Q 98.34666666666666 105 98.34666666666666 105z" fill="rgba(253,181,40,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMaskshqaqunol)" pathTo="M 98.34666666666666 105L 98.34666666666666 84.75Q 98.34666666666666 78.75 104.34666666666666 78.75L 104.14826666666666 78.75Q 110.14826666666666 78.75 110.14826666666666 84.75L 110.14826666666666 84.75L 110.14826666666666 105Q 110.14826666666666 105 110.14826666666666 105L 98.34666666666666 105Q 98.34666666666666 105 98.34666666666666 105z" pathFrom="M 98.34666666666666 105L 98.34666666666666 105L 110.14826666666666 105L 110.14826666666666 105L 110.14826666666666 105L 110.14826666666666 105L 110.14826666666666 105L 98.34666666666666 105" cy="72.75" cx="110.14826666666667" j="2" val="50" barHeight="26.25" barWidth="11.801599999999999"></path><path id="SvgjsPath1771" d="M 147.52 105L 147.52 76.875Q 147.52 70.875 153.52 70.875L 153.32160000000002 70.875Q 159.32160000000002 70.875 159.32160000000002 76.875L 159.32160000000002 76.875L 159.32160000000002 105Q 159.32160000000002 105 159.32160000000002 105L 147.52 105Q 147.52 105 147.52 105z" fill="rgba(253,181,40,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMaskshqaqunol)" pathTo="M 147.52 105L 147.52 76.875Q 147.52 70.875 153.52 70.875L 153.32160000000002 70.875Q 159.32160000000002 70.875 159.32160000000002 76.875L 159.32160000000002 76.875L 159.32160000000002 105Q 159.32160000000002 105 159.32160000000002 105L 147.52 105Q 147.52 105 147.52 105z" pathFrom="M 147.52 105L 147.52 105L 159.32160000000002 105L 159.32160000000002 105L 159.32160000000002 105L 159.32160000000002 105L 159.32160000000002 105L 147.52 105" cy="64.875" cx="159.3216" j="3" val="65" barHeight="34.125" barWidth="11.801599999999999"></path><g id="SvgjsG1763" class="apexcharts-bar-goals-markers" style="pointer-events: none"><g id="SvgjsG1764" className="apexcharts-bar-goals-groups"></g><g id="SvgjsG1766" className="apexcharts-bar-goals-groups"></g><g id="SvgjsG1768" className="apexcharts-bar-goals-groups"></g><g id="SvgjsG1770" className="apexcharts-bar-goals-groups"></g></g></g><g id="SvgjsG1751" class="apexcharts-datalabels" data:realIndex="0"></g><g id="SvgjsG1762" class="apexcharts-datalabels" data:realIndex="1"></g></g><line id="SvgjsLine1786" x1="-15.74" y1="0" x2="163.26000000000002" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1787" x1="-15.74" y1="0" x2="163.26000000000002" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG1788" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG1789" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG1790" class="apexcharts-point-annotations"></g><rect id="SvgjsRect1791" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe" class="apexcharts-zoom-rect"></rect><rect id="SvgjsRect1792" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe" class="apexcharts-selection-rect"></rect></g><g id="SvgjsG1779" class="apexcharts-yaxis" rel="0" transform="translate(-8, 0)"><g id="SvgjsG1780" class="apexcharts-yaxis-texts-g"></g></g><g id="SvgjsG1740" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend" style="max-height: 57.5px;"></div></div></div>
                      <div class="resize-triggers"><div class="expand-trigger"><div style="width: 216px; height: 136px;"></div></div><div class="contract-trigger"></div></div></div>
                    </div>
                  </div>
                  <!--/ Total Revenue chart -->

                  <div class="col-md-6 col-sm-6">
                    <div class="card h-100">
                      <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                          <div class="avatar">
                            <div class="avatar-initial bg-label-success rounded-3">
                              <i class="ri-handbag-line ri-24px"></i>
                            </div>
                          </div>
                          <div class="d-flex align-items-center">
                            <p class="mb-0 text-success me-1">+38%</p>
                            <i class="ri-arrow-up-s-line text-success"></i>
                          </div>
                        </div>
                        <div class="card-info mt-5 mt-xl-8">
                          <h5 class="mb-1">$13.4k</h5>
                          <p>Total Sales</p>
                          <div class="badge bg-label-secondary rounded-pill">Last Six Month</div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6 col-sm-6">
                    <div class="card h-100">
                      <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                          <div class="avatar">
                            <div class="avatar-initial bg-label-info rounded-3">
                              <i class="ri-links-line ri-24px"></i>
                            </div>
                          </div>
                          <div class="d-flex align-items-center">
                            <p class="mb-0 text-success me-1">+62%</p>
                            <i class="ri-arrow-up-s-line text-success"></i>
                          </div>
                        </div>
                        <div class="card-info mt-5 mt-xl-8">
                          <h5 class="mb-1">142.8k</h5>
                          <p>Total Impression</p>
                          <div class="badge bg-label-secondary rounded-pill">Last One Year</div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- overview Radial chart -->
                  <div class="col-md-6 col-sm-6">
                    <div class="card h-100">
                      <div class="card-header pb-xl-7">
                        <div class="d-flex align-items-center mb-1 flex-wrap">
                          <h5 class="mb-0 me-1">$67.1k</h5>
                          <p class="mb-0 text-success">+49%</p>
                        </div>
                        <span class="d-block card-subtitle">Overview</span>
                      </div>
                      <div class="card-body pb-xl-8" style="position: relative;">
                        <div id="overviewChart" class="d-flex align-items-center" style="min-height: 120px;"><div id="apexchartsrozrerz7" class="apexcharts-canvas apexchartsrozrerz7 apexcharts-theme-light" style="width: 175px; height: 120px;"><svg id="SvgjsSvg1793" width="175" height="120" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG1795" class="apexcharts-inner apexcharts-graphical" transform="translate(20.5, 0)"><defs id="SvgjsDefs1794"><clipPath id="gridRectMaskrozrerz7"><rect id="SvgjsRect1797" width="140" height="151" x="-3" y="-1" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="forecastMaskrozrerz7"></clipPath><clipPath id="nonForecastMaskrozrerz7"></clipPath><clipPath id="gridRectMarkerMaskrozrerz7"><rect id="SvgjsRect1798" width="138" height="153" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><g id="SvgjsG1799" class="apexcharts-radialbar"><g id="SvgjsG1800"><g id="SvgjsG1801" class="apexcharts-tracks"><g id="SvgjsG1802" class="apexcharts-radialbar-track apexcharts-track" rel="1"><path id="apexcharts-radialbarTrack-0" d="M 67 21.195121951219512 A 45.80487804878049 45.80487804878049 0 1 1 66.99200554068632 21.195122648867695" fill="none" fill-opacity="1" stroke="#6d788d29" stroke-opacity="1" stroke-linecap="round" stroke-width="9.416097560975613" stroke-dasharray="0" class="apexcharts-radialbar-area" data:pathOrig="M 67 21.195121951219512 A 45.80487804878049 45.80487804878049 0 1 1 66.99200554068632 21.195122648867695"></path></g></g><g id="SvgjsG1804"><g id="SvgjsG1808" class="apexcharts-series apexcharts-radial-series" seriesName="Progress" rel="1" data:realIndex="0"><path id="SvgjsPath1809" d="M 67 21.195121951219512 A 45.80487804878049 45.80487804878049 0 1 1 31.911427702989258 96.44280807295905" fill="none" fill-opacity="0.85" stroke="rgba(102,108,255,0.85)" stroke-opacity="1" stroke-linecap="round" stroke-width="9.707317073170735" stroke-dasharray="0" class="apexcharts-radialbar-area apexcharts-radialbar-slice-0" data:angle="230" data:value="64" index="0" j="0" data:pathOrig="M 67 21.195121951219512 A 45.80487804878049 45.80487804878049 0 1 1 31.911427702989258 96.44280807295905"></path></g><circle id="SvgjsCircle1805" r="36.09682926829268" cx="67" cy="67" class="apexcharts-radialbar-hollow" fill="transparent"></circle><g id="SvgjsG1806" class="apexcharts-datalabels-group" transform="translate(0, 0) scale(1)" style="opacity: 1;"><text id="SvgjsText1807" font-family="Inter" x="67" y="72" text-anchor="middle" dominant-baseline="auto" font-size="1rem" font-weight="500" fill="#d7d8ee" class="apexcharts-text apexcharts-datalabel-value" style="font-family: Inter;">64%</text></g></g></g></g><line id="SvgjsLine1810" x1="0" y1="0" x2="134" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1811" x1="0" y1="0" x2="134" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line></g><g id="SvgjsG1796" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend"></div></div></div>
                      <div class="resize-triggers"><div class="expand-trigger"><div style="width: 216px; height: 153px;"></div></div><div class="contract-trigger"></div></div></div>
                    </div>
                  </div>
                  <!--/ overview Radial chart -->
                </div>
              </div>
              <!--/ Multiple widgets -->

              <!-- Sales Country Chart -->
              <div class="col-12 col-xxl-4 col-md-6">
                <div class="card h-100">
                  <div class="card-header">
                    <div class="d-flex justify-content-between">
                      <h5 class="mb-1">Sales Country</h5>
                      <div class="dropdown">
                        <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-1 waves-effect waves-light" type="button" id="salesCountryDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="ri-more-2-line ri-20px"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="salesCountryDropdown">
                          <a class="dropdown-item waves-effect" href="javascript:void(0);">Last 28 Days</a>
                          <a class="dropdown-item waves-effect" href="javascript:void(0);">Last Month</a>
                          <a class="dropdown-item waves-effect" href="javascript:void(0);">Last Year</a>
                        </div>
                      </div>
                    </div>
                    <p class="mb-0 card-subtitle">Total $42,580 Sales</p>
                  </div>
                  <div class="card-body pb-1 px-0" style="position: relative;">
                    <div id="salesCountryChart" style="min-height: 368px;"><div id="apexcharts3apn2jfb" class="apexcharts-canvas apexcharts3apn2jfb apexcharts-theme-light" style="width: 447px; height: 368px;"><svg id="SvgjsSvg1812" width="447" height="368" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG1814" class="apexcharts-inner apexcharts-graphical" transform="translate(57.21875, 12)"><defs id="SvgjsDefs1813"><linearGradient id="SvgjsLinearGradient1818" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop1819" stop-opacity="0.4" stop-color="rgba(216,227,240,0.4)" offset="0"></stop><stop id="SvgjsStop1820" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop><stop id="SvgjsStop1821" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop></linearGradient><clipPath id="gridRectMask3apn2jfb"><rect id="SvgjsRect1823" width="360.78125" height="306.73" x="-2" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="forecastMask3apn2jfb"></clipPath><clipPath id="nonForecastMask3apn2jfb"></clipPath><clipPath id="gridRectMarkerMask3apn2jfb"><rect id="SvgjsRect1824" width="360.78125" height="310.73" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><rect id="SvgjsRect1822" width="0" height="306.73" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke-dasharray="3" fill="url(#SvgjsLinearGradient1818)" class="apexcharts-xcrosshairs" y2="306.73" filter="none" fill-opacity="0.9"></rect><g id="SvgjsG1879" class="apexcharts-yaxis apexcharts-xaxis-inversed" rel="0"><g id="SvgjsG1880" class="apexcharts-yaxis-texts-g apexcharts-xaxis-inversed-texts-g" transform="translate(0, 0)"><text id="SvgjsText1881" font-family="Inter" x="-15" y="33.46145454545455" text-anchor="end" dominant-baseline="auto" font-size="0.9375rem" font-weight="500" fill="#d7d8ee" class="apexcharts-text apexcharts-yaxis-label " style="font-family: Inter;"><tspan id="SvgjsTspan1882">US</tspan><title>US</title></text><text id="SvgjsText1883" font-family="Inter" x="-15" y="94.80745454545456" text-anchor="end" dominant-baseline="auto" font-size="0.9375rem" font-weight="500" fill="#d7d8ee" class="apexcharts-text apexcharts-yaxis-label " style="font-family: Inter;"><tspan id="SvgjsTspan1884">IN</tspan><title>IN</title></text><text id="SvgjsText1885" font-family="Inter" x="-15" y="156.15345454545457" text-anchor="end" dominant-baseline="auto" font-size="0.9375rem" font-weight="500" fill="#d7d8ee" class="apexcharts-text apexcharts-yaxis-label " style="font-family: Inter;"><tspan id="SvgjsTspan1886">JA</tspan><title>JA</title></text><text id="SvgjsText1887" font-family="Inter" x="-15" y="217.49945454545457" text-anchor="end" dominant-baseline="auto" font-size="0.9375rem" font-weight="500" fill="#d7d8ee" class="apexcharts-text apexcharts-yaxis-label " style="font-family: Inter;"><tspan id="SvgjsTspan1888">CA</tspan><title>CA</title></text><text id="SvgjsText1889" font-family="Inter" x="-15" y="278.8454545454546" text-anchor="end" dominant-baseline="auto" font-size="0.9375rem" font-weight="500" fill="#d7d8ee" class="apexcharts-text apexcharts-yaxis-label " style="font-family: Inter;"><tspan id="SvgjsTspan1890">AU</tspan><title>AU</title></text></g></g><g id="SvgjsG1859" class="apexcharts-xaxis apexcharts-yaxis-inversed"><g id="SvgjsG1860" class="apexcharts-xaxis-texts-g" transform="translate(0, -8.666666666666666)"><text id="SvgjsText1861" font-family="Helvetica, Arial, sans-serif" x="356.78125" y="336.73" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#7b7d95" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1863">20K</tspan><title>20K</title></text><text id="SvgjsText1864" font-family="Helvetica, Arial, sans-serif" x="285.325" y="336.73" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#7b7d95" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1866">16K</tspan><title>16K</title></text><text id="SvgjsText1867" font-family="Helvetica, Arial, sans-serif" x="213.86875000000003" y="336.73" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#7b7d95" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1869">12K</tspan><title>12K</title></text><text id="SvgjsText1870" font-family="Helvetica, Arial, sans-serif" x="142.41250000000002" y="336.73" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#7b7d95" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1872">8K</tspan><title>8K</title></text><text id="SvgjsText1873" font-family="Helvetica, Arial, sans-serif" x="70.95625000000001" y="336.73" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#7b7d95" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1875">4K</tspan><title>4K</title></text><text id="SvgjsText1876" font-family="Helvetica, Arial, sans-serif" x="-0.5" y="336.73" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#7b7d95" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1878">0K</tspan><title>0K</title></text></g></g><g id="SvgjsG1891" class="apexcharts-grid"><g id="SvgjsG1892" class="apexcharts-gridlines-horizontal"></g><g id="SvgjsG1893" class="apexcharts-gridlines-vertical"><line id="SvgjsLine1894" x1="0" y1="0" x2="0" y2="306.73" stroke="#464964" stroke-dasharray="8" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1895" x1="71.65625" y1="0" x2="71.65625" y2="306.73" stroke="#464964" stroke-dasharray="8" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1896" x1="143.3125" y1="0" x2="143.3125" y2="306.73" stroke="#464964" stroke-dasharray="8" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1897" x1="214.96875" y1="0" x2="214.96875" y2="306.73" stroke="#464964" stroke-dasharray="8" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1898" x1="286.625" y1="0" x2="286.625" y2="306.73" stroke="#464964" stroke-dasharray="8" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1899" x1="358.28125" y1="0" x2="358.28125" y2="306.73" stroke="#464964" stroke-dasharray="8" stroke-linecap="butt" class="apexcharts-gridline"></line></g><line id="SvgjsLine1901" x1="0" y1="306.73" x2="356.78125" y2="306.73" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line><line id="SvgjsLine1900" x1="0" y1="1" x2="0" y2="306.73" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line></g><g id="SvgjsG1825" class="apexcharts-bar-series apexcharts-plot-series"><g id="SvgjsG1826" class="apexcharts-series" rel="1" seriesName="Sales" data:realIndex="0"><path id="SvgjsPath1830" d="M 0.1 12.269200000000001L 296.30750781250003 12.269200000000001Q 306.30750781250003 12.269200000000001 306.30750781250003 22.2692L 306.30750781250003 39.076800000000006Q 306.30750781250003 49.076800000000006 296.30750781250003 49.076800000000006L 296.30750781250003 49.076800000000006L 0.1 49.076800000000006L 0.1 49.076800000000006Q 0.1 49.076800000000006 0.1 49.076800000000006L 0.1 12.269200000000001Q 0.1 12.269200000000001 0.1 12.269200000000001z" fill="rgba(102,108,255,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask3apn2jfb)" pathTo="M 0.1 12.269200000000001L 296.30750781250003 12.269200000000001Q 306.30750781250003 12.269200000000001 306.30750781250003 22.2692L 306.30750781250003 39.076800000000006Q 306.30750781250003 49.076800000000006 296.30750781250003 49.076800000000006L 296.30750781250003 49.076800000000006L 0.1 49.076800000000006L 0.1 49.076800000000006Q 0.1 49.076800000000006 0.1 49.076800000000006L 0.1 12.269200000000001Q 0.1 12.269200000000001 0.1 12.269200000000001z" pathFrom="M 0.1 12.269200000000001L 0.1 12.269200000000001L 0.1 49.076800000000006L 0.1 49.076800000000006L 0.1 49.076800000000006L 0.1 49.076800000000006L 0.1 49.076800000000006L 0.1 12.269200000000001" cy="73.6152" cx="306.30750781250003" j="0" val="17165" barHeight="36.8076" barWidth="306.2075078125"></path><path id="SvgjsPath1836" d="M 0.1 73.6152L 237.171015625 73.6152Q 247.171015625 73.6152 247.171015625 83.6152L 247.171015625 100.4228Q 247.171015625 110.4228 237.171015625 110.4228L 237.171015625 110.4228L 0.1 110.4228L 0.1 110.4228Q 0.1 110.4228 0.1 110.4228L 0.1 73.6152Q 0.1 73.6152 0.1 73.6152z" fill="rgba(114,225,40,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask3apn2jfb)" pathTo="M 0.1 73.6152L 237.171015625 73.6152Q 247.171015625 73.6152 247.171015625 83.6152L 247.171015625 100.4228Q 247.171015625 110.4228 237.171015625 110.4228L 237.171015625 110.4228L 0.1 110.4228L 0.1 110.4228Q 0.1 110.4228 0.1 110.4228L 0.1 73.6152Q 0.1 73.6152 0.1 73.6152z" pathFrom="M 0.1 73.6152L 0.1 73.6152L 0.1 110.4228L 0.1 110.4228L 0.1 110.4228L 0.1 110.4228L 0.1 110.4228L 0.1 73.6152" cy="134.96120000000002" cx="247.171015625" j="1" val="13850" barHeight="36.8076" barWidth="247.071015625"></path><path id="SvgjsPath1842" d="M 0.1 134.96120000000002L 210.8583984375 134.96120000000002Q 220.8583984375 134.96120000000002 220.8583984375 144.96120000000002L 220.8583984375 161.76880000000003Q 220.8583984375 171.76880000000003 210.8583984375 171.76880000000003L 210.8583984375 171.76880000000003L 0.1 171.76880000000003L 0.1 171.76880000000003Q 0.1 171.76880000000003 0.1 171.76880000000003L 0.1 134.96120000000002Q 0.1 134.96120000000002 0.1 134.96120000000002z" fill="rgba(253,181,40,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask3apn2jfb)" pathTo="M 0.1 134.96120000000002L 210.8583984375 134.96120000000002Q 220.8583984375 134.96120000000002 220.8583984375 144.96120000000002L 220.8583984375 161.76880000000003Q 220.8583984375 171.76880000000003 210.8583984375 171.76880000000003L 210.8583984375 171.76880000000003L 0.1 171.76880000000003L 0.1 171.76880000000003Q 0.1 171.76880000000003 0.1 171.76880000000003L 0.1 134.96120000000002Q 0.1 134.96120000000002 0.1 134.96120000000002z" pathFrom="M 0.1 134.96120000000002L 0.1 134.96120000000002L 0.1 171.76880000000003L 0.1 171.76880000000003L 0.1 171.76880000000003L 0.1 171.76880000000003L 0.1 171.76880000000003L 0.1 134.96120000000002" cy="196.30720000000002" cx="220.8583984375" j="2" val="12375" barHeight="36.8076" barWidth="220.7583984375"></path><path id="SvgjsPath1848" d="M 0.1 196.30720000000002L 160.76631093749998 196.30720000000002Q 170.76631093749998 196.30720000000002 170.76631093749998 206.30720000000002L 170.76631093749998 223.11480000000003Q 170.76631093749998 233.11480000000003 160.76631093749998 233.11480000000003L 160.76631093749998 233.11480000000003L 0.1 233.11480000000003L 0.1 233.11480000000003Q 0.1 233.11480000000003 0.1 233.11480000000003L 0.1 196.30720000000002Q 0.1 196.30720000000002 0.1 196.30720000000002z" fill="rgba(38,198,249,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask3apn2jfb)" pathTo="M 0.1 196.30720000000002L 160.76631093749998 196.30720000000002Q 170.76631093749998 196.30720000000002 170.76631093749998 206.30720000000002L 170.76631093749998 223.11480000000003Q 170.76631093749998 233.11480000000003 160.76631093749998 233.11480000000003L 160.76631093749998 233.11480000000003L 0.1 233.11480000000003L 0.1 233.11480000000003Q 0.1 233.11480000000003 0.1 233.11480000000003L 0.1 196.30720000000002Q 0.1 196.30720000000002 0.1 196.30720000000002z" pathFrom="M 0.1 196.30720000000002L 0.1 196.30720000000002L 0.1 233.11480000000003L 0.1 233.11480000000003L 0.1 233.11480000000003L 0.1 233.11480000000003L 0.1 233.11480000000003L 0.1 196.30720000000002" cy="257.6532" cx="170.76631093749998" j="3" val="9567" barHeight="36.8076" barWidth="170.6663109375"></path><path id="SvgjsPath1854" d="M 0.1 257.6532L 130.6718125 257.6532Q 140.6718125 257.6532 140.6718125 267.6532L 140.6718125 284.4608Q 140.6718125 294.4608 130.6718125 294.4608L 130.6718125 294.4608L 0.1 294.4608L 0.1 294.4608Q 0.1 294.4608 0.1 294.4608L 0.1 257.6532Q 0.1 257.6532 0.1 257.6532z" fill="rgba(255,77,73,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask3apn2jfb)" pathTo="M 0.1 257.6532L 130.6718125 257.6532Q 140.6718125 257.6532 140.6718125 267.6532L 140.6718125 284.4608Q 140.6718125 294.4608 130.6718125 294.4608L 130.6718125 294.4608L 0.1 294.4608L 0.1 294.4608Q 0.1 294.4608 0.1 294.4608L 0.1 257.6532Q 0.1 257.6532 0.1 257.6532z" pathFrom="M 0.1 257.6532L 0.1 257.6532L 0.1 294.4608L 0.1 294.4608L 0.1 294.4608L 0.1 294.4608L 0.1 294.4608L 0.1 257.6532" cy="318.99920000000003" cx="140.6718125" j="4" val="7880" barHeight="36.8076" barWidth="140.5718125"></path><g id="SvgjsG1828" class="apexcharts-bar-goals-markers" style="pointer-events: none"><g id="SvgjsG1829" className="apexcharts-bar-goals-groups"></g><g id="SvgjsG1835" className="apexcharts-bar-goals-groups"></g><g id="SvgjsG1841" className="apexcharts-bar-goals-groups"></g><g id="SvgjsG1847" className="apexcharts-bar-goals-groups"></g><g id="SvgjsG1853" className="apexcharts-bar-goals-groups"></g></g></g><g id="SvgjsG1827" class="apexcharts-datalabels" data:realIndex="0"><g id="SvgjsG1832" class="apexcharts-data-labels" transform="rotate(0)"><text id="SvgjsText1834" font-family="Inter" x="13.100000000000023" y="36.173" text-anchor="start" dominant-baseline="auto" font-size="0.9375rem" font-weight="500" fill="#ffffff" class="apexcharts-datalabel" cx="13.100000000000023" cy="36.173" style="font-family: Inter;">17165</text></g><g id="SvgjsG1838" class="apexcharts-data-labels" transform="rotate(0)"><text id="SvgjsText1840" font-family="Inter" x="13.099999999999994" y="97.51900000000002" text-anchor="start" dominant-baseline="auto" font-size="0.9375rem" font-weight="500" fill="#ffffff" class="apexcharts-datalabel" cx="13.099999999999994" cy="97.51900000000002" style="font-family: Inter;">13850</text></g><g id="SvgjsG1844" class="apexcharts-data-labels" transform="rotate(0)"><text id="SvgjsText1846" font-family="Inter" x="13.099999999999994" y="158.865" text-anchor="start" dominant-baseline="auto" font-size="0.9375rem" font-weight="500" fill="#ffffff" class="apexcharts-datalabel" cx="13.099999999999994" cy="158.865" style="font-family: Inter;">12375</text></g><g id="SvgjsG1850" class="apexcharts-data-labels" transform="rotate(0)"><text id="SvgjsText1852" font-family="Inter" x="13.099999999999994" y="220.211" text-anchor="start" dominant-baseline="auto" font-size="0.9375rem" font-weight="500" fill="#ffffff" class="apexcharts-datalabel" cx="13.099999999999994" cy="220.211" style="font-family: Inter;">9567</text></g><g id="SvgjsG1856" class="apexcharts-data-labels" transform="rotate(0)"><text id="SvgjsText1858" font-family="Inter" x="13.099999999999994" y="281.557" text-anchor="start" dominant-baseline="auto" font-size="0.9375rem" font-weight="500" fill="#ffffff" class="apexcharts-datalabel" cx="13.099999999999994" cy="281.557" style="font-family: Inter;">7880</text></g></g></g><line id="SvgjsLine1902" x1="0" y1="0" x2="356.78125" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1903" x1="0" y1="0" x2="356.78125" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG1904" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG1905" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG1906" class="apexcharts-point-annotations"></g></g><g id="SvgjsG1815" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend" style="max-height: 184px;"></div></div></div>
                  <div class="resize-triggers"><div class="expand-trigger"><div style="width: 448px; height: 410px;"></div></div><div class="contract-trigger"></div></div></div>
                </div>
              </div>
              <!--/ Sales Country Chart -->

              <!-- Top Referral Source  -->
              <div class="col-12 col-xxl-8">
                <div class="card h-100">
                  <div class="card-header d-flex justify-content-between">
                    <div>
                      <h5 class="card-title mb-1">Top Referral Sources</h5>
                      <p class="card-subtitle mb-0">Number of Sales</p>
                    </div>
                    <div class="dropdown">
                      <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-1 waves-effect waves-light" type="button" id="earningReportsTabsId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ri-more-2-line ri-20px"></i>
                      </button>
                      <div class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReportsTabsId">
                        <a class="dropdown-item waves-effect" href="javascript:void(0);">View More</a>
                        <a class="dropdown-item waves-effect" href="javascript:void(0);">Delete</a>
                      </div>
                    </div>
                  </div>
                  <div class="card-body pb-0">
                    <ul class="nav nav-tabs nav-tabs-widget pb-6 gap-4 mx-1 d-flex flex-nowrap" role="tablist">
                      <li class="nav-item" role="presentation">
                        <a href="javascript:void(0);" class="nav-link btn active d-flex flex-column align-items-center justify-content-center" role="tab" data-bs-toggle="tab" data-bs-target="#navs-orders-id" aria-controls="navs-orders-id" aria-selected="true">
                          <div class="avatar avatar-sm">
                            <img src="../../assets/img/icons/brands/google.png" alt="User">
                          </div>
                        </a>
                      </li>
                      <li class="nav-item" role="presentation">
                        <a href="javascript:void(0);" class="nav-link btn d-flex flex-column align-items-center justify-content-center" role="tab" data-bs-toggle="tab" data-bs-target="#navs-sales-id" aria-controls="navs-sales-id" aria-selected="false" tabindex="-1">
                          <div class="avatar avatar-sm">
                            <img src="../../assets/img/icons/brands/facebook-rounded.png" alt="User">
                          </div>
                        </a>
                      </li>
                      <li class="nav-item" role="presentation">
                        <a href="javascript:void(0);" class="nav-link btn d-flex flex-column align-items-center justify-content-center" role="tab" data-bs-toggle="tab" data-bs-target="#navs-profit-id" aria-controls="navs-profit-id" aria-selected="false" tabindex="-1">
                          <div class="avatar avatar-sm">
                            <img src="../../assets/img/icons/brands/instagram-rounded.png" alt="User">
                          </div>
                        </a>
                      </li>
                      <li class="nav-item" role="presentation">
                        <a href="javascript:void(0);" class="nav-link btn d-flex flex-column align-items-center justify-content-center" role="tab" data-bs-toggle="tab" data-bs-target="#navs-income-id" aria-controls="navs-income-id" aria-selected="false" tabindex="-1">
                          <div class="avatar avatar-sm">
                            <img src="../../assets/img/icons/brands/reddit-rounded.png" alt="User">
                          </div>
                        </a>
                      </li>
                      <li class="nav-item" role="presentation">
                        <a href="javascript:void(0);" class="nav-link btn d-flex align-items-center justify-content-center disabled" role="tab" data-bs-toggle="tab" aria-selected="false" tabindex="-1">
                          <div class="avatar avatar-sm">
                            <div class="avatar-initial bg-label-secondary text-body rounded">
                              <i class="ri-add-line ri-22px"></i>
                            </div>
                          </div>
                        </a>
                      </li>
                    <span class="tab-slider" style="left: 0px; width: 96px; bottom: 0px;"></span></ul>
                  </div>
                  <div class="tab-content p-0">
                    <div class="tab-pane fade show active" id="navs-orders-id" role="tabpanel">
                      <div class="table-responsive text-nowrap">
                        <table class="table border-top">
                          <thead>
                            <tr>
                              <th class="bg-transparent border-bottom">Product Name</th>
                              <th class="bg-transparent border-bottom">STATUS</th>
                              <th class="text-end bg-transparent border-bottom">Profit</th>
                              <th class="text-end bg-transparent border-bottom">REVENUE</th>
                            </tr>
                          </thead>
                          <tbody class="table-border-bottom-0">
                            <tr>
                              <td>Email Marketing Campaign</td>
                              <td>
                                <div class="badge bg-label-primary rounded-pill">Active</div>
                              </td>
                              <td class="text-success fw-medium text-end">+24%</td>
                              <td class="text-end fw-medium">$42,857</td>
                            </tr>
                            <tr>
                              <td>Google Workspace</td>
                              <td>
                                <div class="badge bg-label-success rounded-pill">Completed</div>
                              </td>
                              <td class="text-danger fw-medium text-end">-12%</td>
                              <td class="text-end fw-medium">$850</td>
                            </tr>
                            <tr>
                              <td>Affiliation Program</td>
                              <td>
                                <div class="badge bg-label-primary rounded-pill">Active</div>
                              </td>
                              <td class="text-success fw-medium text-end">+24%</td>
                              <td class="text-end fw-medium">$5,576</td>
                            </tr>
                            <tr>
                              <td>Google Adsense</td>
                              <td>
                                <div class="badge bg-label-info rounded-pill">In Draft</div>
                              </td>
                              <td class="text-success fw-medium text-end">+0%</td>
                              <td class="text-end fw-medium">0</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="navs-sales-id" role="tabpanel">
                      <div class="table-responsive text-nowrap">
                        <table class="table border-top">
                          <thead>
                            <tr>
                              <th class="bg-transparent border-bottom">Product Name</th>
                              <th class="bg-transparent border-bottom">STATUS</th>
                              <th class="text-end bg-transparent border-bottom">Profit</th>
                              <th class="text-end bg-transparent border-bottom">REVENUE</th>
                            </tr>
                          </thead>
                          <tbody class="table-border-bottom-0">
                            <tr>
                              <td>facebook Adsense</td>
                              <td>
                                <div class="badge bg-label-info rounded-pill">In Draft</div>
                              </td>
                              <td class="text-success fw-medium text-end">+5%</td>
                              <td class="text-end fw-medium">$5</td>
                            </tr>
                            <tr>
                              <td>Affiliation Program</td>
                              <td>
                                <div class="badge bg-label-primary rounded-pill">Active</div>
                              </td>
                              <td class="text-danger fw-medium text-end">-24%</td>
                              <td class="text-end fw-medium">$5,576</td>
                            </tr>
                            <tr>
                              <td>Email Marketing Campaign</td>
                              <td>
                                <div class="badge bg-label-warning rounded-pill">warning</div>
                              </td>
                              <td class="text-success fw-medium text-end">+5%</td>
                              <td class="text-end fw-medium">$2,857</td>
                            </tr>
                            <tr>
                              <td>facebook Workspace</td>
                              <td>
                                <div class="badge bg-label-success rounded-pill">Completed</div>
                              </td>
                              <td class="text-danger fw-medium text-end">-12%</td>
                              <td class="text-end fw-medium">$850</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="navs-profit-id" role="tabpanel">
                      <div class="table-responsive text-nowrap">
                        <table class="table border-top">
                          <thead>
                            <tr>
                              <th class="bg-transparent border-bottom">Product Name</th>
                              <th class="bg-transparent border-bottom">STATUS</th>
                              <th class="text-end bg-transparent border-bottom">Profit</th>
                              <th class="text-end bg-transparent border-bottom">REVENUE</th>
                            </tr>
                          </thead>
                          <tbody class="table-border-bottom-0">
                            <tr>
                              <td>Affiliation Program</td>
                              <td>
                                <div class="badge bg-label-primary rounded-pill">Active</div>
                              </td>
                              <td class="text-danger fw-medium text-end">-24%</td>
                              <td class="text-end fw-medium">$5,576</td>
                            </tr>
                            <tr>
                              <td>instagram Adsense</td>
                              <td>
                                <div class="badge bg-label-info rounded-pill">In Draft</div>
                              </td>
                              <td class="text-success fw-medium text-end">+5%</td>
                              <td class="text-end fw-medium">$5</td>
                            </tr>
                            <tr>
                              <td>instagram Workspace</td>
                              <td>
                                <div class="badge bg-label-success rounded-pill">Completed</div>
                              </td>
                              <td class="text-danger fw-medium text-end">-12%</td>
                              <td class="text-end fw-medium">$850</td>
                            </tr>
                            <tr>
                              <td>Email Marketing Campaign</td>
                              <td>
                                <div class="badge bg-label-danger rounded-pill">warning</div>
                              </td>
                              <td class="text-danger fw-medium text-end">-5%</td>
                              <td class="text-end fw-medium">$857</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="navs-income-id" role="tabpanel">
                      <div class="table-responsive text-nowrap">
                        <table class="table border-top">
                          <thead>
                            <tr>
                              <th class="bg-transparent border-bottom">Product Name</th>
                              <th class="bg-transparent border-bottom">STATUS</th>
                              <th class="text-end bg-transparent border-bottom">Profit</th>
                              <th class="text-end bg-transparent border-bottom">REVENUE</th>
                            </tr>
                          </thead>
                          <tbody class="table-border-bottom-0">
                            <tr>
                              <td>reddit Workspace</td>
                              <td>
                                <div class="badge bg-label-warning rounded-pill">process</div>
                              </td>
                              <td class="text-danger fw-medium text-end">-12%</td>
                              <td class="text-end fw-medium">$850</td>
                            </tr>
                            <tr>
                              <td>Affiliation Program</td>
                              <td>
                                <div class="badge bg-label-primary rounded-pill">Active</div>
                              </td>
                              <td class="text-danger fw-medium text-end">-24%</td>
                              <td class="text-end fw-medium">$5,576</td>
                            </tr>
                            <tr>
                              <td>reddit Adsense</td>
                              <td>
                                <div class="badge bg-label-info rounded-pill">In Draft</div>
                              </td>
                              <td class="text-success fw-medium text-end">+5%</td>
                              <td class="text-end fw-medium">$5</td>
                            </tr>
                            <tr>
                              <td>Email Marketing Campaign</td>
                              <td>
                                <div class="badge bg-label-success rounded-pill">Completed</div>
                              </td>
                              <td class="text-success fw-medium text-end">+50%</td>
                              <td class="text-end fw-medium">$857</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!--/ Top Referral Source  -->

              <!-- Weekly Sales Chart-->
              <div class="col-12 col-xxl-4 col-md-6">
                <div class="card h-100">
                  <div class="card-header">
                    <div class="d-flex justify-content-between">
                      <h5 class="mb-1">Weekly Sales</h5>
                      <div class="dropdown">
                        <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-1 waves-effect waves-light" type="button" id="weeklySalesDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="ri-more-2-line ri-20px"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="weeklySalesDropdown">
                          <a class="dropdown-item waves-effect" href="javascript:void(0);">Refresh</a>
                          <a class="dropdown-item waves-effect" href="javascript:void(0);">Update</a>
                          <a class="dropdown-item waves-effect" href="javascript:void(0);">Share</a>
                        </div>
                      </div>
                    </div>
                    <p class="mb-0 card-subtitle">Total 85.4k Sales</p>
                  </div>
                  <div class="card-body" style="position: relative;">
                    <div class="row mb-7 mb-xl-12">
                      <div class="col-6 d-flex align-items-center">
                        <div class="avatar">
                          <div class="avatar-initial bg-label-primary rounded">
                            <i class="ri-funds-line ri-24px"></i>
                          </div>
                        </div>
                        <div class="ms-3 d-flex flex-column">
                          <p class="mb-0">Net Income</p>
                          <h6 class="mb-0">$438.5K</h6>
                        </div>
                      </div>
                      <div class="col-6 d-flex align-items-center">
                        <div class="avatar">
                          <div class="avatar-initial bg-label-warning rounded">
                            <i class="ri-money-dollar-circle-line ri-24px"></i>
                          </div>
                        </div>
                        <div class="ms-3 d-flex flex-column">
                          <p class="mb-0">Expense</p>
                          <h6 class="mb-0">$22.4K</h6>
                        </div>
                      </div>
                    </div>
                    <div id="weeklySalesChart" style="min-height: 261px;"><div id="apexchartsxxil8610g" class="apexcharts-canvas apexchartsxxil8610g apexcharts-theme-light" style="width: 407px; height: 261px;"><svg id="SvgjsSvg1907" width="407" height="261" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg apexcharts-zoomable" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG1909" class="apexcharts-inner apexcharts-graphical" transform="translate(29.070217285156247, 2)"><defs id="SvgjsDefs1908"><clipPath id="gridRectMaskxxil8610g"><rect id="SvgjsRect1914" width="418.63500976562506" height="227.73" x="-34.57021728515625" y="-1.5" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="forecastMaskxxil8610g"></clipPath><clipPath id="nonForecastMaskxxil8610g"></clipPath><clipPath id="gridRectMarkerMaskxxil8610g"><rect id="SvgjsRect1915" width="369.4945751953125" height="244.73" x="-10" y="-10" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><line id="SvgjsLine1913" x1="0" y1="0" x2="0" y2="224.73" stroke="#b6b6b6" stroke-dasharray="3" stroke-linecap="butt" class="apexcharts-xcrosshairs" x="0" y="0" width="1" height="224.73" fill="#b1b9c4" filter="none" fill-opacity="0.9" stroke-width="1"></line><g id="SvgjsG1953" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG1954" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"><text id="SvgjsText1956" font-family="Inter" x="0" y="253.73" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#7b7d95" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Inter;"><tspan id="SvgjsTspan1957">Jan</tspan><title>Jan</title></text><text id="SvgjsText1959" font-family="Inter" x="58.24909586588542" y="253.73" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#7b7d95" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Inter;"><tspan id="SvgjsTspan1960">Feb</tspan><title>Feb</title></text><text id="SvgjsText1962" font-family="Inter" x="116.49819173177085" y="253.73" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#7b7d95" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Inter;"><tspan id="SvgjsTspan1963">Mar</tspan><title>Mar</title></text><text id="SvgjsText1965" font-family="Inter" x="174.74728759765625" y="253.73" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#7b7d95" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Inter;"><tspan id="SvgjsTspan1966">Apr</tspan><title>Apr</title></text><text id="SvgjsText1968" font-family="Inter" x="232.99638346354166" y="253.73" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#7b7d95" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Inter;"><tspan id="SvgjsTspan1969">May</tspan><title>May</title></text><text id="SvgjsText1971" font-family="Inter" x="291.24547932942704" y="253.73" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#7b7d95" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Inter;"><tspan id="SvgjsTspan1972">Jun</tspan><title>Jun</title></text><text id="SvgjsText1974" font-family="Inter" x="349.49457519531245" y="253.73" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#7b7d95" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Inter;"><tspan id="SvgjsTspan1975">Jul</tspan><title>Jul</title></text></g></g><g id="SvgjsG1977" class="apexcharts-grid"><g id="SvgjsG1978" class="apexcharts-gridlines-horizontal"></g><g id="SvgjsG1979" class="apexcharts-gridlines-vertical"></g><line id="SvgjsLine1981" x1="0" y1="224.73" x2="349.4945751953125" y2="224.73" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line><line id="SvgjsLine1980" x1="0" y1="1" x2="0" y2="224.73" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line></g><g id="SvgjsG1916" class="apexcharts-bar-series apexcharts-plot-series"><g id="SvgjsG1917" class="apexcharts-series" seriesName="Earning" rel="1" data:realIndex="0"><path id="SvgjsPath1919" d="M -16.600992321777344 112.365L -16.600992321777344 19.236499999999992Q -16.600992321777344 11.236499999999992 -8.600992321777344 11.236499999999992L 8.600992321777344 11.236499999999992Q 16.600992321777344 11.236499999999992 16.600992321777344 19.236499999999992L 16.600992321777344 19.236499999999992L 16.600992321777344 112.365Q 16.600992321777344 112.365 16.600992321777344 112.365L -16.600992321777344 112.365Q -16.600992321777344 112.365 -16.600992321777344 112.365z" fill="rgba(102,108,255,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskxxil8610g)" pathTo="M -16.600992321777344 112.365L -16.600992321777344 19.236499999999992Q -16.600992321777344 11.236499999999992 -8.600992321777344 11.236499999999992L 8.600992321777344 11.236499999999992Q 16.600992321777344 11.236499999999992 16.600992321777344 19.236499999999992L 16.600992321777344 19.236499999999992L 16.600992321777344 112.365Q 16.600992321777344 112.365 16.600992321777344 112.365L -16.600992321777344 112.365Q -16.600992321777344 112.365 -16.600992321777344 112.365z" pathFrom="M -16.600992321777344 112.365L -16.600992321777344 112.365L 16.600992321777344 112.365L 16.600992321777344 112.365L 16.600992321777344 112.365L 16.600992321777344 112.365L 16.600992321777344 112.365L -16.600992321777344 112.365" cy="11.236499999999992" cx="16.60099232177734" j="0" val="90" barHeight="101.1285" barWidth="33.20198464355469"></path><path id="SvgjsPath1920" d="M 41.64810354410807 112.365L 41.64810354410807 61.935199999999995Q 41.64810354410807 53.935199999999995 49.64810354410807 53.935199999999995L 66.85008818766275 53.935199999999995Q 74.85008818766275 53.935199999999995 74.85008818766275 61.935199999999995L 74.85008818766275 61.935199999999995L 74.85008818766275 112.365Q 74.85008818766275 112.365 74.85008818766275 112.365L 41.64810354410807 112.365Q 41.64810354410807 112.365 41.64810354410807 112.365z" fill="rgba(102,108,255,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskxxil8610g)" pathTo="M 41.64810354410807 112.365L 41.64810354410807 61.935199999999995Q 41.64810354410807 53.935199999999995 49.64810354410807 53.935199999999995L 66.85008818766275 53.935199999999995Q 74.85008818766275 53.935199999999995 74.85008818766275 61.935199999999995L 74.85008818766275 61.935199999999995L 74.85008818766275 112.365Q 74.85008818766275 112.365 74.85008818766275 112.365L 41.64810354410807 112.365Q 41.64810354410807 112.365 41.64810354410807 112.365z" pathFrom="M 41.64810354410807 112.365L 41.64810354410807 112.365L 74.85008818766275 112.365L 74.85008818766275 112.365L 74.85008818766275 112.365L 74.85008818766275 112.365L 74.85008818766275 112.365L 41.64810354410807 112.365" cy="53.935199999999995" cx="74.85008818766275" j="1" val="52" barHeight="58.4298" barWidth="33.20198464355469"></path><path id="SvgjsPath1921" d="M 99.89719940999349 112.365L 99.89719940999349 45.08045Q 99.89719940999349 37.08045 107.89719940999349 37.08045L 125.09918405354819 37.08045Q 133.09918405354819 37.08045 133.09918405354819 45.08045L 133.09918405354819 45.08045L 133.09918405354819 112.365Q 133.09918405354819 112.365 133.09918405354819 112.365L 99.89719940999349 112.365Q 99.89719940999349 112.365 99.89719940999349 112.365z" fill="rgba(102,108,255,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskxxil8610g)" pathTo="M 99.89719940999349 112.365L 99.89719940999349 45.08045Q 99.89719940999349 37.08045 107.89719940999349 37.08045L 125.09918405354819 37.08045Q 133.09918405354819 37.08045 133.09918405354819 45.08045L 133.09918405354819 45.08045L 133.09918405354819 112.365Q 133.09918405354819 112.365 133.09918405354819 112.365L 99.89719940999349 112.365Q 99.89719940999349 112.365 99.89719940999349 112.365z" pathFrom="M 99.89719940999349 112.365L 99.89719940999349 112.365L 133.09918405354819 112.365L 133.09918405354819 112.365L 133.09918405354819 112.365L 133.09918405354819 112.365L 133.09918405354819 112.365L 99.89719940999349 112.365" cy="37.08045" cx="133.09918405354819" j="2" val="67" barHeight="75.28455" barWidth="33.20198464355469"></path><path id="SvgjsPath1922" d="M 158.1462952758789 112.365L 158.1462952758789 69.80075Q 158.1462952758789 61.800749999999994 166.1462952758789 61.800749999999994L 183.3482799194336 61.800749999999994Q 191.3482799194336 61.800749999999994 191.3482799194336 69.80075L 191.3482799194336 69.80075L 191.3482799194336 112.365Q 191.3482799194336 112.365 191.3482799194336 112.365L 158.1462952758789 112.365Q 158.1462952758789 112.365 158.1462952758789 112.365z" fill="rgba(102,108,255,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskxxil8610g)" pathTo="M 158.1462952758789 112.365L 158.1462952758789 69.80075Q 158.1462952758789 61.800749999999994 166.1462952758789 61.800749999999994L 183.3482799194336 61.800749999999994Q 191.3482799194336 61.800749999999994 191.3482799194336 69.80075L 191.3482799194336 69.80075L 191.3482799194336 112.365Q 191.3482799194336 112.365 191.3482799194336 112.365L 158.1462952758789 112.365Q 158.1462952758789 112.365 158.1462952758789 112.365z" pathFrom="M 158.1462952758789 112.365L 158.1462952758789 112.365L 191.3482799194336 112.365L 191.3482799194336 112.365L 191.3482799194336 112.365L 191.3482799194336 112.365L 191.3482799194336 112.365L 158.1462952758789 112.365" cy="61.800749999999994" cx="191.3482799194336" j="3" val="45" barHeight="50.56425" barWidth="33.20198464355469"></path><path id="SvgjsPath1923" d="M 216.39539114176432 112.365L 216.39539114176432 36.09125Q 216.39539114176432 28.091250000000002 224.39539114176432 28.091250000000002L 241.597375785319 28.091250000000002Q 249.597375785319 28.091250000000002 249.597375785319 36.09125L 249.597375785319 36.09125L 249.597375785319 112.365Q 249.597375785319 112.365 249.597375785319 112.365L 216.39539114176432 112.365Q 216.39539114176432 112.365 216.39539114176432 112.365z" fill="rgba(102,108,255,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskxxil8610g)" pathTo="M 216.39539114176432 112.365L 216.39539114176432 36.09125Q 216.39539114176432 28.091250000000002 224.39539114176432 28.091250000000002L 241.597375785319 28.091250000000002Q 249.597375785319 28.091250000000002 249.597375785319 36.09125L 249.597375785319 36.09125L 249.597375785319 112.365Q 249.597375785319 112.365 249.597375785319 112.365L 216.39539114176432 112.365Q 216.39539114176432 112.365 216.39539114176432 112.365z" pathFrom="M 216.39539114176432 112.365L 216.39539114176432 112.365L 249.597375785319 112.365L 249.597375785319 112.365L 249.597375785319 112.365L 249.597375785319 112.365L 249.597375785319 112.365L 216.39539114176432 112.365" cy="28.091250000000002" cx="249.597375785319" j="4" val="75" barHeight="84.27374999999999" barWidth="33.20198464355469"></path><path id="SvgjsPath1924" d="M 274.6444870076497 112.365L 274.6444870076497 58.564249999999994Q 274.6444870076497 50.564249999999994 282.6444870076497 50.564249999999994L 299.84647165120435 50.564249999999994Q 307.84647165120435 50.564249999999994 307.84647165120435 58.564249999999994L 307.84647165120435 58.564249999999994L 307.84647165120435 112.365Q 307.84647165120435 112.365 307.84647165120435 112.365L 274.6444870076497 112.365Q 274.6444870076497 112.365 274.6444870076497 112.365z" fill="rgba(102,108,255,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskxxil8610g)" pathTo="M 274.6444870076497 112.365L 274.6444870076497 58.564249999999994Q 274.6444870076497 50.564249999999994 282.6444870076497 50.564249999999994L 299.84647165120435 50.564249999999994Q 307.84647165120435 50.564249999999994 307.84647165120435 58.564249999999994L 307.84647165120435 58.564249999999994L 307.84647165120435 112.365Q 307.84647165120435 112.365 307.84647165120435 112.365L 274.6444870076497 112.365Q 274.6444870076497 112.365 274.6444870076497 112.365z" pathFrom="M 274.6444870076497 112.365L 274.6444870076497 112.365L 307.84647165120435 112.365L 307.84647165120435 112.365L 307.84647165120435 112.365L 307.84647165120435 112.365L 307.84647165120435 112.365L 274.6444870076497 112.365" cy="50.564249999999994" cx="307.84647165120435" j="5" val="55" barHeight="61.80075" barWidth="33.20198464355469"></path><path id="SvgjsPath1925" d="M 332.89358287353514 112.365L 332.89358287353514 66.4298Q 332.89358287353514 58.4298 340.89358287353514 58.4298L 358.0955675170898 58.4298Q 366.0955675170898 58.4298 366.0955675170898 66.4298L 366.0955675170898 66.4298L 366.0955675170898 112.365Q 366.0955675170898 112.365 366.0955675170898 112.365L 332.89358287353514 112.365Q 332.89358287353514 112.365 332.89358287353514 112.365z" fill="rgba(102,108,255,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskxxil8610g)" pathTo="M 332.89358287353514 112.365L 332.89358287353514 66.4298Q 332.89358287353514 58.4298 340.89358287353514 58.4298L 358.0955675170898 58.4298Q 366.0955675170898 58.4298 366.0955675170898 66.4298L 366.0955675170898 66.4298L 366.0955675170898 112.365Q 366.0955675170898 112.365 366.0955675170898 112.365L 332.89358287353514 112.365Q 332.89358287353514 112.365 332.89358287353514 112.365z" pathFrom="M 332.89358287353514 112.365L 332.89358287353514 112.365L 366.0955675170898 112.365L 366.0955675170898 112.365L 366.0955675170898 112.365L 366.0955675170898 112.365L 366.0955675170898 112.365L 332.89358287353514 112.365" cy="58.4298" cx="366.0955675170898" j="6" val="48" barHeight="53.935199999999995" barWidth="33.20198464355469"></path></g><g id="SvgjsG1926" class="apexcharts-series" seriesName="Expense" rel="2" data:realIndex="1"><path id="SvgjsPath1928" d="M -16.600992321777344 120.365L -16.600992321777344 171.91845Q -16.600992321777344 179.91845 -8.600992321777344 179.91845L 8.600992321777344 179.91845Q 16.600992321777344 179.91845 16.600992321777344 171.91845L 16.600992321777344 171.91845L 16.600992321777344 120.365Q 16.600992321777344 120.365 16.600992321777344 120.365L -16.600992321777344 120.365Q -16.600992321777344 120.365 -16.600992321777344 120.365z" fill="#666cff29" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMaskxxil8610g)" pathTo="M -16.600992321777344 120.365L -16.600992321777344 171.91845Q -16.600992321777344 179.91845 -8.600992321777344 179.91845L 8.600992321777344 179.91845Q 16.600992321777344 179.91845 16.600992321777344 171.91845L 16.600992321777344 171.91845L 16.600992321777344 120.365Q 16.600992321777344 120.365 16.600992321777344 120.365L -16.600992321777344 120.365Q -16.600992321777344 120.365 -16.600992321777344 120.365z" pathFrom="M -16.600992321777344 120.365L -16.600992321777344 120.365L 16.600992321777344 120.365L 16.600992321777344 120.365L 16.600992321777344 120.365L 16.600992321777344 120.365L 16.600992321777344 120.365L -16.600992321777344 120.365" cy="163.91845" cx="16.60099232177734" j="0" val="-53" barHeight="-59.55345" barWidth="33.20198464355469"></path><path id="SvgjsPath1929" d="M 41.64810354410807 120.365L 41.64810354410807 144.95085Q 41.64810354410807 152.95085 49.64810354410807 152.95085L 66.85008818766275 152.95085Q 74.85008818766275 152.95085 74.85008818766275 144.95085L 74.85008818766275 144.95085L 74.85008818766275 120.365Q 74.85008818766275 120.365 74.85008818766275 120.365L 41.64810354410807 120.365Q 41.64810354410807 120.365 41.64810354410807 120.365z" fill="#666cff29" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMaskxxil8610g)" pathTo="M 41.64810354410807 120.365L 41.64810354410807 144.95085Q 41.64810354410807 152.95085 49.64810354410807 152.95085L 66.85008818766275 152.95085Q 74.85008818766275 152.95085 74.85008818766275 144.95085L 74.85008818766275 144.95085L 74.85008818766275 120.365Q 74.85008818766275 120.365 74.85008818766275 120.365L 41.64810354410807 120.365Q 41.64810354410807 120.365 41.64810354410807 120.365z" pathFrom="M 41.64810354410807 120.365L 41.64810354410807 120.365L 74.85008818766275 120.365L 74.85008818766275 120.365L 74.85008818766275 120.365L 74.85008818766275 120.365L 74.85008818766275 120.365L 41.64810354410807 120.365" cy="136.95085" cx="74.85008818766275" j="1" val="-29" barHeight="-32.58585" barWidth="33.20198464355469"></path><path id="SvgjsPath1930" d="M 99.89719940999349 120.365L 99.89719940999349 187.64954999999998Q 99.89719940999349 195.64954999999998 107.89719940999349 195.64954999999998L 125.09918405354819 195.64954999999998Q 133.09918405354819 195.64954999999998 133.09918405354819 187.64954999999998L 133.09918405354819 187.64954999999998L 133.09918405354819 120.365Q 133.09918405354819 120.365 133.09918405354819 120.365L 99.89719940999349 120.365Q 99.89719940999349 120.365 99.89719940999349 120.365z" fill="#666cff29" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMaskxxil8610g)" pathTo="M 99.89719940999349 120.365L 99.89719940999349 187.64954999999998Q 99.89719940999349 195.64954999999998 107.89719940999349 195.64954999999998L 125.09918405354819 195.64954999999998Q 133.09918405354819 195.64954999999998 133.09918405354819 187.64954999999998L 133.09918405354819 187.64954999999998L 133.09918405354819 120.365Q 133.09918405354819 120.365 133.09918405354819 120.365L 99.89719940999349 120.365Q 99.89719940999349 120.365 99.89719940999349 120.365z" pathFrom="M 99.89719940999349 120.365L 99.89719940999349 120.365L 133.09918405354819 120.365L 133.09918405354819 120.365L 133.09918405354819 120.365L 133.09918405354819 120.365L 133.09918405354819 120.365L 99.89719940999349 120.365" cy="179.64954999999998" cx="133.09918405354819" j="2" val="-67" barHeight="-75.28455" barWidth="33.20198464355469"></path><path id="SvgjsPath1931" d="M 158.1462952758789 120.365L 158.1462952758789 206.7516Q 158.1462952758789 214.7516 166.1462952758789 214.7516L 183.3482799194336 214.7516Q 191.3482799194336 214.7516 191.3482799194336 206.7516L 191.3482799194336 206.7516L 191.3482799194336 120.365Q 191.3482799194336 120.365 191.3482799194336 120.365L 158.1462952758789 120.365Q 158.1462952758789 120.365 158.1462952758789 120.365z" fill="#666cff29" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMaskxxil8610g)" pathTo="M 158.1462952758789 120.365L 158.1462952758789 206.7516Q 158.1462952758789 214.7516 166.1462952758789 214.7516L 183.3482799194336 214.7516Q 191.3482799194336 214.7516 191.3482799194336 206.7516L 191.3482799194336 206.7516L 191.3482799194336 120.365Q 191.3482799194336 120.365 191.3482799194336 120.365L 158.1462952758789 120.365Q 158.1462952758789 120.365 158.1462952758789 120.365z" pathFrom="M 158.1462952758789 120.365L 158.1462952758789 120.365L 191.3482799194336 120.365L 191.3482799194336 120.365L 191.3482799194336 120.365L 191.3482799194336 120.365L 191.3482799194336 120.365L 158.1462952758789 120.365" cy="198.7516" cx="191.3482799194336" j="3" val="-84" barHeight="-94.3866" barWidth="33.20198464355469"></path><path id="SvgjsPath1932" d="M 216.39539114176432 120.365L 216.39539114176432 179.784Q 216.39539114176432 187.784 224.39539114176432 187.784L 241.597375785319 187.784Q 249.597375785319 187.784 249.597375785319 179.784L 249.597375785319 179.784L 249.597375785319 120.365Q 249.597375785319 120.365 249.597375785319 120.365L 216.39539114176432 120.365Q 216.39539114176432 120.365 216.39539114176432 120.365z" fill="#666cff29" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMaskxxil8610g)" pathTo="M 216.39539114176432 120.365L 216.39539114176432 179.784Q 216.39539114176432 187.784 224.39539114176432 187.784L 241.597375785319 187.784Q 249.597375785319 187.784 249.597375785319 179.784L 249.597375785319 179.784L 249.597375785319 120.365Q 249.597375785319 120.365 249.597375785319 120.365L 216.39539114176432 120.365Q 216.39539114176432 120.365 216.39539114176432 120.365z" pathFrom="M 216.39539114176432 120.365L 216.39539114176432 120.365L 249.597375785319 120.365L 249.597375785319 120.365L 249.597375785319 120.365L 249.597375785319 120.365L 249.597375785319 120.365L 216.39539114176432 120.365" cy="171.784" cx="249.597375785319" j="4" val="-60" barHeight="-67.419" barWidth="33.20198464355469"></path><path id="SvgjsPath1933" d="M 274.6444870076497 120.365L 274.6444870076497 157.31099999999998Q 274.6444870076497 165.31099999999998 282.6444870076497 165.31099999999998L 299.84647165120435 165.31099999999998Q 307.84647165120435 165.31099999999998 307.84647165120435 157.31099999999998L 307.84647165120435 157.31099999999998L 307.84647165120435 120.365Q 307.84647165120435 120.365 307.84647165120435 120.365L 274.6444870076497 120.365Q 274.6444870076497 120.365 274.6444870076497 120.365z" fill="#666cff29" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMaskxxil8610g)" pathTo="M 274.6444870076497 120.365L 274.6444870076497 157.31099999999998Q 274.6444870076497 165.31099999999998 282.6444870076497 165.31099999999998L 299.84647165120435 165.31099999999998Q 307.84647165120435 165.31099999999998 307.84647165120435 157.31099999999998L 307.84647165120435 157.31099999999998L 307.84647165120435 120.365Q 307.84647165120435 120.365 307.84647165120435 120.365L 274.6444870076497 120.365Q 274.6444870076497 120.365 274.6444870076497 120.365z" pathFrom="M 274.6444870076497 120.365L 274.6444870076497 120.365L 307.84647165120435 120.365L 307.84647165120435 120.365L 307.84647165120435 120.365L 307.84647165120435 120.365L 307.84647165120435 120.365L 274.6444870076497 120.365" cy="149.31099999999998" cx="307.84647165120435" j="5" val="-40" barHeight="-44.946" barWidth="33.20198464355469"></path><path id="SvgjsPath1934" d="M 332.89358287353514 120.365L 332.89358287353514 198.88605Q 332.89358287353514 206.88605 340.89358287353514 206.88605L 358.0955675170898 206.88605Q 366.0955675170898 206.88605 366.0955675170898 198.88605L 366.0955675170898 198.88605L 366.0955675170898 120.365Q 366.0955675170898 120.365 366.0955675170898 120.365L 332.89358287353514 120.365Q 332.89358287353514 120.365 332.89358287353514 120.365z" fill="#666cff29" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMaskxxil8610g)" pathTo="M 332.89358287353514 120.365L 332.89358287353514 198.88605Q 332.89358287353514 206.88605 340.89358287353514 206.88605L 358.0955675170898 206.88605Q 366.0955675170898 206.88605 366.0955675170898 198.88605L 366.0955675170898 198.88605L 366.0955675170898 120.365Q 366.0955675170898 120.365 366.0955675170898 120.365L 332.89358287353514 120.365Q 332.89358287353514 120.365 332.89358287353514 120.365z" pathFrom="M 332.89358287353514 120.365L 332.89358287353514 120.365L 366.0955675170898 120.365L 366.0955675170898 120.365L 366.0955675170898 120.365L 366.0955675170898 120.365L 366.0955675170898 120.365L 332.89358287353514 120.365" cy="190.88605" cx="366.0955675170898" j="6" val="-77" barHeight="-86.52105" barWidth="33.20198464355469"></path></g></g><g id="SvgjsG1935" class="apexcharts-line-series apexcharts-plot-series"><g id="SvgjsG1936" class="apexcharts-series" seriesName="Expense" data:longestSeries="true" rel="1" data:realIndex="2"><path id="SvgjsPath1952" d="M 0 30.338549999999998C 20.387183553059895 30.338549999999998 37.861912312825524 89.892 58.249095865885415 89.892C 78.6362794189453 89.892 96.11100817871093 56.1825 116.49819173177083 56.1825C 136.88537528483073 56.1825 154.36010404459637 134.838 174.74728759765625 134.838C 195.13447115071614 134.838 212.60919991048178 47.193299999999994 232.99638346354166 47.193299999999994C 253.38356701660155 47.193299999999994 270.8582957763672 95.51025 291.24547932942704 95.51025C 311.63266288248695 95.51025 329.1073916422526 77.53184999999999 349.4945751953125 77.53184999999999" fill="none" fill-opacity="1" stroke="rgba(253,181,40,0.85)" stroke-opacity="1" stroke-linecap="butt" stroke-width="3" stroke-dasharray="0" class="apexcharts-line" index="2" clip-path="url(#gridRectMaskxxil8610g)" pathTo="M 0 30.338549999999998C 20.387183553059895 30.338549999999998 37.861912312825524 89.892 58.249095865885415 89.892C 78.6362794189453 89.892 96.11100817871093 56.1825 116.49819173177083 56.1825C 136.88537528483073 56.1825 154.36010404459637 134.838 174.74728759765625 134.838C 195.13447115071614 134.838 212.60919991048178 47.193299999999994 232.99638346354166 47.193299999999994C 253.38356701660155 47.193299999999994 270.8582957763672 95.51025 291.24547932942704 95.51025C 311.63266288248695 95.51025 329.1073916422526 77.53184999999999 349.4945751953125 77.53184999999999" pathFrom="M -1 112.365L -1 112.365L 58.249095865885415 112.365L 116.49819173177083 112.365L 174.74728759765625 112.365L 232.99638346354166 112.365L 291.24547932942704 112.365L 349.4945751953125 112.365"></path><g id="SvgjsG1937" class="apexcharts-series-markers-wrap" data:realIndex="2"><g id="SvgjsG1939" class="apexcharts-series-markers" clip-path="url(#gridRectMarkerMaskxxil8610g)"><circle id="SvgjsCircle1940" r="4" cx="0" cy="30.338549999999998" class="apexcharts-marker whgs24yvwf" stroke="#fdb528" fill="#30334e" fill-opacity="1" stroke-width="3" stroke-opacity="1" rel="0" j="0" index="2" default-marker-size="4"></circle><circle id="SvgjsCircle1941" r="4" cx="58.249095865885415" cy="89.892" class="apexcharts-marker wy9kt2knq" stroke="#fdb528" fill="#30334e" fill-opacity="1" stroke-width="3" stroke-opacity="1" rel="1" j="1" index="2" default-marker-size="4"></circle></g><g id="SvgjsG1942" class="apexcharts-series-markers" clip-path="url(#gridRectMarkerMaskxxil8610g)"><circle id="SvgjsCircle1943" r="4" cx="116.49819173177083" cy="56.1825" class="apexcharts-marker w0h9lk13b" stroke="#fdb528" fill="#30334e" fill-opacity="1" stroke-width="3" stroke-opacity="1" rel="2" j="2" index="2" default-marker-size="4"></circle></g><g id="SvgjsG1944" class="apexcharts-series-markers" clip-path="url(#gridRectMarkerMaskxxil8610g)"><circle id="SvgjsCircle1945" r="4" cx="174.74728759765625" cy="134.838" class="apexcharts-marker w4z6s236t" stroke="#fdb528" fill="#30334e" fill-opacity="1" stroke-width="3" stroke-opacity="1" rel="3" j="3" index="2" default-marker-size="4"></circle></g><g id="SvgjsG1946" class="apexcharts-series-markers" clip-path="url(#gridRectMarkerMaskxxil8610g)"><circle id="SvgjsCircle1947" r="4" cx="232.99638346354166" cy="47.193299999999994" class="apexcharts-marker wu5aamw08" stroke="#fdb528" fill="#30334e" fill-opacity="1" stroke-width="3" stroke-opacity="1" rel="4" j="4" index="2" default-marker-size="4"></circle></g><g id="SvgjsG1948" class="apexcharts-series-markers" clip-path="url(#gridRectMarkerMaskxxil8610g)"><circle id="SvgjsCircle1949" r="4" cx="291.24547932942704" cy="95.51025" class="apexcharts-marker ww5joskam" stroke="#fdb528" fill="#30334e" fill-opacity="1" stroke-width="3" stroke-opacity="1" rel="5" j="5" index="2" default-marker-size="4"></circle></g><g id="SvgjsG1950" class="apexcharts-series-markers" clip-path="url(#gridRectMarkerMaskxxil8610g)"><circle id="SvgjsCircle1951" r="4" cx="349.4945751953125" cy="77.53184999999999" class="apexcharts-marker w1mbeh0ni" stroke="#fdb528" fill="#30334e" fill-opacity="1" stroke-width="3" stroke-opacity="1" rel="6" j="6" index="2" default-marker-size="4"></circle></g></g></g><g id="SvgjsG1918" class="apexcharts-datalabels" data:realIndex="0"></g><g id="SvgjsG1927" class="apexcharts-datalabels" data:realIndex="1"></g><g id="SvgjsG1938" class="apexcharts-datalabels" data:realIndex="2"></g></g><line id="SvgjsLine1982" x1="-31.07021728515625" y1="0" x2="380.5647924804688" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1983" x1="-31.07021728515625" y1="0" x2="380.5647924804688" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG1984" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG1985" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG1986" class="apexcharts-point-annotations"></g><rect id="SvgjsRect1987" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe" class="apexcharts-zoom-rect"></rect><rect id="SvgjsRect1988" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe" class="apexcharts-selection-rect"></rect></g><rect id="SvgjsRect1912" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe"></rect><g id="SvgjsG1976" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g><g id="SvgjsG1910" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend" style="max-height: 130.5px;"></div></div></div>
                  <div class="resize-triggers"><div class="expand-trigger"><div style="width: 448px; height: 373px;"></div></div><div class="contract-trigger"></div></div></div>
                </div>
              </div>
              <!--/ Weekly Sales Chart-->

              <!-- visits By Day Chart-->
              <div class="col-12 col-xxl-4 col-md-6">
                <div class="card h-100">
                  <div class="card-header">
                    <div class="d-flex justify-content-between">
                      <h5 class="mb-1">Visits by Day</h5>
                      <div class="dropdown">
                        <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-1 waves-effect waves-light" type="button" id="visitsByDayDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="ri-more-2-line ri-20px"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="visitsByDayDropdown">
                          <a class="dropdown-item waves-effect" href="javascript:void(0);">Refresh</a>
                          <a class="dropdown-item waves-effect" href="javascript:void(0);">Update</a>
                          <a class="dropdown-item waves-effect" href="javascript:void(0);">Share</a>
                        </div>
                      </div>
                    </div>
                    <p class="mb-0 card-subtitle">Total 248.5k Visits</p>
                  </div>
                  <div class="card-body pt-xl-5" style="position: relative;">
                    <div id="visitsByDayChart" style="min-height: 238px;"><div id="apexchartst4y8pdqd" class="apexcharts-canvas apexchartst4y8pdqd apexcharts-theme-light" style="width: 407px; height: 238px;"><svg id="SvgjsSvg1989" width="407" height="238" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG1991" class="apexcharts-inner apexcharts-graphical" transform="translate(-7, 15)"><defs id="SvgjsDefs1990"><linearGradient id="SvgjsLinearGradient1994" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop1995" stop-opacity="0.4" stop-color="rgba(216,227,240,0.4)" offset="0"></stop><stop id="SvgjsStop1996" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop><stop id="SvgjsStop1997" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop></linearGradient><clipPath id="gridRectMaskt4y8pdqd"><rect id="SvgjsRect1999" width="422" height="185.348" x="-2" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="forecastMaskt4y8pdqd"></clipPath><clipPath id="nonForecastMaskt4y8pdqd"></clipPath><clipPath id="gridRectMarkerMaskt4y8pdqd"><rect id="SvgjsRect2000" width="422" height="189.348" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><rect id="SvgjsRect1998" width="0" height="185.348" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke-dasharray="3" fill="url(#SvgjsLinearGradient1994)" class="apexcharts-xcrosshairs" y2="185.348" filter="none" fill-opacity="0.9"></rect><g id="SvgjsG2019" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG2020" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"><text id="SvgjsText2022" font-family="Helvetica, Arial, sans-serif" x="29.857142857142858" y="214.348" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#b2b3ca" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan2023">S</tspan><title>S</title></text><text id="SvgjsText2025" font-family="Helvetica, Arial, sans-serif" x="89.57142857142857" y="214.348" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#b2b3ca" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan2026">M</tspan><title>M</title></text><text id="SvgjsText2028" font-family="Helvetica, Arial, sans-serif" x="149.28571428571428" y="214.348" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#b2b3ca" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan2029">T</tspan><title>T</title></text><text id="SvgjsText2031" font-family="Helvetica, Arial, sans-serif" x="209" y="214.348" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#b2b3ca" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan2032">W</tspan><title>W</title></text><text id="SvgjsText2034" font-family="Helvetica, Arial, sans-serif" x="268.7142857142857" y="214.348" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#b2b3ca" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan2035">T</tspan><title>T</title></text><text id="SvgjsText2037" font-family="Helvetica, Arial, sans-serif" x="328.42857142857144" y="214.348" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#b2b3ca" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan2038">F</tspan><title>F</title></text><text id="SvgjsText2040" font-family="Helvetica, Arial, sans-serif" x="388.14285714285717" y="214.348" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#b2b3ca" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan2041">S</tspan><title>S</title></text></g></g><g id="SvgjsG2043" class="apexcharts-grid"><g id="SvgjsG2044" class="apexcharts-gridlines-horizontal" style="display: none;"><line id="SvgjsLine2046" x1="0" y1="0" x2="418" y2="0" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine2047" x1="0" y1="46.337" x2="418" y2="46.337" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine2048" x1="0" y1="92.674" x2="418" y2="92.674" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine2049" x1="0" y1="139.01100000000002" x2="418" y2="139.01100000000002" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine2050" x1="0" y1="185.348" x2="418" y2="185.348" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line></g><g id="SvgjsG2045" class="apexcharts-gridlines-vertical" style="display: none;"></g><line id="SvgjsLine2052" x1="0" y1="185.348" x2="418" y2="185.348" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line><line id="SvgjsLine2051" x1="0" y1="1" x2="0" y2="185.348" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line></g><g id="SvgjsG2001" class="apexcharts-bar-series apexcharts-plot-series"><g id="SvgjsG2002" class="apexcharts-series" rel="1" seriesName="seriesx1" data:realIndex="0"><path id="SvgjsPath2006" d="M 13.435714285714287 173.348L 13.435714285714287 109.30770000000001Q 13.435714285714287 97.30770000000001 25.435714285714287 97.30770000000001L 34.278571428571425 97.30770000000001Q 46.278571428571425 97.30770000000001 46.278571428571425 109.30770000000001L 46.278571428571425 109.30770000000001L 46.278571428571425 173.348Q 46.278571428571425 185.348 34.278571428571425 185.348L 25.435714285714287 185.348Q 13.435714285714287 185.348 13.435714285714287 173.348z" fill="#fdb52829" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskt4y8pdqd)" pathTo="M 13.435714285714287 173.348L 13.435714285714287 109.30770000000001Q 13.435714285714287 97.30770000000001 25.435714285714287 97.30770000000001L 34.278571428571425 97.30770000000001Q 46.278571428571425 97.30770000000001 46.278571428571425 109.30770000000001L 46.278571428571425 109.30770000000001L 46.278571428571425 173.348Q 46.278571428571425 185.348 34.278571428571425 185.348L 25.435714285714287 185.348Q 13.435714285714287 185.348 13.435714285714287 173.348z" pathFrom="M 13.435714285714287 173.348L 13.435714285714287 173.348L 46.278571428571425 173.348L 46.278571428571425 173.348L 46.278571428571425 173.348L 46.278571428571425 173.348L 46.278571428571425 173.348L 13.435714285714287 173.348" cy="97.30770000000001" cx="73.15" j="0" val="38" barHeight="88.0403" barWidth="32.84285714285714"></path><path id="SvgjsPath2008" d="M 73.15 173.348L 73.15 69.92125000000001Q 73.15 57.921250000000015 85.15 57.921250000000015L 93.99285714285715 57.921250000000015Q 105.99285714285715 57.921250000000015 105.99285714285715 69.92125000000001L 105.99285714285715 69.92125000000001L 105.99285714285715 173.348Q 105.99285714285715 185.348 93.99285714285715 185.348L 85.15 185.348Q 73.15 185.348 73.15 173.348z" fill="rgba(253,181,40,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskt4y8pdqd)" pathTo="M 73.15 173.348L 73.15 69.92125000000001Q 73.15 57.921250000000015 85.15 57.921250000000015L 93.99285714285715 57.921250000000015Q 105.99285714285715 57.921250000000015 105.99285714285715 69.92125000000001L 105.99285714285715 69.92125000000001L 105.99285714285715 173.348Q 105.99285714285715 185.348 93.99285714285715 185.348L 85.15 185.348Q 73.15 185.348 73.15 173.348z" pathFrom="M 73.15 173.348L 73.15 173.348L 105.99285714285715 173.348L 105.99285714285715 173.348L 105.99285714285715 173.348L 105.99285714285715 173.348L 105.99285714285715 173.348L 73.15 173.348" cy="57.921250000000015" cx="132.86428571428573" j="1" val="55" barHeight="127.42675" barWidth="32.84285714285714"></path><path id="SvgjsPath2010" d="M 132.86428571428573 173.348L 132.86428571428573 86.13920000000002Q 132.86428571428573 74.13920000000002 144.86428571428573 74.13920000000002L 153.70714285714286 74.13920000000002Q 165.70714285714286 74.13920000000002 165.70714285714286 86.13920000000002L 165.70714285714286 86.13920000000002L 165.70714285714286 173.348Q 165.70714285714286 185.348 153.70714285714286 185.348L 144.86428571428573 185.348Q 132.86428571428573 185.348 132.86428571428573 173.348z" fill="#fdb52829" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskt4y8pdqd)" pathTo="M 132.86428571428573 173.348L 132.86428571428573 86.13920000000002Q 132.86428571428573 74.13920000000002 144.86428571428573 74.13920000000002L 153.70714285714286 74.13920000000002Q 165.70714285714286 74.13920000000002 165.70714285714286 86.13920000000002L 165.70714285714286 86.13920000000002L 165.70714285714286 173.348Q 165.70714285714286 185.348 153.70714285714286 185.348L 144.86428571428573 185.348Q 132.86428571428573 185.348 132.86428571428573 173.348z" pathFrom="M 132.86428571428573 173.348L 132.86428571428573 173.348L 165.70714285714286 173.348L 165.70714285714286 173.348L 165.70714285714286 173.348L 165.70714285714286 173.348L 165.70714285714286 173.348L 132.86428571428573 173.348" cy="74.13920000000002" cx="192.57857142857145" j="2" val="48" barHeight="111.2088" barWidth="32.84285714285714"></path><path id="SvgjsPath2012" d="M 192.57857142857145 173.348L 192.57857142857145 46.75275000000002Q 192.57857142857145 34.75275000000002 204.57857142857145 34.75275000000002L 213.42142857142858 34.75275000000002Q 225.42142857142858 34.75275000000002 225.42142857142858 46.75275000000002L 225.42142857142858 46.75275000000002L 225.42142857142858 173.348Q 225.42142857142858 185.348 213.42142857142858 185.348L 204.57857142857145 185.348Q 192.57857142857145 185.348 192.57857142857145 173.348z" fill="rgba(253,181,40,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskt4y8pdqd)" pathTo="M 192.57857142857145 173.348L 192.57857142857145 46.75275000000002Q 192.57857142857145 34.75275000000002 204.57857142857145 34.75275000000002L 213.42142857142858 34.75275000000002Q 225.42142857142858 34.75275000000002 225.42142857142858 46.75275000000002L 225.42142857142858 46.75275000000002L 225.42142857142858 173.348Q 225.42142857142858 185.348 213.42142857142858 185.348L 204.57857142857145 185.348Q 192.57857142857145 185.348 192.57857142857145 173.348z" pathFrom="M 192.57857142857145 173.348L 192.57857142857145 173.348L 225.42142857142858 173.348L 225.42142857142858 173.348L 225.42142857142858 173.348L 225.42142857142858 173.348L 225.42142857142858 173.348L 192.57857142857145 173.348" cy="34.75275000000002" cx="252.29285714285717" j="3" val="65" barHeight="150.59525" barWidth="32.84285714285714"></path><path id="SvgjsPath2014" d="M 252.29285714285717 173.348L 252.29285714285717 12Q 252.29285714285717 0 264.2928571428572 0L 273.1357142857143 0Q 285.1357142857143 0 285.1357142857143 12L 285.1357142857143 12L 285.1357142857143 173.348Q 285.1357142857143 185.348 273.1357142857143 185.348L 264.2928571428572 185.348Q 252.29285714285717 185.348 252.29285714285717 173.348z" fill="rgba(253,181,40,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskt4y8pdqd)" pathTo="M 252.29285714285717 173.348L 252.29285714285717 12Q 252.29285714285717 0 264.2928571428572 0L 273.1357142857143 0Q 285.1357142857143 0 285.1357142857143 12L 285.1357142857143 12L 285.1357142857143 173.348Q 285.1357142857143 185.348 273.1357142857143 185.348L 264.2928571428572 185.348Q 252.29285714285717 185.348 252.29285714285717 173.348z" pathFrom="M 252.29285714285717 173.348L 252.29285714285717 173.348L 285.1357142857143 173.348L 285.1357142857143 173.348L 285.1357142857143 173.348L 285.1357142857143 173.348L 285.1357142857143 173.348L 252.29285714285717 173.348" cy="0" cx="312.00714285714287" j="4" val="80" barHeight="185.348" barWidth="32.84285714285714"></path><path id="SvgjsPath2016" d="M 312.00714285714287 173.348L 312.00714285714287 109.30770000000001Q 312.00714285714287 97.30770000000001 324.00714285714287 97.30770000000001L 332.85 97.30770000000001Q 344.85 97.30770000000001 344.85 109.30770000000001L 344.85 109.30770000000001L 344.85 173.348Q 344.85 185.348 332.85 185.348L 324.00714285714287 185.348Q 312.00714285714287 185.348 312.00714285714287 173.348z" fill="#fdb52829" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskt4y8pdqd)" pathTo="M 312.00714285714287 173.348L 312.00714285714287 109.30770000000001Q 312.00714285714287 97.30770000000001 324.00714285714287 97.30770000000001L 332.85 97.30770000000001Q 344.85 97.30770000000001 344.85 109.30770000000001L 344.85 109.30770000000001L 344.85 173.348Q 344.85 185.348 332.85 185.348L 324.00714285714287 185.348Q 312.00714285714287 185.348 312.00714285714287 173.348z" pathFrom="M 312.00714285714287 173.348L 312.00714285714287 173.348L 344.85 173.348L 344.85 173.348L 344.85 173.348L 344.85 173.348L 344.85 173.348L 312.00714285714287 173.348" cy="97.30770000000001" cx="371.7214285714286" j="5" val="38" barHeight="88.0403" barWidth="32.84285714285714"></path><path id="SvgjsPath2018" d="M 371.7214285714286 173.348L 371.7214285714286 86.13920000000002Q 371.7214285714286 74.13920000000002 383.7214285714286 74.13920000000002L 392.56428571428575 74.13920000000002Q 404.56428571428575 74.13920000000002 404.56428571428575 86.13920000000002L 404.56428571428575 86.13920000000002L 404.56428571428575 173.348Q 404.56428571428575 185.348 392.56428571428575 185.348L 383.7214285714286 185.348Q 371.7214285714286 185.348 371.7214285714286 173.348z" fill="#fdb52829" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskt4y8pdqd)" pathTo="M 371.7214285714286 173.348L 371.7214285714286 86.13920000000002Q 371.7214285714286 74.13920000000002 383.7214285714286 74.13920000000002L 392.56428571428575 74.13920000000002Q 404.56428571428575 74.13920000000002 404.56428571428575 86.13920000000002L 404.56428571428575 86.13920000000002L 404.56428571428575 173.348Q 404.56428571428575 185.348 392.56428571428575 185.348L 383.7214285714286 185.348Q 371.7214285714286 185.348 371.7214285714286 173.348z" pathFrom="M 371.7214285714286 173.348L 371.7214285714286 173.348L 404.56428571428575 173.348L 404.56428571428575 173.348L 404.56428571428575 173.348L 404.56428571428575 173.348L 404.56428571428575 173.348L 371.7214285714286 173.348" cy="74.13920000000002" cx="431.4357142857143" j="6" val="48" barHeight="111.2088" barWidth="32.84285714285714"></path><g id="SvgjsG2004" class="apexcharts-bar-goals-markers" style="pointer-events: none"><g id="SvgjsG2005" className="apexcharts-bar-goals-groups"></g><g id="SvgjsG2007" className="apexcharts-bar-goals-groups"></g><g id="SvgjsG2009" className="apexcharts-bar-goals-groups"></g><g id="SvgjsG2011" className="apexcharts-bar-goals-groups"></g><g id="SvgjsG2013" className="apexcharts-bar-goals-groups"></g><g id="SvgjsG2015" className="apexcharts-bar-goals-groups"></g><g id="SvgjsG2017" className="apexcharts-bar-goals-groups"></g></g></g><g id="SvgjsG2003" class="apexcharts-datalabels" data:realIndex="0"></g></g><line id="SvgjsLine2053" x1="0" y1="0" x2="418" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine2054" x1="0" y1="0" x2="418" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG2055" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG2056" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG2057" class="apexcharts-point-annotations"></g></g><g id="SvgjsG2042" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g><g id="SvgjsG1992" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend" style="max-height: 119px;"></div></div></div>
                    <div class="d-flex justify-content-between mt-6">
                      <div>
                        <h6 class="mb-0">Most Visited Day</h6>
                        <p class="mb-0 small">Total 62.4k Visits on Thursday</p>
                      </div>
                      <div class="avatar">
                        <div class="avatar-initial bg-label-warning rounded">
                          <i class="ri-arrow-right-s-line ri-24px scaleX-n1-rtl"></i>
                        </div>
                      </div>
                    </div>
                  <div class="resize-triggers"><div class="expand-trigger"><div style="width: 448px; height: 373px;"></div></div><div class="contract-trigger"></div></div></div>
                </div>
              </div>
              <!--/ visits By Day Chart-->

              <!-- Activity Timeline -->
              <div class="col-12 col-xxl-8">
                <div class="card h-100">
                  <div class="card-header">
                    <div class="d-flex justify-content-between">
                      <h5 class="mb-0">Activity Timeline</h5>
                    </div>
                  </div>
                  <div class="card-body pt-4">
                    <ul class="timeline card-timeline mb-0">
                      <li class="timeline-item timeline-item-transparent">
                        <span class="timeline-point timeline-point-primary"></span>
                        <div class="timeline-event">
                          <div class="timeline-header mb-3">
                            <h6 class="mb-0">12 Invoices have been paid</h6>
                            <small class="text-muted">12 min ago</small>
                          </div>
                          <p class="mb-2">Invoices have been paid to the company</p>
                          <div class="d-flex align-items-center mb-1">
                            <div class="badge bg-lighter rounded-3">
                              <img src="../../assets//img/icons/misc/pdf.png" alt="img" width="15" class="me-2">
                              <span class="h6 mb-0">invoices.pdf</span>
                            </div>
                          </div>
                        </div>
                      </li>
                      <li class="timeline-item timeline-item-transparent">
                        <span class="timeline-point timeline-point-success"></span>
                        <div class="timeline-event">
                          <div class="timeline-header mb-3">
                            <h6 class="mb-0">Client Meeting</h6>
                            <small class="text-muted">45 min ago</small>
                          </div>
                          <p class="mb-2">Project meeting with john @10:15am</p>
                          <div class="d-flex justify-content-between flex-wrap gap-2">
                            <div class="d-flex flex-wrap align-items-center">
                              <div class="avatar avatar-sm me-2">
                                <img src="../../assets/img/avatars/1.png" alt="Avatar" class="rounded-circle">
                              </div>
                              <div>
                                <p class="mb-0 small fw-medium">Lester McCarthy (Client)</p>
                                <small>CEO of ThemeSelection</small>
                              </div>
                            </div>
                          </div>
                        </div>
                      </li>
                      <li class="timeline-item timeline-item-transparent">
                        <span class="timeline-point timeline-point-info"></span>
                        <div class="timeline-event">
                          <div class="timeline-header mb-3">
                            <h6 class="mb-0">Create a new project for client</h6>
                            <small class="text-muted">2 Day Ago</small>
                          </div>
                          <p class="mb-2">6 team members in a project</p>
                          <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap border-top-0 p-0">
                              <div class="d-flex flex-wrap align-items-center">
                                <ul class="list-unstyled users-list d-flex align-items-center avatar-group m-0 me-2">
                                  <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar pull-up" aria-label="Vinnie Mostowy" data-bs-original-title="Vinnie Mostowy">
                                    <img class="rounded-circle" src="../../assets/img/avatars/5.png" alt="Avatar">
                                  </li>
                                  <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar pull-up" aria-label="Allen Rieske" data-bs-original-title="Allen Rieske">
                                    <img class="rounded-circle" src="../../assets/img/avatars/12.png" alt="Avatar">
                                  </li>
                                  <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar pull-up" aria-label="Julee Rossignol" data-bs-original-title="Julee Rossignol">
                                    <img class="rounded-circle" src="../../assets/img/avatars/6.png" alt="Avatar">
                                  </li>
                                  <li class="avatar">
                                    <span class="avatar-initial rounded-circle pull-up text-heading" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="3 more">+3</span>
                                  </li>
                                </ul>
                              </div>
                            </li>
                          </ul>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <!-- Activity Timeline -->
            </div>
          </div>

    <div class="row">
        <!-- Solo si el usuario es superadmin -->
        @auth
            @if(auth()->user()->config?->role?->isSuperAdmin())
                
                <!-- Compañías -->
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <span class="fw-medium d-block mb-1">Compañías</span>
                                    <div class="d-flex align-items-center my-2">
                                        <h4 class="mb-0 me-2">Gestión de Compañías</h4>
                                    </div>
                                    <p class="mb-0">Administre y organice las compañías asociadas</p>
                                </div>
                                <div class="avatar">
                                <span class="avatar-initial rounded" style="background-color:rgb(223, 223, 223); color:#4b4b4b">
                                    <i class="ri-building-fill fs-4"></i>
                                </span>
                                </div>
                            </div>
                            <div class="d-grid mt-3">
                                <a href="{{ route('companias.index') }}" class="btn btn-dark waves-effect waves-light">
                                    <i class="ri-arrow-right-line me-1"></i> Gestionar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Usuarios-->
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <span class="fw-medium d-block mb-1">Usuarios</span>
                                    <div class="d-flex align-items-center my-2">
                                        <h4 class="mb-0 me-2">Gestión de Usuarios</h4>
                                    </div>
                                    <p class="mb-0">Administre  la información de los diferentes usuarios del sistema</p>
                                </div>
                                <div class="avatar">
                                <span class="avatar-initial rounded" style="background-color: rgb(250, 212, 255); color:rgb(194, 56, 212)">
                                    <i class="ri-user-settings-fill fs-4"></i>
                                </span>
                                </div>
                            </div>
                            <div class="d-grid mt-3">
                                <a href="{{ route('usuarios.index') }}" class="btn waves-effect waves-light" style="background-color: rgb(194, 56, 212); color:white">
                                    <i class="ri-arrow-right-line me-1"></i> Gestionar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endauth


    </div>

    <!-- Estadísticas Rápidas -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="mb-0">Resumen del Sistema</h5>
                </div>
                <div class="card-body">
                    <div class="row gy-3">
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded-pill bg-label-primary me-3 p-2">
                                    <i class="ri-user-line fs-5"></i>
                                </div>
                                <div class="card-info">
                                    <h5 class="mb-0">45</h5>
                                    <small>Candidatos</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded-pill bg-label-info me-3 p-2">
                                    <i class="ri-file-list-line fs-5"></i>
                                </div>
                                <div class="card-info">
                                    <h5 class="mb-0">12</h5>
                                    <small>Evaluaciones</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded-pill bg-label-success me-3 p-2">
                                    <i class="ri-question-line fs-5"></i>
                                </div>
                                <div class="card-info">
                                    <h5 class="mb-0">128</h5>
                                    <small>Preguntas</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded-pill bg-label-warning me-3 p-2">
                                    <i class="ri-time-line fs-5"></i>
                                </div>
                                <div class="card-info">
                                    <h5 class="mb-0">78%</h5>
                                    <small>Tasa de aprobación</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <script>
        $(function() {
            'use strict';

            // Aquí puedes agregar JavaScript adicional para el dashboard
            // Por ejemplo, animaciones para las tarjetas, actualizaciones de datos, etc.

            // Efecto hover para las tarjetas
            $('.card').hover(
                function() { $(this).addClass('shadow-lg'); },
                function() { $(this).removeClass('shadow-lg'); }
            );
        });
    </script>
@endsection
