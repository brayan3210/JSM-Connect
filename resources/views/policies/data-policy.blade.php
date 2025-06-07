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
            Esta política aplica a todos los datos personales que JSM Connect recolecte, almacene, use, circule o suprima en desarrollo de su objeto social, especificamente la conexión entre profesionales y usuarios que requieren servicios especializados.
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
            <div class="list-item"><strong>Dato Sensible:</strong> Es aquel que afecta la intimidad del titular o cuyo uso indebido puede generar su discriminación.</div>
            <div class="list-item"><strong>Encargado del Tratamiento:</strong> Persona natural o jurídica, pública o privada, que por sí misma o en asocio con otros, realice el tratamiento de datos personales por cuenta del responsable del tratamiento.</div>
            <div class="list-item"><strong>Responsable del Tratamiento:</strong> Persona natural o jurídica, pública o privada, que por sí misma o en asocio con otros, decida sobre la base de datos y/o el tratamiento de los datos.</div>
            <div class="list-item"><strong>Titular:</strong> Persona natural cuyos datos personales sean objeto de tratamiento.</div>
            <div class="list-item"><strong>Tratamiento:</strong> Cualquier operación o conjunto de operaciones sobre datos personales, tales como la recolección, almacenamiento, uso, circulación o supresión.</div>
        </div>
    </div>

    <!-- 3. Identificación del Responsable -->
    <div class="section">
        <div class="section-title">3. Identificación del Responsable del Tratamiento</div>
        <div class="contact-info">
            <div class="subsection-title">Razón Social:</div>
            <div class="paragraph mb-0">JSM Connect - Plataforma Digital de Servicios Profesionales</div>
            
            <div class="subsection-title">Domicilio:</div>
            <div class="paragraph mb-0">Colombia</div>
            
            <div class="subsection-title">Correo Electrónico:</div>
            <div class="paragraph mb-0">jsmconect@gmail.com</div>
            
            <div class="subsection-title">Teléfono de Contacto:</div>
            <div class="paragraph mb-0">Disponible a través de la plataforma web</div>
            
            <div class="subsection-title">Página Web:</div>
            <div class="paragraph mb-0">www.jsmconnect.com</div>
        </div>
    </div>

    <div class="page-break"></div>

    <!-- 4. Finalidades del Tratamiento -->
    <div class="section">
        <div class="section-title">4. Finalidades del Tratamiento de Datos Personales</div>
        <div class="paragraph">
            JSM Connect tratará los datos personales recolectados para las siguientes finalidades específicas:
        </div>

        <div class="subsection-title">4.1. Finalidades Principales:</div>
        <div class="list">
            <div class="list-item">a) Creación y gestión de cuentas de usuario en la plataforma.</div>
            <div class="list-item">b) Facilitación de la conexión entre profesionales y usuarios que requieren servicios.</div>
            <div class="list-item">c) Verificación de identidad y validación de información profesional.</div>
            <div class="list-item">d) Procesamiento de solicitudes de servicios y comunicación entre usuarios.</div>
            <div class="list-item">e) Gestión de pagos y facturación de servicios contratados.</div>
            <div class="list-item">f) Envío de notificaciones sobre el estado de servicios y transacciones.</div>
            <div class="list-item">g) Evaluación y calificación de servicios prestados.</div>
        </div>

        <div class="subsection-title">4.2. Finalidades Secundarias:</div>
        <div class="list">
            <div class="list-item">a) Mejoramiento de la experiencia del usuario en la plataforma.</div>
            <div class="list-item">b) Análisis estadístico para optimización de servicios.</div>
            <div class="list-item">c) Prevención de fraudes y actividades ilícitas.</div>
            <div class="list-item">d) Cumplimiento de obligaciones legales y reglamentarias.</div>
            <div class="list-item">e) Resolución de disputas y atención al cliente.</div>
            <div class="list-item">f) Envío de información promocional y actualizaciones del servicio (previa autorización).</div>
            <div class="list-item">g) Investigación y desarrollo de nuevos productos y servicios.</div>
        </div>
    </div>

    <!-- 5. Tipo de Datos Recolectados -->
    <div class="section">
        <div class="section-title">5. Tipo de Datos Personales Recolectados</div>
        
        <div class="subsection-title">5.1. Datos de Identificación:</div>
        <div class="list">
            <div class="list-item">• Nombres y apellidos completos</div>
            <div class="list-item">• Tipo y número de documento de identidad</div>
            <div class="list-item">• Género</div>
            <div class="list-item">• Fecha de nacimiento (cuando sea requerida)</div>
        </div>

        <div class="subsection-title">5.2. Datos de Contacto:</div>
        <div class="list">
            <div class="list-item">• Dirección de correo electrónico</div>
            <div class="list-item">• Número de teléfono</div>
            <div class="list-item">• Dirección de residencia (cuando sea requerida)</div>
        </div>

        <div class="subsection-title">5.3. Datos Profesionales:</div>
        <div class="list">
            <div class="list-item">• Profesión u ocupación</div>
            <div class="list-item">• Especialidades y habilidades</div>
            <div class="list-item">• Experiencia laboral</div>
            <div class="list-item">• Certificaciones y títulos académicos</div>
            <div class="list-item">• Tarifas y disponibilidad de servicios</div>
        </div>

        <div class="subsection-title">5.4. Datos de Preferencias:</div>
        <div class="list">
            <div class="list-item">• Hobbies e intereses personales</div>
            <div class="list-item">• Categorías de servicios de interés</div>
            <div class="list-item">• Preferencias de comunicación</div>
        </div>

        <div class="subsection-title">5.5. Datos de Navegación:</div>
        <div class="list">
            <div class="list-item">• Dirección IP</div>
            <div class="list-item">• Información del dispositivo y navegador</div>
            <div class="list-item">• Cookies y tecnologías similares</div>
            <div class="list-item">• Historial de navegación en la plataforma</div>
        </div>
    </div>

    <!-- 6. Derechos del Titular -->
    <div class="section">
        <div class="section-title">6. Derechos de los Titulares de Datos Personales</div>
        <div class="paragraph">
            Conforme a la normatividad vigente, los titulares de datos personales tienen los siguientes derechos:
        </div>

        <div class="list">
            <div class="list-item"><strong>a) Conocer, actualizar y rectificar</strong> sus datos personales frente a JSM Connect como responsable del tratamiento.</div>
            <div class="list-item"><strong>b) Solicitar prueba de la autorización</strong> otorgada para el tratamiento de sus datos personales.</div>
            <div class="list-item"><strong>c) Ser informado</strong> por JSM Connect, previa solicitud, respecto del uso que le ha dado a sus datos personales.</div>
            <div class="list-item"><strong>d) Presentar quejas</strong> ante la Superintendencia de Industria y Comercio por infracciones a la normatividad de protección de datos personales.</div>
            <div class="list-item"><strong>e) Revocar la autorización</strong> y/o solicitar la supresión del dato cuando en el tratamiento no se respeten los principios, derechos y garantías constitucionales y legales.</div>
            <div class="list-item"><strong>f) Acceder de forma gratuita</strong> a sus datos personales que hayan sido objeto de tratamiento.</div>
        </div>

        <div class="highlight">
            <strong>Nota Importante:</strong> La revocación de la autorización y/o la supresión de datos personales puede limitar o impedir el acceso a los servicios de la plataforma JSM Connect.
        </div>
    </div>

    <div class="page-break"></div>

    <!-- 7. Procedimientos para Ejercer Derechos -->
    <div class="section">
        <div class="section-title">7. Procedimientos para el Ejercicio de Derechos</div>
        
        <div class="subsection-title">7.1. Consultas:</div>
        <div class="paragraph">
            Los titulares o sus causahabientes podrán consultar la información personal del titular que repose en cualquier base de datos de JSM Connect. Para ello, deberán dirigir una comunicación a la dirección de correo electrónico jsmconect@gmail.com.
        </div>

        <div class="subsection-title">7.2. Reclamos:</div>
        <div class="paragraph">
            Los titulares o sus causahabientes que consideren que la información contenida en una base de datos debe ser objeto de corrección, actualización o supresión, o cuando adviertan el presunto incumplimiento de cualquiera de los deberes contenidos en la ley, podrán presentar un reclamo ante JSM Connect.
        </div>

        <div class="subsection-title">7.3. Requisitos de la Solicitud:</div>
        <div class="list">
            <div class="list-item">• Identificación del titular o su representante legal</div>
            <div class="list-item">• Descripción clara y precisa de los hechos que motivan la solicitud</div>
            <div class="list-item">• Documentos que se quieran hacer valer</div>
            <div class="list-item">• Dirección física o electrónica para recibir respuesta</div>
        </div>

        <div class="subsection-title">7.4. Términos de Respuesta:</div>
        <div class="list">
            <div class="list-item">• <strong>Consultas:</strong> Máximo 10 días hábiles</div>
            <div class="list-item">• <strong>Reclamos:</strong> Máximo 15 días hábiles</div>
            <div class="list-item">• Los términos podrán prorrogarse por 5 días hábiles adicionales previa comunicación al interesado</div>
        </div>
    </div>

    <!-- 8. Medidas de Seguridad -->
    <div class="section">
        <div class="section-title">8. Medidas de Seguridad</div>
        <div class="paragraph">
            JSM Connect ha implementado medidas técnicas, humanas y administrativas necesarias para otorgar seguridad a los registros evitando su adulteración, pérdida, consulta, uso o acceso no autorizado o fraudulento:
        </div>

        <div class="subsection-title">8.1. Medidas Técnicas:</div>
        <div class="list">
            <div class="list-item">• Cifrado de datos sensibles usando algoritmos de última generación</div>
            <div class="list-item">• Protocolos de comunicación seguros (HTTPS/SSL)</div>
            <div class="list-item">• Firewalls y sistemas de detección de intrusos</div>
            <div class="list-item">• Respaldos automáticos y recuperación de desastres</div>
            <div class="list-item">• Actualización constante de sistemas de seguridad</div>
        </div>

        <div class="subsection-title">8.2. Medidas Administrativas:</div>
        <div class="list">
            <div class="list-item">• Políticas de acceso basadas en roles y necesidades</div>
            <div class="list-item">• Procedimientos de autenticación y autorización</div>
            <div class="list-item">• Auditorías periódicas de seguridad</div>
            <div class="list-item">• Planes de contingencia y respuesta a incidentes</div>
        </div>

        <div class="subsection-title">8.3. Medidas Humanas:</div>
        <div class="list">
            <div class="list-item">• Capacitación continua del personal en protección de datos</div>
            <div class="list-item">• Acuerdos de confidencialidad con empleados y terceros</div>
            <div class="list-item">• Evaluación periódica del cumplimiento normativo</div>
        </div>
    </div>

    <!-- 9. Transferencia y Transmisión -->
    <div class="section">
        <div class="section-title">9. Transferencia y Transmisión de Datos</div>
        <div class="paragraph">
            JSM Connect podrá transferir o transmitir datos personales en los siguientes casos:
        </div>

        <div class="subsection-title">9.1. Transferencias Autorizadas:</div>
        <div class="list">
            <div class="list-item">• Cuando exista autorización expresa del titular</div>
            <div class="list-item">• Por mandato legal o judicial</div>
            <div class="list-item">• Para el cumplimiento de obligaciones contratuales</div>
            <div class="list-item">• A entidades financieras para procesamiento de pagos</div>
            <div class="list-item">• A proveedores de servicios tecnológicos bajo estrictos acuerdos de confidencialidad</div>
        </div>

        <div class="subsection-title">9.2. Países de Destino:</div>
        <div class="paragraph">
            Las transferencias internacionales se realizarán únicamente a países que proporcionen niveles adecuados de protección de datos o mediante la implementación de cláusulas contractuales que garanticen la protección de la información.
        </div>
    </div>

    <!-- 10. Tiempo de Conservación -->
    <div class="section">
        <div class="section-title">10. Tiempo de Conservación de los Datos</div>
        
        <div class="table">
            <tr>
                <th>Tipo de Dato</th>
                <th>Tiempo de Conservación</th>
                <th>Fundamento</th>
            </tr>
            <tr>
                <td>Datos de registro de usuario</td>
                <td>Mientras la cuenta esté activa + 5 años</td>
                <td>Cumplimiento legal y comercial</td>
            </tr>
            <tr>
                <td>Datos de transacciones</td>
                <td>10 años</td>
                <td>Obligaciones tributarias y contables</td>
            </tr>
            <tr>
                <td>Datos de comunicaciones</td>
                <td>2 años desde la última comunicación</td>
                <td>Resolución de disputas</td>
            </tr>
            <tr>
                <td>Datos de navegación</td>
                <td>2 años</td>
                <td>Análisis estadístico y seguridad</td>
            </tr>
            <tr>
                <td>Datos de marketing</td>
                <td>Hasta revocación de autorización</td>
                <td>Consentimiento del titular</td>
            </tr>
        </table>
    </div>

    <div class="page-break"></div>

    <!-- 11. Cookies y Tecnologías Similares -->
    <div class="section">
        <div class="section-title">11. Uso de Cookies y Tecnologías Similares</div>
        <div class="paragraph">
            JSM Connect utiliza cookies y tecnologías similares para mejorar la experiencia del usuario y optimizar el funcionamiento de la plataforma.
        </div>

        <div class="subsection-title">11.1. Tipos de Cookies Utilizadas:</div>
        <div class="list">
            <div class="list-item"><strong>Cookies Esenciales:</strong> Necesarias para el funcionamiento básico de la plataforma</div>
            <div class="list-item"><strong>Cookies de Rendimiento:</strong> Para analizar el uso y mejorar el rendimiento</div>
            <div class="list-item"><strong>Cookies de Funcionalidad:</strong> Para recordar preferencias del usuario</div>
            <div class="list-item"><strong>Cookies de Marketing:</strong> Para mostrar contenido relevante (previa autorización)</div>
        </div>

        <div class="subsection-title">11.2. Gestión de Cookies:</div>
        <div class="paragraph">
            Los usuarios pueden configurar su navegador para rechazar cookies, aunque esto puede afectar la funcionalidad de la plataforma. JSM Connect proporciona herramientas de gestión de cookies en su sitio web.
        </div>
    </div>

    <!-- 12. Actualizaciones de la Política -->
    <div class="section">
        <div class="section-title">12. Actualizaciones de la Política</div>
        <div class="paragraph">
            Esta política puede ser modificada para adaptarse a cambios en la normatividad vigente o en las operaciones de JSM Connect. Las modificaciones serán comunicadas a través de:
        </div>

        <div class="list">
            <div class="list-item">• Publicación en el sitio web de JSM Connect</div>
            <div class="list-item">• Notificación por correo electrónico a usuarios registrados</div>
            <div class="list-item">• Avisos en la plataforma digital</div>
        </div>

        <div class="paragraph">
            Se otorgará un período de 30 días calendario para que los titulares manifiesten su aceptación de los nuevos términos o ejerzan sus derechos de oposición.
        </div>
    </div>

    <!-- 13. Normatividad Aplicable -->
    <div class="section">
        <div class="section-title">13. Normatividad Aplicable</div>
        <div class="paragraph">
            Esta política se rige por la normatividad colombiana vigente en materia de protección de datos personales:
        </div>

        <div class="list">
            <div class="list-item">• Ley 1581 de 2012 - Régimen General de Protección de Datos Personales</div>
            <div class="list-item">• Decreto 1377 de 2013 - Reglamentario de la Ley 1581 de 2012</div>
            <div class="list-item">• Ley 1266 de 2008 - Habeas Data</div>
            <div class="list-item">• Circular Externa 002 de 2015 de la SIC</div>
            <div class="list-item">• Decreto 090 de 2018 - Política de Gobierno Digital</div>
        </div>
    </div>

    <!-- 14. Contacto y Consultas -->
    <div class="section">
        <div class="section-title">14. Información de Contacto</div>
        <div class="contact-info">
            <div class="subsection-title">Oficial de Protección de Datos:</div>
            <div class="paragraph mb-0"><strong>JSM Connect - Área de Protección de Datos</strong></div>
            
            <div class="subsection-title">Correo Electrónico:</div>
            <div class="paragraph mb-0">jsmconect@gmail.com</div>
            <div class="paragraph mb-0">Asunto: [PROTECCIÓN DE DATOS] - [Tipo de Solicitud]</div>
            
            <div class="subsection-title">Horario de Atención:</div>
            <div class="paragraph mb-0">Lunes a Viernes: 8:00 AM - 6:00 PM</div>
            <div class="paragraph mb-0">Zona Horaria: GMT-5 (Colombia)</div>
            
            <div class="subsection-title">Tiempo de Respuesta:</div>
            <div class="paragraph mb-0">Máximo 10 días hábiles para consultas</div>
            <div class="paragraph mb-0">Máximo 15 días hábiles para reclamos</div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="text-bold">JSM CONNECT - POLÍTICA DE TRATAMIENTO DE DATOS PERSONALES</div>
        <div>Versión {{ $version }} | Vigente desde {{ $date }}</div>
        <div>Este documento fue generado automáticamente por el sistema de JSM Connect</div>
        <div class="text-italic">Para la versión más actualizada, consulte nuestro sitio web oficial</div>
    </div>
</body>
</html> 