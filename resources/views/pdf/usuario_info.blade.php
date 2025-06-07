<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Información de Usuario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        h1 {
            font-size: 20px;
            color: #2563eb;
            text-align: center;
            margin-bottom: 20px;
        }
        h2 {
            font-size: 16px;
            color: #2563eb;
            border-bottom: 1px solid #2563eb;
            padding-bottom: 5px;
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            text-align: left;
            padding: 8px;
            font-size: 12px;
        }
        td {
            padding: 8px;
            font-size: 11px;
        }
        .section {
            margin-bottom: 30px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 10px;
            color: #666;
        }
        .info-table {
            width: 100%;
            border: none;
            margin-bottom: 20px;
        }
        .info-table td {
            border: none;
            padding: 4px;
        }
        .info-table td:first-child {
            font-weight: bold;
            width: 30%;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="logo">
        <h1>Plataforma de Servicios</h1>
    </div>
    
    <h1>Información Personal de {{ $usuario->nombre }} {{ $usuario->apellidos }}</h1>
    <p>Documento generado el {{ now()->format('d/m/Y H:i:s') }}</p>
    
    <div class="section">
        <h2>Datos Personales</h2>
        <table class="info-table">
            <tr>
                <td>Nombre completo:</td>
                <td>{{ $usuario->nombre }} {{ $usuario->apellidos }}</td>
            </tr>
            <tr>
                <td>Documento:</td>
                <td>{{ $usuario->tipo_documento }}: {{ $usuario->numero_documento }}</td>
            </tr>
            <tr>
                <td>Género:</td>
                <td>{{ $usuario->genero }}</td>
            </tr>
            <tr>
                <td>Profesión:</td>
                <td>{{ $usuario->profesion }}</td>
            </tr>
            <tr>
                <td>Email:</td>
                <td>{{ $usuario->email }}</td>
            </tr>
            <tr>
                <td>Teléfono:</td>
                <td>{{ $usuario->telefono }}</td>
            </tr>
            <tr>
                <td>Fecha de registro:</td>
                <td>{{ $usuario->created_at->format('d/m/Y') }}</td>
            </tr>
        </table>
    </div>
    
    <div class="section">
        <h2>Preferencias y Hobbies</h2>
        @if($preferencias->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Hobby</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($preferencias as $preferencia)
                        <tr>
                            <td>{{ $preferencia->hobby }}</td>
                            <td>{{ $preferencia->descripcion }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No has registrado preferencias o hobbies.</p>
        @endif
    </div>
    
    <div class="section">
        <h2>Especialidades</h2>
        @if($especialidades->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Categoría</th>
                        <th>Descripción</th>
                        <th>Experiencia (años)</th>
                        <th>Tarifa por hora</th>
                        <th>Disponible</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($especialidades as $especialidad)
                        <tr>
                            <td>{{ $especialidad->nombre }}</td>
                            <td>{{ $especialidad->pivot->descripcion }}</td>
                            <td>{{ $especialidad->pivot->experiencia_anios }}</td>
                            <td>${{ number_format($especialidad->pivot->tarifa_hora, 2) }}</td>
                            <td>{{ $especialidad->pivot->disponible ? 'Sí' : 'No' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No has registrado especialidades.</p>
        @endif
    </div>
    
    <div class="section">
        <h2>Servicios Ofrecidos</h2>
        @if($servicios->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Duración estimada</th>
                        <th>Disponible</th>
                        <th>Fecha de creación</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($servicios as $servicio)
                        <tr>
                            <td>{{ $servicio->titulo }}</td>
                            <td>{{ $servicio->categoria->nombre }}</td>
                            <td>${{ number_format($servicio->precio, 2) }}</td>
                            <td>{{ $servicio->duracion_estimada ?: 'No especificada' }}</td>
                            <td>{{ $servicio->disponible ? 'Sí' : 'No' }}</td>
                            <td>{{ $servicio->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No has publicado servicios.</p>
        @endif
    </div>
    
    <div class="section">
        <h2>Solicitudes Enviadas</h2>
        @if($solicitudesRealizadas->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Servicio</th>
                        <th>Proveedor</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($solicitudesRealizadas as $solicitud)
                        <tr>
                            <td>{{ $solicitud->servicio->titulo }}</td>
                            <td>{{ $solicitud->usuario_proveedor->nombre }} {{ $solicitud->usuario_proveedor->apellidos }}</td>
                            <td>{{ ucfirst($solicitud->estado) }}</td>
                            <td>{{ $solicitud->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No has realizado solicitudes de servicios.</p>
        @endif
    </div>
    
    <div class="section">
        <h2>Solicitudes Recibidas</h2>
        @if($solicitudesRecibidas->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Servicio</th>
                        <th>Solicitante</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($solicitudesRecibidas as $solicitud)
                        <tr>
                            <td>{{ $solicitud->servicio->titulo }}</td>
                            <td>{{ $solicitud->usuario_solicitante->nombre }} {{ $solicitud->usuario_solicitante->apellidos }}</td>
                            <td>{{ ucfirst($solicitud->estado) }}</td>
                            <td>{{ $solicitud->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No has recibido solicitudes de servicios.</p>
        @endif
    </div>
    
    <div class="footer">
        <p>Este documento contiene información personal y confidencial. Generado desde la Plataforma de Servicios.</p>
        <p>© {{ date('Y') }} Plataforma de Servicios. Todos los derechos reservados.</p>
    </div>
</body>
</html> 