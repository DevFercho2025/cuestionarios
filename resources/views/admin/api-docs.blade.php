@extends('layout.admin')

@section('content')
<style>
    .api-docs { max-width: 1100px; margin: 0 auto; padding: 20px 0; }
    .api-header { background: linear-gradient(135deg, #1a2a3a 0%, #2d4a5e 100%); color: #fff; border-radius: 12px; padding: 30px; margin-bottom: 30px; }
    .api-header h1 { font-size: 1.8rem; font-weight: 700; margin: 0 0 8px; }
    .api-header p { opacity: .85; margin: 0; font-size: .95rem; }
    .api-header .badge { font-size: .75rem; padding: 4px 10px; border-radius: 20px; }

    /* Auth box */
    .auth-box { background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 10px; padding: 20px; margin-bottom: 24px; }
    .auth-box h5 { margin: 0 0 12px; font-weight: 600; }
    .auth-box .form-control { font-family: 'Courier New', monospace; font-size: .85rem; }

    /* Section group */
    .api-section { margin-bottom: 28px; }
    .api-section-title { font-size: 1.15rem; font-weight: 700; color: #1a2a3a; border-bottom: 2px solid #e9ecef; padding-bottom: 8px; margin-bottom: 16px; }
    .api-section-title i { margin-right: 6px; }

    /* Endpoint card */
    .endpoint-card { border: 1px solid #e0e0e0; border-radius: 10px; margin-bottom: 12px; overflow: hidden; transition: box-shadow .2s; }
    .endpoint-card:hover { box-shadow: 0 2px 12px rgba(0,0,0,.08); }
    .endpoint-header { display: flex; align-items: center; padding: 12px 16px; cursor: pointer; gap: 12px; background: #fafbfc; border-bottom: 1px solid transparent; }
    .endpoint-header.collapsed { border-bottom-color: transparent; }
    .endpoint-header:not(.collapsed) { border-bottom-color: #e0e0e0; background: #fff; }
    .endpoint-header .method-badge { font-weight: 700; font-size: .75rem; padding: 4px 10px; border-radius: 4px; min-width: 60px; text-align: center; text-transform: uppercase; font-family: monospace; flex-shrink: 0; }
    .method-get { background: #e8f5e9; color: #2e7d32; }
    .method-post { background: #e3f2fd; color: #1565c0; }
    .method-put { background: #fff3e0; color: #e65100; }
    .method-patch { background: #fff8e1; color: #f57f17; }
    .method-delete { background: #fce4ec; color: #c62828; }
    .endpoint-path { font-family: 'Courier New', monospace; font-size: .9rem; font-weight: 600; color: #333; flex-grow: 1; }
    .endpoint-desc { font-size: .82rem; color: #666; flex-shrink: 0; max-width: 320px; text-align: right; }
    .endpoint-chevron { color: #999; transition: transform .2s; flex-shrink: 0; }
    .endpoint-header:not(.collapsed) .endpoint-chevron { transform: rotate(180deg); }

    /* Endpoint body */
    .endpoint-body { padding: 20px; background: #fff; }
    .endpoint-body h6 { font-weight: 700; font-size: .85rem; color: #555; text-transform: uppercase; letter-spacing: .5px; margin: 16px 0 8px; }
    .endpoint-body h6:first-child { margin-top: 0; }

    /* Params table */
    .params-table { width: 100%; font-size: .85rem; border-collapse: collapse; }
    .params-table th { background: #f5f6f8; padding: 6px 10px; text-align: left; font-weight: 600; border-bottom: 1px solid #e0e0e0; }
    .params-table td { padding: 6px 10px; border-bottom: 1px solid #f0f0f0; vertical-align: top; }
    .params-table .param-name { font-family: monospace; font-weight: 600; color: #c2185b; }
    .params-table .param-type { color: #1565c0; font-size: .8rem; }
    .params-table .badge-required { background: #fce4ec; color: #c62828; font-size: .7rem; padding: 2px 6px; border-radius: 3px; }
    .params-table .badge-optional { background: #f5f5f5; color: #888; font-size: .7rem; padding: 2px 6px; border-radius: 3px; }

    /* Code block */
    .code-block { background: #1e1e2e; color: #cdd6f4; border-radius: 8px; padding: 16px; font-family: 'Courier New', monospace; font-size: .82rem; line-height: 1.5; overflow-x: auto; position: relative; white-space: pre; }
    .code-block .key { color: #89b4fa; }
    .code-block .string { color: #a6e3a1; }
    .code-block .number { color: #fab387; }
    .code-block .bool { color: #cba6f7; }
    .code-block .null-val { color: #6c7086; }
    .code-block .comment { color: #6c7086; font-style: italic; }
    .copy-btn { position: absolute; top: 8px; right: 8px; background: rgba(255,255,255,.1); border: none; color: #cdd6f4; padding: 4px 8px; border-radius: 4px; cursor: pointer; font-size: .75rem; }
    .copy-btn:hover { background: rgba(255,255,255,.2); }

    /* Try-it section */
    .try-it { background: #f8f9fa; border-radius: 8px; padding: 16px; margin-top: 12px; border: 1px solid #e0e0e0; }
    .try-it .btn-try { background: #1a2a3a; color: #fff; border: none; padding: 6px 20px; border-radius: 6px; font-size: .85rem; font-weight: 600; }
    .try-it .btn-try:hover { background: #2d4a5e; }
    .try-it .response-area { background: #1e1e2e; color: #cdd6f4; border-radius: 8px; padding: 14px; font-family: 'Courier New', monospace; font-size: .8rem; min-height: 80px; max-height: 400px; overflow: auto; margin-top: 10px; display: none; white-space: pre-wrap; word-break: break-all; }
    .try-it .response-status { display: none; margin-top: 8px; font-size: .85rem; font-weight: 600; }
    .try-it .response-status.s2xx { color: #2e7d32; }
    .try-it .response-status.s4xx { color: #e65100; }
    .try-it .response-status.s5xx { color: #c62828; }

    /* Middleware badges */
    .mw-badge { font-size: .7rem; padding: 2px 8px; border-radius: 10px; font-weight: 600; }
    .mw-auth { background: #e8eaf6; color: #283593; }
    .mw-rate { background: #e0f2f1; color: #00695c; }
    .mw-billing { background: #fff3e0; color: #e65100; }
    .mw-access { background: #fce4ec; color: #ad1457; }

    /* Tabs */
    .api-docs .nav-tabs .nav-link { font-weight: 600; font-size: .85rem; color: #555; }
    .api-docs .nav-tabs .nav-link.active { color: #1a2a3a; border-bottom: 2px solid #1a2a3a; }
</style>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="api-docs">

            {{-- Header --}}
            <div class="api-header">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                    <div>
                        <h1><i class="ri-code-s-slash-line"></i> API Documentation</h1>
                        <p>Psicometr&iacute;as Platform &mdash; REST API Reference</p>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-success">v1.0</span>
                        <span class="badge bg-info">JSON</span>
                        <span class="badge bg-warning text-dark">Bearer Auth</span>
                        <div class="mt-2" style="font-size:.78rem;opacity:.7;">
                            Base URL: <code style="color:#a6e3a1;">{{ url('/api') }}</code>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Auth Configuration --}}
            <div class="auth-box">
                <h5><i class="ri-lock-line"></i> Autenticaci&oacute;n</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold" style="font-size:.85rem;">API Token (Bearer) &mdash; API v1</label>
                        <div class="input-group">
                            <span class="input-group-text" style="font-size:.8rem;">Bearer</span>
                            <input type="text" class="form-control" id="apiToken" placeholder="Pega tu token aqu&iacute;...">
                        </div>
                        <small class="text-muted">Se usar&aacute; autom&aacute;ticamente en las solicitudes de prueba.</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold" style="font-size:.85rem;">Internal Secret &mdash; API Interna</label>
                        <div class="input-group">
                            <span class="input-group-text" style="font-size:.8rem;">X-Internal-Secret</span>
                            <input type="text" class="form-control" id="internalSecret" placeholder="Secret interno...">
                        </div>
                        <small class="text-muted">Para endpoints /api/internal/*</small>
                    </div>
                </div>
            </div>

            {{-- Response envelope info --}}
            <div class="card mb-4">
                <div class="card-body">
                    <h6 class="card-title fw-bold mb-3"><i class="ri-information-line"></i> Formato de Respuesta Est&aacute;ndar</h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="fw-bold mb-1" style="font-size:.82rem; color:#2e7d32;">Exitosa (2xx)</div>
                            <div class="code-block">{
  <span class="key">"success"</span>: <span class="bool">true</span>,
  <span class="key">"message"</span>: <span class="string">"..."</span>,
  <span class="key">"data"</span>: { ... }
}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="fw-bold mb-1" style="font-size:.82rem; color:#e65100;">Error (4xx/5xx)</div>
                            <div class="code-block">{
  <span class="key">"success"</span>: <span class="bool">false</span>,
  <span class="key">"message"</span>: <span class="string">"..."</span>,
  <span class="key">"data"</span>: <span class="null-val">null</span>
}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="fw-bold mb-1" style="font-size:.82rem; color:#1565c0;">Paginada</div>
                            <div class="code-block">{
  <span class="key">"success"</span>: <span class="bool">true</span>,
  <span class="key">"data"</span>: [ ... ],
  <span class="key">"meta"</span>: {
    <span class="key">"current_page"</span>: <span class="number">1</span>,
    <span class="key">"per_page"</span>: <span class="number">25</span>,
    <span class="key">"total"</span>: <span class="number">112</span>
  }
}</div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted">
                            <strong>Rate Limit:</strong> Los headers <code>X-RateLimit-Limit</code> y <code>X-RateLimit-Remaining</code> se incluyen en cada respuesta. Al exceder el l&iacute;mite se retorna <code>429</code> con <code>Retry-After</code>.
                        </small>
                    </div>
                </div>
            </div>

            {{-- ═══════════════════ API V1 ENDPOINTS ═══════════════════ --}}

            {{-- TESTS --}}
            <div class="api-section">
                <div class="api-section-title"><i class="ri-file-list-3-line"></i> Cat&aacute;logo de Tests</div>

                {{-- GET /tests --}}
                <div class="endpoint-card">
                    <div class="endpoint-header collapsed" data-bs-toggle="collapse" data-bs-target="#ep-get-tests">
                        <span class="method-badge method-get">GET</span>
                        <span class="endpoint-path">/api/v1/tests</span>
                        <span class="endpoint-desc">Listar todos los tests disponibles</span>
                        <i class="ri-arrow-down-s-line endpoint-chevron"></i>
                    </div>
                    <div class="collapse" id="ep-get-tests">
                        <div class="endpoint-body">
                            <div class="mb-2">
                                <span class="mw-badge mw-auth">Bearer Auth</span>
                                <span class="mw-badge mw-rate">Rate Limit</span>
                            </div>
                            <p style="font-size:.88rem;">Retorna el cat&aacute;logo completo de pruebas psicom&eacute;tricas disponibles para el cliente.</p>

                            <h6>Par&aacute;metros</h6>
                            <p class="text-muted" style="font-size:.85rem;">Ninguno</p>

                            <h6>Respuesta 200</h6>
                            <div class="code-block"><button class="copy-btn" onclick="copyCode(this)">Copiar</button>{
  <span class="key">"success"</span>: <span class="bool">true</span>,
  <span class="key">"message"</span>: <span class="string">"Test catalog retrieved."</span>,
  <span class="key">"data"</span>: [
    {
      <span class="key">"id"</span>: <span class="number">1</span>,
      <span class="key">"title"</span>: <span class="string">"Terman-Merrill"</span>,
      <span class="key">"type"</span>: <span class="string">"Inteligencia"</span>,
      <span class="key">"type_id"</span>: <span class="number">3</span>,
      <span class="key">"time"</span>: <span class="string">"45:00"</span>,
      <span class="key">"instructions"</span>: <span class="string">"Lea cada pregunta..."</span>,
      <span class="key">"token_cost"</span>: <span class="number">2</span>,
      <span class="key">"sections_count"</span>: <span class="number">4</span>,
      <span class="key">"questions_count"</span>: <span class="number">80</span>
    }
  ]
}</div>

                            <div class="try-it" data-method="GET" data-url="/api/v1/tests" data-auth="bearer">
                                <h6 style="margin-top:0;">Probar Endpoint</h6>
                                <button class="btn btn-try" onclick="tryEndpoint(this)">
                                    <i class="ri-play-line"></i> Enviar Solicitud
                                </button>
                                <div class="response-status"></div>
                                <div class="response-area"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- GET /tests/{id} --}}
                <div class="endpoint-card">
                    <div class="endpoint-header collapsed" data-bs-toggle="collapse" data-bs-target="#ep-get-test">
                        <span class="method-badge method-get">GET</span>
                        <span class="endpoint-path">/api/v1/tests/{id}</span>
                        <span class="endpoint-desc">Obtener un test por ID</span>
                        <i class="ri-arrow-down-s-line endpoint-chevron"></i>
                    </div>
                    <div class="collapse" id="ep-get-test">
                        <div class="endpoint-body">
                            <div class="mb-2">
                                <span class="mw-badge mw-auth">Bearer Auth</span>
                                <span class="mw-badge mw-rate">Rate Limit</span>
                            </div>

                            <h6>Par&aacute;metros de Ruta</h6>
                            <table class="params-table">
                                <thead><tr><th>Par&aacute;metro</th><th>Tipo</th><th>Descripci&oacute;n</th></tr></thead>
                                <tbody>
                                    <tr>
                                        <td><span class="param-name">id</span></td>
                                        <td><span class="param-type">integer</span> <span class="badge-required">requerido</span></td>
                                        <td>ID interno del test</td>
                                    </tr>
                                </tbody>
                            </table>

                            <h6>Respuesta 200</h6>
                            <div class="code-block"><button class="copy-btn" onclick="copyCode(this)">Copiar</button>{
  <span class="key">"success"</span>: <span class="bool">true</span>,
  <span class="key">"data"</span>: {
    <span class="key">"id"</span>: <span class="number">1</span>,
    <span class="key">"title"</span>: <span class="string">"Terman-Merrill"</span>,
    <span class="key">"type"</span>: <span class="string">"Inteligencia"</span>,
    <span class="comment">// ... misma estructura que el listado</span>
  }
}</div>

                            <h6>Respuesta 404</h6>
                            <div class="code-block">{ <span class="key">"success"</span>: <span class="bool">false</span>, <span class="key">"message"</span>: <span class="string">"Test not found."</span> }</div>

                            <div class="try-it" data-method="GET" data-url="/api/v1/tests/{id}" data-auth="bearer">
                                <h6 style="margin-top:0;">Probar Endpoint</h6>
                                <div class="mb-2">
                                    <label class="form-label" style="font-size:.8rem;">id:</label>
                                    <input type="text" class="form-control form-control-sm path-param" data-param="id" placeholder="1" style="max-width:120px;">
                                </div>
                                <button class="btn btn-try" onclick="tryEndpoint(this)">
                                    <i class="ri-play-line"></i> Enviar Solicitud
                                </button>
                                <div class="response-status"></div>
                                <div class="response-area"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CANDIDATES --}}
            <div class="api-section">
                <div class="api-section-title"><i class="ri-user-3-line"></i> Candidatos</div>

                {{-- POST /candidates --}}
                <div class="endpoint-card">
                    <div class="endpoint-header collapsed" data-bs-toggle="collapse" data-bs-target="#ep-post-candidates">
                        <span class="method-badge method-post">POST</span>
                        <span class="endpoint-path">/api/v1/candidates</span>
                        <span class="endpoint-desc">Crear un candidato</span>
                        <i class="ri-arrow-down-s-line endpoint-chevron"></i>
                    </div>
                    <div class="collapse" id="ep-post-candidates">
                        <div class="endpoint-body">
                            <div class="mb-2">
                                <span class="mw-badge mw-auth">Bearer Auth</span>
                                <span class="mw-badge mw-rate">Rate Limit</span>
                            </div>
                            <p style="font-size:.88rem;">Crea un nuevo candidato y lo vincula al cliente API mediante un <code>external_candidate_id</code>.</p>

                            <h6>Body (JSON)</h6>
                            <table class="params-table">
                                <thead><tr><th>Campo</th><th>Tipo</th><th>Descripci&oacute;n</th></tr></thead>
                                <tbody>
                                    <tr><td><span class="param-name">external_candidate_id</span></td><td><span class="param-type">string</span> <span class="badge-required">requerido</span></td><td>ID externo &uacute;nico del candidato (max 255)</td></tr>
                                    <tr><td><span class="param-name">firstname</span></td><td><span class="param-type">string</span> <span class="badge-required">requerido</span></td><td>Nombre</td></tr>
                                    <tr><td><span class="param-name">lastname</span></td><td><span class="param-type">string</span> <span class="badge-required">requerido</span></td><td>Apellido</td></tr>
                                    <tr><td><span class="param-name">email</span></td><td><span class="param-type">string</span> <span class="badge-required">requerido</span></td><td>Correo electr&oacute;nico v&aacute;lido</td></tr>
                                    <tr><td><span class="param-name">phone</span></td><td><span class="param-type">string</span> <span class="badge-optional">opcional</span></td><td>Tel&eacute;fono (max 50)</td></tr>
                                    <tr><td><span class="param-name">date_of_birth</span></td><td><span class="param-type">date</span> <span class="badge-optional">opcional</span></td><td>Fecha de nacimiento</td></tr>
                                    <tr><td><span class="param-name">gender</span></td><td><span class="param-type">string</span> <span class="badge-optional">opcional</span></td><td>G&eacute;nero</td></tr>
                                    <tr><td><span class="param-name">postal_code</span></td><td><span class="param-type">string</span> <span class="badge-optional">opcional</span></td><td>C&oacute;digo postal (max 10)</td></tr>
                                    <tr><td><span class="param-name">country</span></td><td><span class="param-type">string</span> <span class="badge-optional">opcional</span></td><td>Pa&iacute;s (max 100)</td></tr>
                                </tbody>
                            </table>

                            <h6>Ejemplo de Request</h6>
                            <div class="code-block"><button class="copy-btn" onclick="copyCode(this)">Copiar</button>{
  <span class="key">"external_candidate_id"</span>: <span class="string">"EXT-001"</span>,
  <span class="key">"firstname"</span>: <span class="string">"Juan"</span>,
  <span class="key">"lastname"</span>: <span class="string">"P&eacute;rez"</span>,
  <span class="key">"email"</span>: <span class="string">"juan@ejemplo.com"</span>,
  <span class="key">"phone"</span>: <span class="string">"+52-555-0100"</span>
}</div>

                            <h6>Respuesta 201</h6>
                            <div class="code-block"><button class="copy-btn" onclick="copyCode(this)">Copiar</button>{
  <span class="key">"success"</span>: <span class="bool">true</span>,
  <span class="key">"message"</span>: <span class="string">"Candidate created."</span>,
  <span class="key">"data"</span>: {
    <span class="key">"external_id"</span>: <span class="string">"EXT-001"</span>,
    <span class="key">"id"</span>: <span class="number">123</span>,
    <span class="key">"name"</span>: <span class="string">"Juan P&eacute;rez"</span>,
    <span class="key">"email"</span>: <span class="string">"juan@ejemplo.com"</span>,
    <span class="key">"phone"</span>: <span class="string">"+52-555-0100"</span>,
    <span class="key">"created_at"</span>: <span class="string">"2026-02-26T10:00:00+00:00"</span>
  }
}</div>

                            <div class="try-it" data-method="POST" data-url="/api/v1/candidates" data-auth="bearer">
                                <h6 style="margin-top:0;">Probar Endpoint</h6>
                                <textarea class="form-control mb-2 request-body" rows="6" style="font-family:monospace;font-size:.82rem;">{
  "external_candidate_id": "EXT-001",
  "firstname": "Juan",
  "lastname": "Perez",
  "email": "juan@ejemplo.com"
}</textarea>
                                <button class="btn btn-try" onclick="tryEndpoint(this)">
                                    <i class="ri-play-line"></i> Enviar Solicitud
                                </button>
                                <div class="response-status"></div>
                                <div class="response-area"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- GET /candidates --}}
                <div class="endpoint-card">
                    <div class="endpoint-header collapsed" data-bs-toggle="collapse" data-bs-target="#ep-get-candidates">
                        <span class="method-badge method-get">GET</span>
                        <span class="endpoint-path">/api/v1/candidates</span>
                        <span class="endpoint-desc">Listar candidatos del cliente</span>
                        <i class="ri-arrow-down-s-line endpoint-chevron"></i>
                    </div>
                    <div class="collapse" id="ep-get-candidates">
                        <div class="endpoint-body">
                            <div class="mb-2">
                                <span class="mw-badge mw-auth">Bearer Auth</span>
                                <span class="mw-badge mw-rate">Rate Limit</span>
                            </div>
                            <p style="font-size:.88rem;">Retorna todos los candidatos vinculados al cliente autenticado.</p>

                            <h6>Par&aacute;metros</h6>
                            <p class="text-muted" style="font-size:.85rem;">Ninguno</p>

                            <h6>Respuesta 200</h6>
                            <div class="code-block"><button class="copy-btn" onclick="copyCode(this)">Copiar</button>{
  <span class="key">"success"</span>: <span class="bool">true</span>,
  <span class="key">"data"</span>: [
    {
      <span class="key">"external_id"</span>: <span class="string">"EXT-001"</span>,
      <span class="key">"id"</span>: <span class="number">123</span>,
      <span class="key">"name"</span>: <span class="string">"Juan P&eacute;rez"</span>,
      <span class="key">"email"</span>: <span class="string">"juan@ejemplo.com"</span>
    }
  ]
}</div>

                            <div class="try-it" data-method="GET" data-url="/api/v1/candidates" data-auth="bearer">
                                <h6 style="margin-top:0;">Probar Endpoint</h6>
                                <button class="btn btn-try" onclick="tryEndpoint(this)">
                                    <i class="ri-play-line"></i> Enviar Solicitud
                                </button>
                                <div class="response-status"></div>
                                <div class="response-area"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- GET /candidates/{external_id} --}}
                <div class="endpoint-card">
                    <div class="endpoint-header collapsed" data-bs-toggle="collapse" data-bs-target="#ep-get-candidate">
                        <span class="method-badge method-get">GET</span>
                        <span class="endpoint-path">/api/v1/candidates/{external_id}</span>
                        <span class="endpoint-desc">Obtener candidato por ID externo</span>
                        <i class="ri-arrow-down-s-line endpoint-chevron"></i>
                    </div>
                    <div class="collapse" id="ep-get-candidate">
                        <div class="endpoint-body">
                            <div class="mb-2">
                                <span class="mw-badge mw-auth">Bearer Auth</span>
                                <span class="mw-badge mw-rate">Rate Limit</span>
                            </div>

                            <h6>Par&aacute;metros de Ruta</h6>
                            <table class="params-table">
                                <thead><tr><th>Par&aacute;metro</th><th>Tipo</th><th>Descripci&oacute;n</th></tr></thead>
                                <tbody>
                                    <tr><td><span class="param-name">external_id</span></td><td><span class="param-type">string</span> <span class="badge-required">requerido</span></td><td>ID externo asignado al crear el candidato</td></tr>
                                </tbody>
                            </table>

                            <h6>Respuesta 404</h6>
                            <div class="code-block">{ <span class="key">"success"</span>: <span class="bool">false</span>, <span class="key">"message"</span>: <span class="string">"Candidate not found."</span> }</div>

                            <div class="try-it" data-method="GET" data-url="/api/v1/candidates/{external_id}" data-auth="bearer">
                                <h6 style="margin-top:0;">Probar Endpoint</h6>
                                <div class="mb-2">
                                    <label class="form-label" style="font-size:.8rem;">external_id:</label>
                                    <input type="text" class="form-control form-control-sm path-param" data-param="external_id" placeholder="EXT-001" style="max-width:200px;">
                                </div>
                                <button class="btn btn-try" onclick="tryEndpoint(this)">
                                    <i class="ri-play-line"></i> Enviar Solicitud
                                </button>
                                <div class="response-status"></div>
                                <div class="response-area"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- EVALUATIONS --}}
            <div class="api-section">
                <div class="api-section-title"><i class="ri-survey-line"></i> Evaluaciones</div>

                {{-- POST /evaluations --}}
                <div class="endpoint-card">
                    <div class="endpoint-header collapsed" data-bs-toggle="collapse" data-bs-target="#ep-post-evaluations">
                        <span class="method-badge method-post">POST</span>
                        <span class="endpoint-path">/api/v1/evaluations</span>
                        <span class="endpoint-desc">Asignar evaluaciones a candidato</span>
                        <i class="ri-arrow-down-s-line endpoint-chevron"></i>
                    </div>
                    <div class="collapse" id="ep-post-evaluations">
                        <div class="endpoint-body">
                            <div class="mb-2">
                                <span class="mw-badge mw-auth">Bearer Auth</span>
                                <span class="mw-badge mw-rate">Rate Limit</span>
                                <span class="mw-badge mw-access">Test Access</span>
                                <span class="mw-badge mw-billing">Billing Quota</span>
                            </div>
                            <p style="font-size:.88rem;">Asigna uno o m&aacute;s tests a un candidato. Consume cuota (tokens o suscripci&oacute;n). Retorna un c&oacute;digo de acceso para que el candidato inicie sesi&oacute;n.</p>

                            <h6>Body (JSON)</h6>
                            <table class="params-table">
                                <thead><tr><th>Campo</th><th>Tipo</th><th>Descripci&oacute;n</th></tr></thead>
                                <tbody>
                                    <tr><td><span class="param-name">external_candidate_id</span></td><td><span class="param-type">string</span> <span class="badge-required">requerido</span></td><td>ID externo del candidato existente o nuevo</td></tr>
                                    <tr><td><span class="param-name">test_ids</span></td><td><span class="param-type">array[int]</span> <span class="badge-required">requerido</span></td><td>IDs de tests a asignar (m&iacute;nimo 1)</td></tr>
                                    <tr><td><span class="param-name">candidate</span></td><td><span class="param-type">object</span> <span class="badge-optional">condicional</span></td><td>Datos del candidato si no existe a&uacute;n</td></tr>
                                    <tr><td><span class="param-name">candidate.firstname</span></td><td><span class="param-type">string</span></td><td>Nombre (requerido si se env&iacute;a candidate)</td></tr>
                                    <tr><td><span class="param-name">candidate.lastname</span></td><td><span class="param-type">string</span></td><td>Apellido (requerido si se env&iacute;a candidate)</td></tr>
                                    <tr><td><span class="param-name">candidate.email</span></td><td><span class="param-type">string</span></td><td>Email (requerido si se env&iacute;a candidate)</td></tr>
                                </tbody>
                            </table>

                            <h6>Ejemplo de Request</h6>
                            <div class="code-block"><button class="copy-btn" onclick="copyCode(this)">Copiar</button>{
  <span class="key">"external_candidate_id"</span>: <span class="string">"EXT-001"</span>,
  <span class="key">"test_ids"</span>: [<span class="number">1</span>, <span class="number">3</span>],
  <span class="key">"candidate"</span>: {
    <span class="key">"firstname"</span>: <span class="string">"Mar&iacute;a"</span>,
    <span class="key">"lastname"</span>: <span class="string">"L&oacute;pez"</span>,
    <span class="key">"email"</span>: <span class="string">"maria@ejemplo.com"</span>
  }
}</div>

                            <h6>Respuesta 201</h6>
                            <div class="code-block"><button class="copy-btn" onclick="copyCode(this)">Copiar</button>{
  <span class="key">"success"</span>: <span class="bool">true</span>,
  <span class="key">"message"</span>: <span class="string">"Evaluations assigned successfully."</span>,
  <span class="key">"data"</span>: {
    <span class="key">"access_code"</span>: <span class="string">"ABC123"</span>,
    <span class="key">"evaluation_url"</span>: <span class="string">"https://app.example.com/login#tab-candidate"</span>,
    <span class="key">"evaluations"</span>: [
      {
        <span class="key">"id"</span>: <span class="number">55</span>,
        <span class="key">"test"</span>: { <span class="key">"id"</span>: <span class="number">1</span>, <span class="key">"title"</span>: <span class="string">"Terman-Merrill"</span> },
        <span class="key">"status"</span>: <span class="string">"pending"</span>,
        <span class="key">"progress"</span>: { <span class="key">"sections_completed"</span>: <span class="number">0</span>, <span class="key">"sections_total"</span>: <span class="number">4</span> }
      }
    ]
  }
}</div>

                            <h6>Errores Posibles</h6>
                            <table class="params-table">
                                <thead><tr><th>C&oacute;digo</th><th>Caso</th></tr></thead>
                                <tbody>
                                    <tr><td><code>402</code></td><td>Saldo de tokens insuficiente o l&iacute;mite de suscripci&oacute;n alcanzado</td></tr>
                                    <tr><td><code>422</code></td><td>Tests no disponibles v&iacute;a API o candidato no encontrado sin bloque <code>candidate</code></td></tr>
                                </tbody>
                            </table>

                            <div class="try-it" data-method="POST" data-url="/api/v1/evaluations" data-auth="bearer">
                                <h6 style="margin-top:0;">Probar Endpoint</h6>
                                <textarea class="form-control mb-2 request-body" rows="5" style="font-family:monospace;font-size:.82rem;">{
  "external_candidate_id": "EXT-001",
  "test_ids": [1]
}</textarea>
                                <button class="btn btn-try" onclick="tryEndpoint(this)">
                                    <i class="ri-play-line"></i> Enviar Solicitud
                                </button>
                                <div class="response-status"></div>
                                <div class="response-area"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- GET /evaluations --}}
                <div class="endpoint-card">
                    <div class="endpoint-header collapsed" data-bs-toggle="collapse" data-bs-target="#ep-get-evaluations">
                        <span class="method-badge method-get">GET</span>
                        <span class="endpoint-path">/api/v1/evaluations</span>
                        <span class="endpoint-desc">Listar evaluaciones (paginado)</span>
                        <i class="ri-arrow-down-s-line endpoint-chevron"></i>
                    </div>
                    <div class="collapse" id="ep-get-evaluations">
                        <div class="endpoint-body">
                            <div class="mb-2">
                                <span class="mw-badge mw-auth">Bearer Auth</span>
                                <span class="mw-badge mw-rate">Rate Limit</span>
                            </div>

                            <h6>Query Params</h6>
                            <table class="params-table">
                                <thead><tr><th>Par&aacute;metro</th><th>Tipo</th><th>Descripci&oacute;n</th></tr></thead>
                                <tbody>
                                    <tr><td><span class="param-name">per_page</span></td><td><span class="param-type">integer</span> <span class="badge-optional">opcional</span></td><td>Items por p&aacute;gina (default: 25)</td></tr>
                                </tbody>
                            </table>

                            <h6>Respuesta 200</h6>
                            <div class="code-block"><button class="copy-btn" onclick="copyCode(this)">Copiar</button>{
  <span class="key">"success"</span>: <span class="bool">true</span>,
  <span class="key">"data"</span>: [ <span class="comment">/* evaluaciones */</span> ],
  <span class="key">"meta"</span>: { <span class="key">"current_page"</span>: <span class="number">1</span>, <span class="key">"per_page"</span>: <span class="number">25</span>, <span class="key">"total"</span>: <span class="number">50</span> }
}</div>

                            <div class="try-it" data-method="GET" data-url="/api/v1/evaluations" data-auth="bearer">
                                <h6 style="margin-top:0;">Probar Endpoint</h6>
                                <button class="btn btn-try" onclick="tryEndpoint(this)">
                                    <i class="ri-play-line"></i> Enviar Solicitud
                                </button>
                                <div class="response-status"></div>
                                <div class="response-area"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- GET /evaluations/{id} --}}
                <div class="endpoint-card">
                    <div class="endpoint-header collapsed" data-bs-toggle="collapse" data-bs-target="#ep-get-evaluation">
                        <span class="method-badge method-get">GET</span>
                        <span class="endpoint-path">/api/v1/evaluations/{id}</span>
                        <span class="endpoint-desc">Obtener evaluaci&oacute;n por ID</span>
                        <i class="ri-arrow-down-s-line endpoint-chevron"></i>
                    </div>
                    <div class="collapse" id="ep-get-evaluation">
                        <div class="endpoint-body">
                            <div class="mb-2">
                                <span class="mw-badge mw-auth">Bearer Auth</span>
                                <span class="mw-badge mw-rate">Rate Limit</span>
                            </div>

                            <h6>Par&aacute;metros de Ruta</h6>
                            <table class="params-table">
                                <thead><tr><th>Par&aacute;metro</th><th>Tipo</th><th>Descripci&oacute;n</th></tr></thead>
                                <tbody>
                                    <tr><td><span class="param-name">id</span></td><td><span class="param-type">integer</span> <span class="badge-required">requerido</span></td><td>ID interno de la evaluaci&oacute;n (UserAssignedTest)</td></tr>
                                </tbody>
                            </table>

                            <div class="try-it" data-method="GET" data-url="/api/v1/evaluations/{id}" data-auth="bearer">
                                <h6 style="margin-top:0;">Probar Endpoint</h6>
                                <div class="mb-2">
                                    <label class="form-label" style="font-size:.8rem;">id:</label>
                                    <input type="text" class="form-control form-control-sm path-param" data-param="id" placeholder="55" style="max-width:120px;">
                                </div>
                                <button class="btn btn-try" onclick="tryEndpoint(this)">
                                    <i class="ri-play-line"></i> Enviar Solicitud
                                </button>
                                <div class="response-status"></div>
                                <div class="response-area"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RESULTS --}}
            <div class="api-section">
                <div class="api-section-title"><i class="ri-bar-chart-box-line"></i> Resultados</div>

                {{-- GET /evaluations/{id}/results --}}
                <div class="endpoint-card">
                    <div class="endpoint-header collapsed" data-bs-toggle="collapse" data-bs-target="#ep-get-results">
                        <span class="method-badge method-get">GET</span>
                        <span class="endpoint-path">/api/v1/evaluations/{id}/results</span>
                        <span class="endpoint-desc">Obtener resultados de evaluaci&oacute;n</span>
                        <i class="ri-arrow-down-s-line endpoint-chevron"></i>
                    </div>
                    <div class="collapse" id="ep-get-results">
                        <div class="endpoint-body">
                            <div class="mb-2">
                                <span class="mw-badge mw-auth">Bearer Auth</span>
                                <span class="mw-badge mw-rate">Rate Limit</span>
                            </div>
                            <p style="font-size:.88rem;">Retorna los resultados calculados (scores) de una evaluaci&oacute;n completada. Registra un evento <code>result_queried</code>.</p>

                            <h6>Respuesta 200</h6>
                            <div class="code-block"><button class="copy-btn" onclick="copyCode(this)">Copiar</button>{
  <span class="key">"success"</span>: <span class="bool">true</span>,
  <span class="key">"data"</span>: {
    <span class="key">"user_id"</span>: <span class="number">123</span>,
    <span class="key">"user_name"</span>: <span class="string">"Juan P&eacute;rez"</span>,
    <span class="key">"token"</span>: <span class="string">"eval-token-string"</span>,
    <span class="key">"application"</span>: {
      <span class="key">"id"</span>: <span class="number">10</span>,
      <span class="key">"vacancy"</span>: <span class="string">"Software Engineer"</span>,
      <span class="key">"code"</span>: <span class="string">"APP-2026-001"</span>
    },
    <span class="key">"responses_count"</span>: <span class="number">80</span>,
    <span class="key">"scores"</span>: { <span class="comment">/* estructura var&iacute;a por tipo de test */</span> }
  }
}</div>

                            <div class="try-it" data-method="GET" data-url="/api/v1/evaluations/{id}/results" data-auth="bearer">
                                <h6 style="margin-top:0;">Probar Endpoint</h6>
                                <div class="mb-2">
                                    <label class="form-label" style="font-size:.8rem;">id:</label>
                                    <input type="text" class="form-control form-control-sm path-param" data-param="id" placeholder="55" style="max-width:120px;">
                                </div>
                                <button class="btn btn-try" onclick="tryEndpoint(this)">
                                    <i class="ri-play-line"></i> Enviar Solicitud
                                </button>
                                <div class="response-status"></div>
                                <div class="response-area"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- GET /evaluations/{id}/pdf --}}
                <div class="endpoint-card">
                    <div class="endpoint-header collapsed" data-bs-toggle="collapse" data-bs-target="#ep-get-pdf">
                        <span class="method-badge method-get">GET</span>
                        <span class="endpoint-path">/api/v1/evaluations/{id}/pdf</span>
                        <span class="endpoint-desc">Descargar reporte PDF</span>
                        <i class="ri-arrow-down-s-line endpoint-chevron"></i>
                    </div>
                    <div class="collapse" id="ep-get-pdf">
                        <div class="endpoint-body">
                            <div class="mb-2">
                                <span class="mw-badge mw-auth">Bearer Auth</span>
                                <span class="mw-badge mw-rate">Rate Limit</span>
                            </div>
                            <p style="font-size:.88rem;">Genera y descarga un reporte PDF con los resultados. Retorna <code>Content-Type: application/pdf</code>.</p>

                            <h6>Respuesta 200</h6>
                            <div class="code-block">Content-Type: application/pdf
Content-Disposition: attachment; filename="results_{id}.pdf"

<span class="comment">[Binary PDF stream]</span></div>

                            <div class="try-it" data-method="GET" data-url="/api/v1/evaluations/{id}/pdf" data-auth="bearer">
                                <h6 style="margin-top:0;">Probar Endpoint</h6>
                                <div class="mb-2">
                                    <label class="form-label" style="font-size:.8rem;">id:</label>
                                    <input type="text" class="form-control form-control-sm path-param" data-param="id" placeholder="55" style="max-width:120px;">
                                </div>
                                <button class="btn btn-try" onclick="tryEndpoint(this)">
                                    <i class="ri-play-line"></i> Enviar Solicitud
                                </button>
                                <div class="response-status"></div>
                                <div class="response-area"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- POST /evaluations/{id}/pdf/webhook --}}
                <div class="endpoint-card">
                    <div class="endpoint-header collapsed" data-bs-toggle="collapse" data-bs-target="#ep-post-pdf-webhook">
                        <span class="method-badge method-post">POST</span>
                        <span class="endpoint-path">/api/v1/evaluations/{id}/pdf/webhook</span>
                        <span class="endpoint-desc">Enviar PDF por webhook</span>
                        <i class="ri-arrow-down-s-line endpoint-chevron"></i>
                    </div>
                    <div class="collapse" id="ep-post-pdf-webhook">
                        <div class="endpoint-body">
                            <div class="mb-2">
                                <span class="mw-badge mw-auth">Bearer Auth</span>
                                <span class="mw-badge mw-rate">Rate Limit</span>
                            </div>
                            <p style="font-size:.88rem;">Encola el env&iacute;o as&iacute;ncrono del PDF al webhook configurado del cliente. Requiere tener un <code>webhook_url</code> configurado.</p>

                            <h6>Body</h6>
                            <p class="text-muted" style="font-size:.85rem;">Ninguno</p>

                            <h6>Respuesta 200</h6>
                            <div class="code-block">{ <span class="key">"success"</span>: <span class="bool">true</span>, <span class="key">"message"</span>: <span class="string">"PDF webhook delivery queued."</span> }</div>

                            <h6>Respuesta 422</h6>
                            <div class="code-block">{ <span class="key">"success"</span>: <span class="bool">false</span>, <span class="key">"message"</span>: <span class="string">"No webhook URL configured for this client."</span> }</div>

                            <div class="try-it" data-method="POST" data-url="/api/v1/evaluations/{id}/pdf/webhook" data-auth="bearer">
                                <h6 style="margin-top:0;">Probar Endpoint</h6>
                                <div class="mb-2">
                                    <label class="form-label" style="font-size:.8rem;">id:</label>
                                    <input type="text" class="form-control form-control-sm path-param" data-param="id" placeholder="55" style="max-width:120px;">
                                </div>
                                <button class="btn btn-try" onclick="tryEndpoint(this)">
                                    <i class="ri-play-line"></i> Enviar Solicitud
                                </button>
                                <div class="response-status"></div>
                                <div class="response-area"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- BILLING --}}
            <div class="api-section">
                <div class="api-section-title"><i class="ri-money-dollar-circle-line"></i> Facturaci&oacute;n</div>

                {{-- GET /billing/usage --}}
                <div class="endpoint-card">
                    <div class="endpoint-header collapsed" data-bs-toggle="collapse" data-bs-target="#ep-get-billing-usage">
                        <span class="method-badge method-get">GET</span>
                        <span class="endpoint-path">/api/v1/billing/usage</span>
                        <span class="endpoint-desc">Estado actual de facturaci&oacute;n</span>
                        <i class="ri-arrow-down-s-line endpoint-chevron"></i>
                    </div>
                    <div class="collapse" id="ep-get-billing-usage">
                        <div class="endpoint-body">
                            <div class="mb-2">
                                <span class="mw-badge mw-auth">Bearer Auth</span>
                                <span class="mw-badge mw-rate">Rate Limit</span>
                            </div>
                            <p style="font-size:.88rem;">Retorna el estado de facturaci&oacute;n actual. La estructura var&iacute;a seg&uacute;n el tipo de cliente.</p>

                            <h6>Respuesta por Tipo de Cliente</h6>
                            <ul class="nav nav-tabs mb-3" role="tablist">
                                <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#billing-token">Token</a></li>
                                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#billing-sub">Suscripci&oacute;n</a></li>
                                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#billing-gov">Gobierno</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="billing-token">
                                    <div class="code-block">{
  <span class="key">"data"</span>: {
    <span class="key">"client_type"</span>: <span class="string">"token"</span>,
    <span class="key">"token_balance"</span>: <span class="number">150</span>,
    <span class="key">"tokens_consumed_total"</span>: <span class="number">42</span>
  }
}</div>
                                </div>
                                <div class="tab-pane" id="billing-sub">
                                    <div class="code-block">{
  <span class="key">"data"</span>: {
    <span class="key">"client_type"</span>: <span class="string">"subscription"</span>,
    <span class="key">"subscription_plan"</span>: <span class="string">"default"</span>,
    <span class="key">"subscription_eval_limit"</span>: <span class="number">100</span>,
    <span class="key">"subscription_evals_used"</span>: <span class="number">38</span>,
    <span class="key">"subscription_evals_remaining"</span>: <span class="number">62</span>,
    <span class="key">"subscription_ends_at"</span>: <span class="string">"2026-03-31T23:59:59+00:00"</span>
  }
}</div>
                                </div>
                                <div class="tab-pane" id="billing-gov">
                                    <div class="code-block">{
  <span class="key">"data"</span>: {
    <span class="key">"client_type"</span>: <span class="string">"government"</span>,
    <span class="key">"access"</span>: <span class="string">"unlimited"</span>,
    <span class="key">"evaluations_assigned_total"</span>: <span class="number">1540</span>
  }
}</div>
                                </div>
                            </div>

                            <div class="try-it" data-method="GET" data-url="/api/v1/billing/usage" data-auth="bearer">
                                <h6 style="margin-top:0;">Probar Endpoint</h6>
                                <button class="btn btn-try" onclick="tryEndpoint(this)">
                                    <i class="ri-play-line"></i> Enviar Solicitud
                                </button>
                                <div class="response-status"></div>
                                <div class="response-area"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- GET /billing/history --}}
                <div class="endpoint-card">
                    <div class="endpoint-header collapsed" data-bs-toggle="collapse" data-bs-target="#ep-get-billing-history">
                        <span class="method-badge method-get">GET</span>
                        <span class="endpoint-path">/api/v1/billing/history</span>
                        <span class="endpoint-desc">Historial de uso (paginado)</span>
                        <i class="ri-arrow-down-s-line endpoint-chevron"></i>
                    </div>
                    <div class="collapse" id="ep-get-billing-history">
                        <div class="endpoint-body">
                            <div class="mb-2">
                                <span class="mw-badge mw-auth">Bearer Auth</span>
                                <span class="mw-badge mw-rate">Rate Limit</span>
                            </div>
                            <p style="font-size:.88rem;">Log paginado de todos los eventos de uso de la API.</p>

                            <h6>Query Params</h6>
                            <table class="params-table">
                                <thead><tr><th>Par&aacute;metro</th><th>Tipo</th><th>Descripci&oacute;n</th></tr></thead>
                                <tbody>
                                    <tr><td><span class="param-name">per_page</span></td><td><span class="param-type">integer</span> <span class="badge-optional">opcional</span></td><td>Items por p&aacute;gina (default: 25)</td></tr>
                                </tbody>
                            </table>

                            <h6>Acciones Registradas</h6>
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <code>evaluation_assigned</code>
                                <code>result_queried</code>
                                <code>pdf_downloaded</code>
                                <code>pdf_webhook_sent</code>
                            </div>

                            <div class="try-it" data-method="GET" data-url="/api/v1/billing/history" data-auth="bearer">
                                <h6 style="margin-top:0;">Probar Endpoint</h6>
                                <button class="btn btn-try" onclick="tryEndpoint(this)">
                                    <i class="ri-play-line"></i> Enviar Solicitud
                                </button>
                                <div class="response-status"></div>
                                <div class="response-area"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- WEBHOOKS --}}
            <div class="api-section">
                <div class="api-section-title"><i class="ri-webhook-line"></i> Configuraci&oacute;n de Webhook</div>

                {{-- GET /webhook --}}
                <div class="endpoint-card">
                    <div class="endpoint-header collapsed" data-bs-toggle="collapse" data-bs-target="#ep-get-webhook">
                        <span class="method-badge method-get">GET</span>
                        <span class="endpoint-path">/api/v1/webhook</span>
                        <span class="endpoint-desc">Ver configuraci&oacute;n de webhook</span>
                        <i class="ri-arrow-down-s-line endpoint-chevron"></i>
                    </div>
                    <div class="collapse" id="ep-get-webhook">
                        <div class="endpoint-body">
                            <div class="mb-2">
                                <span class="mw-badge mw-auth">Bearer Auth</span>
                                <span class="mw-badge mw-rate">Rate Limit</span>
                            </div>

                            <h6>Respuesta 200</h6>
                            <div class="code-block">{
  <span class="key">"data"</span>: {
    <span class="key">"webhook_url"</span>: <span class="string">"https://partner.example.com/hooks/psico"</span>,
    <span class="key">"has_secret"</span>: <span class="bool">true</span>
  }
}</div>

                            <div class="try-it" data-method="GET" data-url="/api/v1/webhook" data-auth="bearer">
                                <h6 style="margin-top:0;">Probar Endpoint</h6>
                                <button class="btn btn-try" onclick="tryEndpoint(this)">
                                    <i class="ri-play-line"></i> Enviar Solicitud
                                </button>
                                <div class="response-status"></div>
                                <div class="response-area"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- PUT /webhook --}}
                <div class="endpoint-card">
                    <div class="endpoint-header collapsed" data-bs-toggle="collapse" data-bs-target="#ep-put-webhook">
                        <span class="method-badge method-put">PUT</span>
                        <span class="endpoint-path">/api/v1/webhook</span>
                        <span class="endpoint-desc">Actualizar configuraci&oacute;n de webhook</span>
                        <i class="ri-arrow-down-s-line endpoint-chevron"></i>
                    </div>
                    <div class="collapse" id="ep-put-webhook">
                        <div class="endpoint-body">
                            <div class="mb-2">
                                <span class="mw-badge mw-auth">Bearer Auth</span>
                                <span class="mw-badge mw-rate">Rate Limit</span>
                            </div>

                            <h6>Body (JSON)</h6>
                            <table class="params-table">
                                <thead><tr><th>Campo</th><th>Tipo</th><th>Descripci&oacute;n</th></tr></thead>
                                <tbody>
                                    <tr><td><span class="param-name">webhook_url</span></td><td><span class="param-type">string</span> <span class="badge-required">requerido</span></td><td>URL v&aacute;lida del webhook (max 2048)</td></tr>
                                    <tr><td><span class="param-name">webhook_secret</span></td><td><span class="param-type">string</span> <span class="badge-optional">opcional</span></td><td>Nuevo secreto HMAC-SHA256 (max 255). Si se omite, se conserva el actual.</td></tr>
                                </tbody>
                            </table>

                            <div class="try-it" data-method="PUT" data-url="/api/v1/webhook" data-auth="bearer">
                                <h6 style="margin-top:0;">Probar Endpoint</h6>
                                <textarea class="form-control mb-2 request-body" rows="4" style="font-family:monospace;font-size:.82rem;">{
  "webhook_url": "https://mi-servidor.com/webhook",
  "webhook_secret": "mi-secreto-seguro"
}</textarea>
                                <button class="btn btn-try" onclick="tryEndpoint(this)">
                                    <i class="ri-play-line"></i> Enviar Solicitud
                                </button>
                                <div class="response-status"></div>
                                <div class="response-area"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- POST /webhook/test --}}
                <div class="endpoint-card">
                    <div class="endpoint-header collapsed" data-bs-toggle="collapse" data-bs-target="#ep-post-webhook-test">
                        <span class="method-badge method-post">POST</span>
                        <span class="endpoint-path">/api/v1/webhook/test</span>
                        <span class="endpoint-desc">Enviar webhook de prueba</span>
                        <i class="ri-arrow-down-s-line endpoint-chevron"></i>
                    </div>
                    <div class="collapse" id="ep-post-webhook-test">
                        <div class="endpoint-body">
                            <div class="mb-2">
                                <span class="mw-badge mw-auth">Bearer Auth</span>
                                <span class="mw-badge mw-rate">Rate Limit</span>
                            </div>
                            <p style="font-size:.88rem;">Env&iacute;a un evento de prueba al webhook configurado y retorna el resultado de la entrega.</p>

                            <h6>Respuesta 200 (entrega exitosa)</h6>
                            <div class="code-block">{
  <span class="key">"data"</span>: {
    <span class="key">"success"</span>: <span class="bool">true</span>,
    <span class="key">"delivery_id"</span>: <span class="number">7</span>,
    <span class="key">"http_status"</span>: <span class="number">200</span>,
    <span class="key">"message"</span>: <span class="string">"Webhook delivered successfully."</span>
  }
}</div>

                            <h6>Detalles de Entrega</h6>
                            <ul style="font-size:.85rem;">
                                <li>M&eacute;todo: <code>POST</code> al <code>webhook_url</code></li>
                                <li>Timeout: 30 segundos</li>
                                <li>Headers: <code>X-Webhook-Event</code>, <code>X-Webhook-Delivery</code></li>
                                <li>Si hay secret: <code>X-Webhook-Signature: hmac-sha256(payload, secret)</code></li>
                                <li>Reintentos en caso de falla: 30s, 2m, 10m, 1h, 2h (m&aacute;x 5 intentos)</li>
                            </ul>

                            <div class="try-it" data-method="POST" data-url="/api/v1/webhook/test" data-auth="bearer">
                                <h6 style="margin-top:0;">Probar Endpoint</h6>
                                <button class="btn btn-try" onclick="tryEndpoint(this)">
                                    <i class="ri-play-line"></i> Enviar Solicitud
                                </button>
                                <div class="response-status"></div>
                                <div class="response-area"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ═══════════════════ INTERNAL API ═══════════════════ --}}
            <div class="api-section">
                <div class="api-section-title"><i class="ri-server-line"></i> API Interna (Aprovisionamiento de Clientes)</div>
                <div class="alert alert-secondary mb-3" style="font-size:.85rem;">
                    <i class="ri-shield-keyhole-line"></i>
                    Autenticaci&oacute;n: Header <code>X-Internal-Secret</code> verificado contra la tabla <code>ApiInternalConsumer</code>.
                    Uso exclusivo para comunicaci&oacute;n m&aacute;quina a m&aacute;quina.
                </div>

                {{-- GET /internal/clients --}}
                <div class="endpoint-card">
                    <div class="endpoint-header collapsed" data-bs-toggle="collapse" data-bs-target="#ep-get-int-clients">
                        <span class="method-badge method-get">GET</span>
                        <span class="endpoint-path">/api/internal/clients</span>
                        <span class="endpoint-desc">Listar clientes API</span>
                        <i class="ri-arrow-down-s-line endpoint-chevron"></i>
                    </div>
                    <div class="collapse" id="ep-get-int-clients">
                        <div class="endpoint-body">

                            <h6>Query Params</h6>
                            <table class="params-table">
                                <thead><tr><th>Par&aacute;metro</th><th>Tipo</th><th>Descripci&oacute;n</th></tr></thead>
                                <tbody>
                                    <tr><td><span class="param-name">employer_id</span></td><td><span class="param-type">integer</span> <span class="badge-optional">opcional</span></td><td>Filtrar por employer_id en el campo notes</td></tr>
                                </tbody>
                            </table>

                            <h6>Respuesta 200</h6>
                            <div class="code-block"><button class="copy-btn" onclick="copyCode(this)">Copiar</button>{
  <span class="key">"data"</span>: [
    {
      <span class="key">"client_id"</span>: <span class="number">1</span>,
      <span class="key">"slug"</span>: <span class="string">"acme-corp"</span>,
      <span class="key">"name"</span>: <span class="string">"ACME Corp"</span>,
      <span class="key">"client_type"</span>: <span class="string">"government"</span>,
      <span class="key">"is_active"</span>: <span class="bool">true</span>,
      <span class="key">"company_id"</span>: <span class="number">10</span>
    }
  ]
}</div>

                            <div class="try-it" data-method="GET" data-url="/api/internal/clients" data-auth="internal">
                                <h6 style="margin-top:0;">Probar Endpoint</h6>
                                <button class="btn btn-try" onclick="tryEndpoint(this)">
                                    <i class="ri-play-line"></i> Enviar Solicitud
                                </button>
                                <div class="response-status"></div>
                                <div class="response-area"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- POST /internal/clients --}}
                <div class="endpoint-card">
                    <div class="endpoint-header collapsed" data-bs-toggle="collapse" data-bs-target="#ep-post-int-clients">
                        <span class="method-badge method-post">POST</span>
                        <span class="endpoint-path">/api/internal/clients</span>
                        <span class="endpoint-desc">Crear/reactivar cliente API</span>
                        <i class="ri-arrow-down-s-line endpoint-chevron"></i>
                    </div>
                    <div class="collapse" id="ep-post-int-clients">
                        <div class="endpoint-body">
                            <p style="font-size:.88rem;">Crea un nuevo cliente API y emite su primer token Sanctum. Si un cliente con el mismo slug fue eliminado, lo restaura y emite un token nuevo.</p>

                            <h6>Body (JSON)</h6>
                            <table class="params-table">
                                <thead><tr><th>Campo</th><th>Tipo</th><th>Descripci&oacute;n</th></tr></thead>
                                <tbody>
                                    <tr><td><span class="param-name">name</span></td><td><span class="param-type">string</span> <span class="badge-required">requerido</span></td><td>Nombre del cliente (se genera slug autom&aacute;ticamente)</td></tr>
                                    <tr><td><span class="param-name">email</span></td><td><span class="param-type">string</span> <span class="badge-required">requerido</span></td><td>Email de contacto</td></tr>
                                    <tr><td><span class="param-name">company_id</span></td><td><span class="param-type">integer</span> <span class="badge-optional">opcional</span></td><td>ID de compa&ntilde;&iacute;a interna</td></tr>
                                    <tr><td><span class="param-name">client_type</span></td><td><span class="param-type">string</span> <span class="badge-optional">opcional</span></td><td><code>token</code> | <code>government</code> | <code>subscription</code> (default: government)</td></tr>
                                    <tr><td><span class="param-name">employer_id</span></td><td><span class="param-type">integer</span> <span class="badge-optional">opcional</span></td><td>Almacenado en notes</td></tr>
                                    <tr><td><span class="param-name">token_balance</span></td><td><span class="param-type">integer</span> <span class="badge-optional">opcional</span></td><td>Balance inicial (solo tipo token, default: 0)</td></tr>
                                    <tr><td><span class="param-name">subscription_days</span></td><td><span class="param-type">integer</span> <span class="badge-optional">opcional</span></td><td>Duraci&oacute;n en d&iacute;as (solo tipo subscription, default: 30)</td></tr>
                                    <tr><td><span class="param-name">subscription_eval_limit</span></td><td><span class="param-type">integer</span> <span class="badge-optional">opcional</span></td><td>L&iacute;mite de evaluaciones (solo tipo subscription, default: 100)</td></tr>
                                </tbody>
                            </table>

                            <h6>Respuesta 201</h6>
                            <div class="code-block"><button class="copy-btn" onclick="copyCode(this)">Copiar</button>{
  <span class="key">"data"</span>: {
    <span class="key">"client_id"</span>: <span class="number">5</span>,
    <span class="key">"slug"</span>: <span class="string">"acme-corp"</span>,
    <span class="key">"client_type"</span>: <span class="string">"token"</span>,
    <span class="key">"is_active"</span>: <span class="bool">true</span>,
    <span class="key">"api_token"</span>: <span class="string">"1|plaintexttoken..."</span>
  }
}
<span class="comment">// IMPORTANTE: El api_token solo se muestra una vez.</span></div>

                            <div class="try-it" data-method="POST" data-url="/api/internal/clients" data-auth="internal">
                                <h6 style="margin-top:0;">Probar Endpoint</h6>
                                <textarea class="form-control mb-2 request-body" rows="5" style="font-family:monospace;font-size:.82rem;">{
  "name": "ACME Corp",
  "email": "admin@acme.com",
  "client_type": "government"
}</textarea>
                                <button class="btn btn-try" onclick="tryEndpoint(this)">
                                    <i class="ri-play-line"></i> Enviar Solicitud
                                </button>
                                <div class="response-status"></div>
                                <div class="response-area"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- GET /internal/clients/{slug} --}}
                <div class="endpoint-card">
                    <div class="endpoint-header collapsed" data-bs-toggle="collapse" data-bs-target="#ep-get-int-client">
                        <span class="method-badge method-get">GET</span>
                        <span class="endpoint-path">/api/internal/clients/{slug}</span>
                        <span class="endpoint-desc">Detalle de cliente por slug</span>
                        <i class="ri-arrow-down-s-line endpoint-chevron"></i>
                    </div>
                    <div class="collapse" id="ep-get-int-client">
                        <div class="endpoint-body">

                            <h6>Par&aacute;metros de Ruta</h6>
                            <table class="params-table">
                                <thead><tr><th>Par&aacute;metro</th><th>Tipo</th><th>Descripci&oacute;n</th></tr></thead>
                                <tbody>
                                    <tr><td><span class="param-name">slug</span></td><td><span class="param-type">string</span> <span class="badge-required">requerido</span></td><td>Slug del cliente (generado del nombre)</td></tr>
                                </tbody>
                            </table>

                            <h6>Respuesta 200</h6>
                            <div class="code-block"><button class="copy-btn" onclick="copyCode(this)">Copiar</button>{
  <span class="key">"data"</span>: {
    <span class="key">"client_id"</span>: <span class="number">5</span>,
    <span class="key">"slug"</span>: <span class="string">"acme-corp"</span>,
    <span class="key">"name"</span>: <span class="string">"ACME Corp"</span>,
    <span class="key">"client_type"</span>: <span class="string">"token"</span>,
    <span class="key">"is_active"</span>: <span class="bool">true</span>,
    <span class="key">"has_token"</span>: <span class="bool">true</span>,
    <span class="key">"billing"</span>: {
      <span class="key">"token_balance"</span>: <span class="number">150</span>,
      <span class="key">"subscription_plan"</span>: <span class="null-val">null</span>
    }
  }
}</div>

                            <div class="try-it" data-method="GET" data-url="/api/internal/clients/{slug}" data-auth="internal">
                                <h6 style="margin-top:0;">Probar Endpoint</h6>
                                <div class="mb-2">
                                    <label class="form-label" style="font-size:.8rem;">slug:</label>
                                    <input type="text" class="form-control form-control-sm path-param" data-param="slug" placeholder="acme-corp" style="max-width:200px;">
                                </div>
                                <button class="btn btn-try" onclick="tryEndpoint(this)">
                                    <i class="ri-play-line"></i> Enviar Solicitud
                                </button>
                                <div class="response-status"></div>
                                <div class="response-area"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- PATCH /internal/clients/{slug}/toggle --}}
                <div class="endpoint-card">
                    <div class="endpoint-header collapsed" data-bs-toggle="collapse" data-bs-target="#ep-patch-int-toggle">
                        <span class="method-badge method-patch">PATCH</span>
                        <span class="endpoint-path">/api/internal/clients/{slug}/toggle</span>
                        <span class="endpoint-desc">Activar/desactivar cliente</span>
                        <i class="ri-arrow-down-s-line endpoint-chevron"></i>
                    </div>
                    <div class="collapse" id="ep-patch-int-toggle">
                        <div class="endpoint-body">
                            <p style="font-size:.88rem;">Alterna el estado activo/inactivo del cliente. Si se reactiva sin tokens existentes, genera uno nuevo.</p>

                            <h6>Body (JSON)</h6>
                            <table class="params-table">
                                <thead><tr><th>Campo</th><th>Tipo</th><th>Descripci&oacute;n</th></tr></thead>
                                <tbody>
                                    <tr><td><span class="param-name">enable</span></td><td><span class="param-type">boolean</span> <span class="badge-optional">opcional</span></td><td>Forzar estado. Si se omite, alterna el actual.</td></tr>
                                </tbody>
                            </table>

                            <h6>Respuesta 200</h6>
                            <div class="code-block">{
  <span class="key">"data"</span>: {
    <span class="key">"client_id"</span>: <span class="number">5</span>,
    <span class="key">"slug"</span>: <span class="string">"acme-corp"</span>,
    <span class="key">"is_active"</span>: <span class="bool">true</span>,
    <span class="key">"api_token"</span>: <span class="string">"3|newtoken..."</span> <span class="comment">// solo si se gener&oacute; nuevo</span>
  }
}</div>

                            <div class="try-it" data-method="PATCH" data-url="/api/internal/clients/{slug}/toggle" data-auth="internal">
                                <h6 style="margin-top:0;">Probar Endpoint</h6>
                                <div class="mb-2">
                                    <label class="form-label" style="font-size:.8rem;">slug:</label>
                                    <input type="text" class="form-control form-control-sm path-param" data-param="slug" placeholder="acme-corp" style="max-width:200px;">
                                </div>
                                <textarea class="form-control mb-2 request-body" rows="3" style="font-family:monospace;font-size:.82rem;">{
  "enable": true
}</textarea>
                                <button class="btn btn-try" onclick="tryEndpoint(this)">
                                    <i class="ri-play-line"></i> Enviar Solicitud
                                </button>
                                <div class="response-status"></div>
                                <div class="response-area"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Client types summary --}}
            <div class="card mb-4">
                <div class="card-body">
                    <h6 class="card-title fw-bold mb-3"><i class="ri-group-line"></i> Tipos de Cliente</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0" style="font-size:.85rem;">
                            <thead class="table-light">
                                <tr><th>Tipo</th><th>Modelo de Facturaci&oacute;n</th><th>Cuota</th><th>Unidad de Costo</th></tr>
                            </thead>
                            <tbody>
                                <tr><td><code>government</code></td><td>Sin facturaci&oacute;n</td><td>Ilimitada</td><td>N/A</td></tr>
                                <tr><td><code>token</code></td><td>Balance de tokens</td><td>Pre-verificado por request</td><td><code>token_cost</code> por test (tabla ApiTestTokenCost)</td></tr>
                                <tr><td><code>subscription</code></td><td>L&iacute;mite de evals + fecha de expiraci&oacute;n</td><td>Pre-verificado por request</td><td>1 eval por test asignado</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function copyCode(btn) {
    const block = btn.parentElement;
    const text = block.textContent.replace('Copiar', '').trim();
    navigator.clipboard.writeText(text).then(() => {
        btn.textContent = 'Copiado!';
        setTimeout(() => btn.textContent = 'Copiar', 1500);
    });
}

function tryEndpoint(btn) {
    const tryIt = btn.closest('.try-it');
    const method = tryIt.dataset.method;
    const authType = tryIt.dataset.auth;
    let url = tryIt.dataset.url;

    // Replace path params
    const pathParams = tryIt.querySelectorAll('.path-param');
    pathParams.forEach(input => {
        const param = input.dataset.param;
        const val = input.value.trim();
        if (!val) {
            alert('Completa el parámetro: ' + param);
            return;
        }
        url = url.replace('{' + param + '}', encodeURIComponent(val));
    });

    // Check url still has unreplaced params
    if (url.includes('{')) {
        alert('Completa todos los parámetros de ruta.');
        return;
    }

    // Build headers
    const headers = {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
    };

    if (authType === 'bearer') {
        const token = document.getElementById('apiToken').value.trim();
        if (!token) {
            alert('Ingresa tu API Token (Bearer) en la sección de autenticación.');
            return;
        }
        headers['Authorization'] = 'Bearer ' + token;
    } else if (authType === 'internal') {
        const secret = document.getElementById('internalSecret').value.trim();
        if (!secret) {
            alert('Ingresa tu Internal Secret en la sección de autenticación.');
            return;
        }
        headers['X-Internal-Secret'] = secret;
    }

    // Build request options
    const options = { method: method, headers: headers };

    // Body for POST/PUT/PATCH
    if (['POST', 'PUT', 'PATCH'].includes(method)) {
        const bodyArea = tryIt.querySelector('.request-body');
        if (bodyArea && bodyArea.value.trim()) {
            try {
                JSON.parse(bodyArea.value.trim());
                options.body = bodyArea.value.trim();
            } catch(e) {
                alert('El JSON del body no es válido: ' + e.message);
                return;
            }
        }
    }

    // Show loading
    btn.disabled = true;
    btn.innerHTML = '<i class="ri-loader-4-line"></i> Enviando...';

    const responseStatus = tryIt.querySelector('.response-status');
    const responseArea = tryIt.querySelector('.response-area');
    responseStatus.style.display = 'none';
    responseArea.style.display = 'none';

    fetch(url, options)
        .then(async response => {
            const status = response.status;
            const statusText = response.statusText;

            responseStatus.style.display = 'block';
            responseStatus.className = 'response-status';

            if (status >= 200 && status < 300) {
                responseStatus.classList.add('s2xx');
            } else if (status >= 400 && status < 500) {
                responseStatus.classList.add('s4xx');
            } else {
                responseStatus.classList.add('s5xx');
            }
            responseStatus.textContent = 'HTTP ' + status + ' ' + statusText;

            const contentType = response.headers.get('content-type') || '';
            if (contentType.includes('application/json')) {
                const data = await response.json();
                responseArea.textContent = JSON.stringify(data, null, 2);
            } else if (contentType.includes('application/pdf')) {
                responseArea.textContent = '[PDF Binary - ' + (response.headers.get('content-length') || '?') + ' bytes]';
            } else {
                const text = await response.text();
                responseArea.textContent = text.substring(0, 2000);
            }
            responseArea.style.display = 'block';
        })
        .catch(err => {
            responseStatus.style.display = 'block';
            responseStatus.className = 'response-status s5xx';
            responseStatus.textContent = 'Error de red';
            responseArea.style.display = 'block';
            responseArea.textContent = err.message;
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = '<i class="ri-play-line"></i> Enviar Solicitud';
        });
}
</script>
@endpush
