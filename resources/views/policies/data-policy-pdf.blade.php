<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Política de Tratamiento de Datos Personales - JSM Connect</title>
    <style>
        @page {
            margin: 2cm;
            @top-center {
                content: "Política de Tratamiento de Datos Personales - JSM Connect";
                font-size: 10px;
                color: #666;
            }
            @bottom-center {
                content: "Página " counter(page) " de " counter(pages);
                font-size: 10px;
                color: #666;
            }
        }

        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            font-size: 11px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #5245E5;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #5245E5;
            margin-bottom: 10px;
        }

        .document-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin: 15px 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .document-info {
            font-size: 10px;
            color: #666;
            margin-bottom: 5px;
        }

        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #5245E5;
            margin-bottom: 12px;
            padding-bottom: 5px;
            border-bottom: 1px solid #e0e0e0;
            text-transform: uppercase;
        }

        .subsection-title {
            font-size: 12px;
            font-weight: bold;
            color: #333;
            margin: 15px 0 8px 0;
        }

        .paragraph {
            margin-bottom: 12px;
            text-align: justify;
            text-indent: 15px;
        }

        .list {
            margin-left: 20px;
            margin-bottom: 12px;
        }

        .list-item {
            margin-bottom: 8px;
            text-align: justify;
        }

        .highlight {
            background-color: #f8f9fa;
            padding: 12px;
            border-left: 4px solid #5245E5;
            margin: 15px 0;
            font-style: italic;
        }

        .contact-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 10px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #5245E5;
            color: white;
            font-weight: bold;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #5245E5;
            text-align: center;
            font-size: 10px;
            color: #666;
        }

        .page-break {
            page-break-before: always;
        }

        .text-center {
            text-align: center;
        }

        .text-bold {
            font-weight: bold;
        }

        .text-italic {
            font-style: italic;
        }

        .mb-0 {
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="logo">🔐 JSM CONNECT</div>
        <div class="document-title">Política de Tratamiento de Datos Personales</div>
        <div class="document-info">Versión: {{ $version }}</div>
        <div class="document-info">Fecha de vigencia: {{ $date }}</div>
        <div class="document-info">Documento generado automáticamente</div>
    </div>

    <!-- 1. Introducción -->
    <div class="section">
        <div class="section-title">1. Introducción y Objeto</div>
        <div class="paragraph">
            JSM Connect, en cumplimiento de la Ley 1581 de 2012 y del Decreto 1377 de 2013, y demás normas concordantes, ha adoptado la presente Política de Tratamiento de Datos Personales, con el objeto de establecer los lineamientos, principios y procedimientos que rigen el tratamiento de datos personales que realiza nuestra plataforma digital de servicios profesionales.
        </div>
        <div class="paragraph">
            Esta política aplica a todos los datos personales que JSM Connect recolecte, almacene, use, circule o suprima en desarrollo de su objeto social, específicamente la conexión entre profesionales y usuarios que requieren servicios especializados.
        </div>
        <div class="highlight">
            <strong>Importante:</strong> El registro y uso de nuestra plataforma implica la aceptación expresa de esta política y el consentimiento para el tratamiento de sus datos personales conforme a los términos aquí establecidos.
        </div>
    </div>

    <!-- 2. Definiciones -->
    <div class="section">
        <div class="section-title">2. Definiciones</div>
        <div class="paragraph">
            Para efectos de esta política, se adoptan las siguientes definiciones conforme a la normatividad vigente:
        </div>
        
        <div class="list">
            <div class="list-item"><strong>Autorización:</strong> Consentimiento previo, expreso e informado del titular para llevar a cabo el tratamiento de datos personales.</div>
            <div class="list-item"><strong>Base de Datos:</strong> Conjunto organizado de datos personales que sea objeto de tratamiento.</div>
            <div class="list-item"><strong>Dato Personal:</strong> Cualquier información vinculada o que pueda asociarse a una o varias personas naturales determinadas o determinables.</div>
            <div class="list-item"><strong>Dato Público:</strong> Es el dato que no sea semiprivado, privado o sensible.</div>
            <div class="list-item"><strong>Dato Semiprivado:</strong> Es aquel que no tiene naturaleza íntima, reservada, ni pública y cuyo conocimiento o divulgación puede interesar no sólo a su titular sino a cierto sector o grupo de personas.</div>
            <div class="list-item"><strong>Dato Privado:</strong> Es el dato que por su naturaleza íntima o reservada sólo es relevante para el titular.</div>
            <div class="list-item"><strong>Dato Sensible:</strong> Se entiende por datos sensibles aquellos que afectan la intimidad del titular o cuyo uso indebido puede generar su discriminación.</div>
            <div class="list-item"><strong>Responsable del Tratamiento:</strong> Persona natural o jurídica, pública o privada, que por sí misma o en asocio con otros, decida sobre la base de datos y/o el tratamiento de los datos.</div>
            <div class="list-item"><strong>Titular:</strong> Persona natural cuyos datos personales sean objeto de tratamiento.</div>
            <div class="list-item"><strong>Tratamiento:</strong> Cualquier operación o conjunto de operaciones sobre datos personales.</div>
        </div>
    </div>

    <!-- 3. Identificación del Responsable -->
    <div class="section">
        <div class="section-title">3. Identificación del Responsable del Tratamiento</div>
        <div class="contact-info">
            <div class="paragraph mb-0"><strong>Razón Social:</strong> JSM Connect</div>
            <div class="paragraph mb-0"><strong>Plataforma:</strong> Sistema Digital de Conexión de Servicios Profesionales</div>
            <div class="paragraph mb-0"><strong>Correo Electrónico:</strong> privacidad@jsmconnect.com</div>
            <div class="paragraph mb-0"><strong>Sitio Web:</strong> www.jsmconnect.com</div>
            <div class="paragraph mb-0"><strong>Responsable de Datos:</strong> Departamento de Privacidad y Protección de Datos</div>
        </div>
    </div>

    <!-- 4. Tipos de Datos -->
    <div class="section">
        <div class="section-title">4. Tipos de Datos Personales Tratados</div>
        <div class="paragraph">
            JSM Connect recolecta y trata los siguientes tipos de datos personales:
        </div>
        
        <div class="subsection-title">4.1. Datos de Identificación:</div>
        <div class="list">
            <div class="list-item">• Nombres y apellidos completos</div>
            <div class="list-item">• Tipo y número de documento de identidad</div>
            <div class="list-item">• Género</div>
            <div class="list-item">• Profesión u ocupación</div>
        </div>

        <div class="subsection-title">4.2. Datos de Contacto:</div>
        <div class="list">
            <div class="list-item">• Dirección de correo electrónico</div>
            <div class="list-item">• Número telefónico</div>
            <div class="list-item">• Dirección de residencia (cuando aplique)</div>
        </div>

        <div class="subsection-title">4.3. Datos de la Plataforma:</div>
        <div class="list">
            <div class="list-item">• Información de preferencias y hobbies</div>
            <div class="list-item">• Especialidades profesionales</div>
            <div class="list-item">• Servicios ofrecidos y solicitados</div>
            <div class="list-item">• Valoraciones y comentarios</div>
            <div class="list-item">• Historial de transacciones y solicitudes</div>
        </div>

        <div class="subsection-title">4.4. Datos Técnicos:</div>
        <div class="list">
            <div class="list-item">• Dirección IP</div>
            <div class="list-item">• Información del navegador y dispositivo</div>
            <div class="list-item">• Cookies y tecnologías similares</div>
            <div class="list-item">• Logs de actividad en la plataforma</div>
        </div>
    </div>

    <!-- 5. Finalidades del Tratamiento -->
    <div class="section">
        <div class="section-title">5. Finalidades del Tratamiento</div>
        <div class="paragraph">
            Los datos personales son tratados para las siguientes finalidades:
        </div>

        <div class="list">
            <div class="list-item"><strong>a) Registro y Autenticación:</strong> Crear y mantener cuentas de usuario, verificar identidad y garantizar la seguridad de acceso.</div>
            <div class="list-item"><strong>b) Prestación del Servicio:</strong> Facilitar la conexión entre profesionales y usuarios, gestionar solicitudes de servicios y pagos.</div>
            <div class="list-item"><strong>c) Comunicación:</strong> Enviar notificaciones, actualizaciones, mensajes relacionados con los servicios y soporte técnico.</div>
            <div class="list-item"><strong>d) Mejora de la Plataforma:</strong> Analizar el uso de la plataforma para mejorar funcionalidades y experiencia del usuario.</div>
            <div class="list-item"><strong>e) Cumplimiento Legal:</strong> Dar cumplimiento a obligaciones legales, regulatorias y requerimientos de autoridades competentes.</div>
            <div class="list-item"><strong>f) Seguridad:</strong> Prevenir fraudes, detectar actividades sospechosas y proteger la seguridad de la plataforma.</div>
            <div class="list-item"><strong>g) Marketing:</strong> Enviar información promocional y comunicaciones de marketing (previa autorización).</div>
        </div>
    </div>

    <!-- Page Break -->
    <div class="page-break"></div>

    <!-- 6. Derechos de los Titulares -->
    <div class="section">
        <div class="section-title">6. Derechos de los Titulares</div>
        <div class="paragraph">
            Como titular de datos personales, usted tiene los siguientes derechos:
        </div>

        <div class="list">
            <div class="list-item"><strong>Derecho de Acceso:</strong> Conocer, actualizar y rectificar sus datos personales.</div>
            <div class="list-item"><strong>Derecho de Actualización:</strong> Solicitar la actualización de datos inexactos o incompletos.</div>
            <div class="list-item"><strong>Derecho de Rectificación:</strong> Corregir datos erróneos o inexactos.</div>
            <div class="list-item"><strong>Derecho de Supresión:</strong> Solicitar la eliminación de sus datos cuando no sean necesarios.</div>
            <div class="list-item"><strong>Derecho de Revocación:</strong> Revocar la autorización otorgada para el tratamiento.</div>
            <div class="list-item"><strong>Derecho de Consulta:</strong> Consultar información sobre el uso de sus datos.</div>
            <div class="list-item"><strong>Derecho de Reclamo:</strong> Presentar quejas ante la Superintendencia de Industria y Comercio.</div>
        </div>

        <div class="highlight">
            <strong>Ejercicio de Derechos:</strong> Para ejercer cualquiera de estos derechos, puede contactarnos a través de privacidad@jsmconnect.com o mediante los canales de atención disponibles en la plataforma.
        </div>
    </div>

    <!-- 7. Medidas de Seguridad -->
    <div class="section">
        <div class="section-title">7. Medidas de Seguridad</div>
        <div class="paragraph">
            JSM Connect implementa las siguientes medidas técnicas y administrativas para proteger sus datos personales:
        </div>

        <div class="list">
            <div class="list-item">• Encriptación de datos sensibles y contraseñas</div>
            <div class="list-item">• Protocolos de seguridad HTTPS en todas las comunicaciones</div>
            <div class="list-item">• Controles de acceso y autenticación robustos</div>
            <div class="list-item">• Monitoreo continuo de actividades sospechosas</div>
            <div class="list-item">• Respaldos regulares y seguros de la información</div>
            <div class="list-item">• Capacitación del personal en protección de datos</div>
            <div class="list-item">• Auditorías periódicas de seguridad</div>
        </div>
    </div>

    <!-- 8. Conservación de Datos -->
    <div class="section">
        <div class="section-title">8. Tiempo de Conservación</div>
        <div class="paragraph">
            Los datos personales serán conservados durante el tiempo necesario para cumplir con las finalidades establecidas y las obligaciones legales:
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Tipo de Dato</th>
                    <th>Tiempo de Conservación</th>
                    <th>Justificación</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Datos de registro</td>
                    <td>Mientras la cuenta esté activa + 5 años</td>
                    <td>Cumplimiento legal y contable</td>
                </tr>
                <tr>
                    <td>Historial de servicios</td>
                    <td>5 años desde la última transacción</td>
                    <td>Obligaciones comerciales y tributarias</td>
                </tr>
                <tr>
                    <td>Datos de marketing</td>
                    <td>Hasta revocación del consentimiento</td>
                    <td>Consentimiento del titular</td>
                </tr>
                <tr>
                    <td>Logs de seguridad</td>
                    <td>2 años</td>
                    <td>Seguridad y prevención de fraudes</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- 9. Transferencias Internacionales -->
    <div class="section">
        <div class="section-title">9. Transferencias Internacionales</div>
        <div class="paragraph">
            JSM Connect no realiza transferencias internacionales de datos personales. Todos los datos son procesados y almacenados en servidores ubicados en territorio colombiano bajo la legislación nacional aplicable.
        </div>
        <div class="paragraph">
            En caso de requerirse transferencias internacionales en el futuro, se solicitará autorización previa y se garantizarán niveles adecuados de protección conforme a la normatividad vigente.
        </div>
    </div>

    <!-- 10. Cookies y Tecnologías -->
    <div class="section">
        <div class="section-title">10. Uso de Cookies y Tecnologías Similares</div>
        <div class="paragraph">
            Nuestra plataforma utiliza cookies y tecnologías similares para:
        </div>

        <div class="list">
            <div class="list-item">• Mantener la sesión del usuario activa</div>
            <div class="list-item">• Recordar preferencias y configuraciones</div>
            <div class="list-item">• Analizar el uso de la plataforma</div>
            <div class="list-item">• Mejorar la experiencia del usuario</div>
            <div class="list-item">• Detectar y prevenir actividades fraudulentas</div>
        </div>

        <div class="paragraph">
            Puede gestionar las cookies a través de la configuración de su navegador, aunque esto puede afectar algunas funcionalidades de la plataforma.
        </div>
    </div>

    <!-- 11. Menores de Edad -->
    <div class="section">
        <div class="section-title">11. Tratamiento de Datos de Menores de Edad</div>
        <div class="paragraph">
            JSM Connect no recolecta intencionalmente datos personales de menores de 18 años. El registro en la plataforma está limitado a personas mayores de edad con capacidad legal para contratar.
        </div>
        <div class="paragraph">
            Si detectamos que se han recolectado datos de un menor sin la debida autorización, procederemos a eliminar dicha información inmediatamente.
        </div>
    </div>

    <!-- 12. Modificaciones a la Política -->
    <div class="section">
        <div class="section-title">12. Modificaciones a esta Política</div>
        <div class="paragraph">
            JSM Connect se reserva el derecho de modificar esta política en cualquier momento. Las modificaciones serán notificadas a través de:
        </div>

        <div class="list">
            <div class="list-item">• Publicación en la plataforma web</div>
            <div class="list-item">• Notificación por correo electrónico</div>
            <div class="list-item">• Mensaje en la aplicación</div>
        </div>

        <div class="paragraph">
            Le recomendamos revisar periódicamente esta política para mantenerse informado sobre cómo protegemos sus datos personales.
        </div>
    </div>

    <!-- 13. Contacto -->
    <div class="section">
        <div class="section-title">13. Contacto y Consultas</div>
        <div class="paragraph">
            Para cualquier consulta, solicitud o reclamo relacionado con el tratamiento de sus datos personales, puede contactarnos a través de:
        </div>

        <div class="contact-info">
            <div class="paragraph mb-0"><strong>📧 Correo Electrónico:</strong> privacidad@jsmconnect.com</div>
            <div class="paragraph mb-0"><strong>📞 Línea de Atención:</strong> +57 (1) 123-4567</div>
            <div class="paragraph mb-0"><strong>⏰ Horario de Atención:</strong> Lunes a Viernes, 8:00 AM - 6:00 PM</div>
            <div class="paragraph mb-0"><strong>🌐 Sitio Web:</strong> www.jsmconnect.com</div>
            <div class="paragraph mb-0"><strong>📍 Dirección:</strong> Disponible bajo solicitud</div>
        </div>
    </div>

    <!-- 14. Vigencia -->
    <div class="section">
        <div class="section-title">14. Vigencia y Aplicabilidad</div>
        <div class="paragraph">
            Esta política entra en vigencia a partir del {{ $date }} y permanecerá vigente hasta que sea modificada o actualizada conforme a los procedimientos establecidos.
        </div>
        <div class="paragraph">
            El uso continuado de la plataforma JSM Connect constituye la aceptación de esta política y sus eventuales modificaciones.
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="paragraph mb-0">
            <strong>JSM Connect - Política de Tratamiento de Datos Personales</strong>
        </div>
        <div class="paragraph mb-0">
            Versión {{ $version }} • Vigente desde {{ $date }}
        </div>
        <div class="paragraph mb-0">
            © {{ now()->year }} JSM Connect. Todos los derechos reservados.
        </div>
    </div>
</body>
</html> 