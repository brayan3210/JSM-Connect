@extends('layouts.app')

@section('title', 'Política de Tratamiento de Datos Personales')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Botón de volver -->
            <div class="mb-3">
                <a href="javascript:history.back()" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Volver
                </a>
            </div>

            <!-- Contenedor principal -->
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h1 class="mb-3">🔐 JSM CONNECT</h1>
                    <h2 class="h4 mb-0">POLÍTICA DE TRATAMIENTO DE DATOS PERSONALES</h2>
                    <p class="mb-0 mt-2">Versión {{ $version }} • {{ $date }}</p>
                </div>

                <!-- Botones de acción -->
                <div class="card-body py-4">
                    <div class="text-center mb-4">
                        <a href="{{ route('policy.data.download') }}" class="btn btn-primary me-2">
                            <i class="fas fa-download me-1"></i>Descargar PDF
                        </a>
                        <a href="{{ route('policy.data', ['format' => 'pdf']) }}" class="btn btn-outline-primary me-2" target="_blank">
                            <i class="fas fa-file-pdf me-1"></i>Ver en PDF
                        </a>
                        <button onclick="window.print()" class="btn btn-outline-secondary">
                            <i class="fas fa-print me-1"></i>Imprimir
                        </button>
                    </div>

                    <!-- Contenido de la política -->
                    <div class="policy-content">
                        <!-- 1. Introducción -->
                        <section class="mb-4">
                            <h3 class="text-primary border-bottom pb-2">1. INTRODUCCIÓN Y OBJETO</h3>
                            <div class="mb-3">
                                <p>JSM Connect, en cumplimiento de la <strong>Ley 1581 de 2012</strong> y del <strong>Decreto 1377 de 2013</strong>, y demás normas concordantes, ha adoptado la presente Política de Tratamiento de Datos Personales, con el objeto de establecer los lineamientos, principios y procedimientos que rigen el tratamiento de datos personales que realiza nuestra plataforma digital de servicios profesionales.</p>
                                
                                <p>Esta política aplica a todos los datos personales que JSM Connect recolecte, almacene, use, circule o suprima en desarrollo de su objeto social, específicamente la conexión entre profesionales y usuarios que requieren servicios especializados.</p>
                                
                                <div class="alert alert-warning d-flex align-items-center">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <div>
                                        <strong>Importante:</strong> El registro y uso de nuestra plataforma implica la aceptación expresa de esta política y el consentimiento para el tratamiento de sus datos personales conforme a los términos aquí establecidos.
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- 2. Definiciones -->
                        <section class="mb-4">
                            <h3 class="text-primary border-bottom pb-2">2. DEFINICIONES</h3>
                            <p>Para efectos de esta política, se adoptan las siguientes definiciones conforme a la normatividad vigente:</p>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li class="mb-2"><strong>Autorización:</strong> Consentimiento previo, expreso e informado del titular para llevar a cabo el tratamiento de datos personales.</li>
                                        <li class="mb-2"><strong>Base de Datos:</strong> Conjunto organizado de datos personales que sea objeto de tratamiento.</li>
                                        <li class="mb-2"><strong>Dato Personal:</strong> Cualquier información vinculada o que pueda asociarse a una o varias personas naturales determinadas o determinables.</li>
                                        <li class="mb-2"><strong>Dato Público:</strong> Es el dato que no sea semiprivado, privado o sensible.</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li class="mb-2"><strong>Dato Semiprivado:</strong> Es aquel que no tiene naturaleza íntima, reservada, ni pública y cuyo conocimiento o divulgación puede interesar no sólo a su titular sino a cierto sector o grupo de personas.</li>
                                        <li class="mb-2"><strong>Dato Privado:</strong> Es el dato que por su naturaleza íntima o reservada sólo es relevante para el titular.</li>
                                        <li class="mb-2"><strong>Responsable del Tratamiento:</strong> Persona natural o jurídica, pública o privada, que por sí misma o en asocio con otros, decida sobre la base de datos y/o el tratamiento de los datos.</li>
                                        <li class="mb-2"><strong>Titular:</strong> Persona natural cuyos datos personales sean objeto de tratamiento.</li>
                                    </ul>
                                </div>
                            </div>
                        </section>

                        <!-- 3. Responsable -->
                        <section class="mb-4">
                            <h3 class="text-primary border-bottom pb-2">3. IDENTIFICACIÓN DEL RESPONSABLE</h3>
                            <div class="bg-light p-3 rounded">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Razón Social:</strong> JSM Connect</p>
                                        <p><strong>Plataforma:</strong> Sistema Digital de Conexión de Servicios Profesionales</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Correo Electrónico:</strong> privacidad@jsmconnect.com</p>
                                        <p><strong>Sitio Web:</strong> www.jsmconnect.com</p>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- 4. Tipos de Datos -->
                        <section class="mb-4">
                            <h3 class="text-primary border-bottom pb-2">4. TIPOS DE DATOS TRATADOS</h3>
                            <p>JSM Connect recolecta y trata los siguientes tipos de datos personales:</p>
                            
                            <div class="accordion" id="datosAccordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="datosIdentificacion">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseIdentificacion">
                                            <strong>4.1. Datos de Identificación</strong>
                                        </button>
                                    </h2>
                                    <div id="collapseIdentificacion" class="accordion-collapse collapse show" data-bs-parent="#datosAccordion">
                                        <div class="accordion-body">
                                            <ul>
                                                <li>Nombres y apellidos completos</li>
                                                <li>Tipo y número de documento de identidad</li>
                                                <li>Género</li>
                                                <li>Profesión u ocupación</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="datosContacto">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseContacto">
                                            <strong>4.2. Datos de Contacto</strong>
                                        </button>
                                    </h2>
                                    <div id="collapseContacto" class="accordion-collapse collapse" data-bs-parent="#datosAccordion">
                                        <div class="accordion-body">
                                            <ul>
                                                <li>Dirección de correo electrónico</li>
                                                <li>Número telefónico</li>
                                                <li>Dirección de residencia (cuando aplique)</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="datosPlataforma">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePlataforma">
                                            <strong>4.3. Datos de la Plataforma</strong>
                                        </button>
                                    </h2>
                                    <div id="collapsePlataforma" class="accordion-collapse collapse" data-bs-parent="#datosAccordion">
                                        <div class="accordion-body">
                                            <ul>
                                                <li>Información de preferencias y hobbies</li>
                                                <li>Especialidades profesionales</li>
                                                <li>Servicios ofrecidos y solicitados</li>
                                                <li>Valoraciones y comentarios</li>
                                                <li>Historial de transacciones y solicitudes</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- 5. Finalidades -->
                        <section class="mb-4">
                            <h3 class="text-primary border-bottom pb-2">5. FINALIDADES DEL TRATAMIENTO</h3>
                            <p>Los datos personales son tratados para las siguientes finalidades:</p>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="list-group">
                                        <div class="list-group-item">
                                            <strong>a) Registro y Autenticación:</strong><br>
                                            <small class="text-muted">Crear y mantener cuentas de usuario, verificar identidad y garantizar la seguridad de acceso.</small>
                                        </div>
                                        <div class="list-group-item">
                                            <strong>b) Prestación del Servicio:</strong><br>
                                            <small class="text-muted">Facilitar la conexión entre profesionales y usuarios, gestionar solicitudes de servicios.</small>
                                        </div>
                                        <div class="list-group-item">
                                            <strong>c) Comunicación:</strong><br>
                                            <small class="text-muted">Enviar notificaciones, actualizaciones, mensajes relacionados con los servicios.</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="list-group">
                                        <div class="list-group-item">
                                            <strong>d) Mejora de la Plataforma:</strong><br>
                                            <small class="text-muted">Analizar el uso de la plataforma para mejorar funcionalidades y experiencia del usuario.</small>
                                        </div>
                                        <div class="list-group-item">
                                            <strong>e) Cumplimiento Legal:</strong><br>
                                            <small class="text-muted">Dar cumplimiento a obligaciones legales, regulatorias y requerimientos de autoridades.</small>
                                        </div>
                                        <div class="list-group-item">
                                            <strong>f) Seguridad:</strong><br>
                                            <small class="text-muted">Prevenir fraudes, detectar actividades sospechosas y proteger la seguridad.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- 6. Derechos -->
                        <section class="mb-4">
                            <h3 class="text-primary border-bottom pb-2">6. DERECHOS DE LOS TITULARES</h3>
                            <p>Como titular de datos personales, usted tiene los siguientes derechos:</p>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card bg-light h-100">
                                        <div class="card-body">
                                            <h6 class="card-title text-primary">🔍 Derecho de Acceso</h6>
                                            <p class="card-text small">Conocer, actualizar y rectificar sus datos personales.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-light h-100">
                                        <div class="card-body">
                                            <h6 class="card-title text-primary">✏️ Derecho de Rectificación</h6>
                                            <p class="card-text small">Corregir datos erróneos o inexactos.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-light h-100">
                                        <div class="card-body">
                                            <h6 class="card-title text-primary">🗑️ Derecho de Supresión</h6>
                                            <p class="card-text small">Solicitar la eliminación de sus datos cuando no sean necesarios.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="alert alert-info mt-3 d-flex align-items-center">
                                <i class="fas fa-info-circle me-2"></i>
                                <div>
                                    <strong>Ejercicio de Derechos:</strong> Para ejercer cualquiera de estos derechos, puede contactarnos a través de <a href="mailto:privacidad@jsmconnect.com">privacidad@jsmconnect.com</a> o mediante los canales de atención disponibles en la plataforma.
                                </div>
                            </div>
                        </section>

                        <!-- 7. Seguridad -->
                        <section class="mb-4">
                            <h3 class="text-primary border-bottom pb-2">7. MEDIDAS DE SEGURIDAD</h3>
                            <p>JSM Connect implementa las siguientes medidas técnicas y administrativas:</p>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">🔐 Encriptación de datos sensibles y contraseñas</li>
                                        <li class="list-group-item">🛡️ Protocolos de seguridad HTTPS</li>
                                        <li class="list-group-item">🔑 Controles de acceso robustos</li>
                                        <li class="list-group-item">👁️ Monitoreo continuo de actividades</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">💾 Respaldos regulares y seguros</li>
                                        <li class="list-group-item">👨‍🏫 Capacitación del personal</li>
                                        <li class="list-group-item">🔍 Auditorías periódicas de seguridad</li>
                                        <li class="list-group-item">🚨 Sistemas de detección de amenazas</li>
                                    </ul>
                                </div>
                            </div>
                        </section>

                        <!-- 8. Contacto -->
                        <section class="mb-4">
                            <h3 class="text-primary border-bottom pb-2">8. CONTACTO Y CONSULTAS</h3>
                            <div class="bg-light p-4 rounded">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>📧 Correo Electrónico:</h6>
                                        <p><a href="mailto:privacidad@jsmconnect.com">privacidad@jsmconnect.com</a></p>
                                        
                                        <h6>📞 Línea de Atención:</h6>
                                        <p>+57 (1) 123-4567</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>⏰ Horario de Atención:</h6>
                                        <p>Lunes a Viernes, 8:00 AM - 6:00 PM</p>
                                        
                                        <h6>🌐 Sitio Web:</h6>
                                        <p><a href="http://www.jsmconnect.com" target="_blank">www.jsmconnect.com</a></p>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Footer -->
                        <section class="text-center pt-4 border-top">
                            <h5 class="text-primary">JSM Connect - Política de Tratamiento de Datos Personales</h5>
                            <p class="mb-1">Versión {{ $version }} • Vigente desde {{ $date }}</p>
                            <p class="text-muted">© {{ now()->year }} JSM Connect. Todos los derechos reservados.</p>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .btn, .card-header .btn {
        display: none !important;
    }
    
    .card {
        border: none !important;
        box-shadow: none !important;
    }
}
</style>
@endsection 