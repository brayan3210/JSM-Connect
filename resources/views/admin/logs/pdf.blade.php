<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Logs - {{ $usuario->nombre }} {{ $usuario->apellidos }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
            line-height: 1.4;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #104CFF;
        }
        
        .header h1 {
            color: #104CFF;
            margin: 0;
            font-size: 24px;
        }
        
        .header p {
            margin: 5px 0;
            color: #666;
        }
        
        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        
        .info-row {
            display: table-row;
        }
        
        .info-cell {
            display: table-cell;
            padding: 8px;
            border: 1px solid #ddd;
            vertical-align: top;
        }
        
        .info-cell.label {
            background-color: #f8f9fa;
            font-weight: bold;
            width: 30%;
        }
        
        .stats-container {
            margin: 20px 0;
        }
        
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        
        .stats-row {
            display: table-row;
        }
        
        .stats-cell {
            display: table-cell;
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
            background-color: #f8f9fa;
        }
        
        .stats-number {
            font-size: 20px;
            font-weight: bold;
            color: #104CFF;
        }
        
        .stats-label {
            font-size: 11px;
            color: #666;
            text-transform: uppercase;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }
        
        .table th {
            background-color: #104CFF;
            color: white;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
        }
        
        .table td {
            font-size: 11px;
        }
        
        .badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .badge-success {
            background-color: #28a745;
            color: white;
        }
        
        .badge-info {
            background-color: #17a2b8;
            color: white;
        }
        
        .badge-warning {
            background-color: #ffc107;
            color: #000;
        }
        
        .badge-error {
            background-color: #104CFF;
            color: white;
        }
        
        .badge-secondary {
            background-color: #6c757d;
            color: white;
        }
        
        .text-muted {
            color: #666;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            color: #666;
            font-size: 10px;
        }
        
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte de Logs de Usuario</h1>
        <p><strong>Usuario:</strong> {{ $usuario->nombre }} {{ $usuario->apellidos }}</p>
        <p><strong>Email:</strong> {{ $usuario->email }}</p>
        <p><strong>Fecha de generación:</strong> {{ now()->format('d/m/Y H:i:s') }}</p>
        @if($fecha_desde || $fecha_hasta)
            <p><strong>Período:</strong> 
                @if($fecha_desde) Desde {{ \Carbon\Carbon::parse($fecha_desde)->format('d/m/Y') }} @endif
                @if($fecha_hasta) Hasta {{ \Carbon\Carbon::parse($fecha_hasta)->format('d/m/Y') }} @endif
            </p>
        @endif
        @if($tipo)
            <p><strong>Tipo de logs:</strong> {{ ucfirst($tipo) }}</p>
        @endif
    </div>

    <div class="info-grid">
        <div class="info-row">
            <div class="info-cell label">Nombre completo</div>
            <div class="info-cell">{{ $usuario->nombre }} {{ $usuario->apellidos }}</div>
            <div class="info-cell label">Email</div>
            <div class="info-cell">{{ $usuario->email }}</div>
        </div>
        <div class="info-row">
            <div class="info-cell label">Profesión</div>
            <div class="info-cell">{{ $usuario->profesion ?? 'No especificada' }}</div>
            <div class="info-cell label">Tipo de usuario</div>
            <div class="info-cell">
                @if($usuario->es_admin)
                    <span class="badge badge-warning">Administrador</span>
                @else
                    <span class="badge badge-info">Usuario</span>
                @endif
            </div>
        </div>
        <div class="info-row">
            <div class="info-cell label">Estado</div>
            <div class="info-cell">
                @if($usuario->activo)
                    <span class="badge badge-success">Activo</span>
                @else
                    <span class="badge badge-error">Inactivo</span>
                @endif
            </div>
            <div class="info-cell label">Fecha de registro</div>
            <div class="info-cell">{{ $usuario->created_at ? $usuario->created_at->format('d/m/Y H:i') : 'N/A' }}</div>
        </div>
    </div>

    <div class="stats-container">
        <h3 style="color: #104CFF; margin-bottom: 15px;">Estadísticas de Logs</h3>
        <div class="stats-grid">
            <div class="stats-row">
                <div class="stats-cell">
                    <div class="stats-number">{{ $estadisticas['total'] }}</div>
                    <div class="stats-label">Total Logs</div>
                </div>
                <div class="stats-cell">
                    <div class="stats-number">{{ $estadisticas['success'] }}</div>
                    <div class="stats-label">Exitosos</div>
                </div>
                <div class="stats-cell">
                    <div class="stats-number">{{ $estadisticas['info'] ?? 0 }}</div>
                    <div class="stats-label">Información</div>
                </div>
                <div class="stats-cell">
                    <div class="stats-number">{{ $estadisticas['warning'] }}</div>
                    <div class="stats-label">Advertencias</div>
                </div>
                <div class="stats-cell">
                    <div class="stats-number">{{ $estadisticas['error'] }}</div>
                    <div class="stats-label">Errores</div>
                </div>
            </div>
        </div>
    </div>

    <div style="margin-top: 30px;">
        <h3 style="color: #104CFF; margin-bottom: 15px;">Registro de Actividad ({{ $logs->count() }} registros)</h3>
        
        @if($logs->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 15%;">Fecha y Hora</th>
                        <th style="width: 20%;">Acción</th>
                        <th style="width: 35%;">Descripción</th>
                        <th style="width: 10%;">Tipo</th>
                        <th style="width: 12%;">IP</th>
                        <th style="width: 8%;">Método</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                        <tr>
                            <td>
                                <strong>{{ $log->created_at ? $log->created_at->format('d/m/Y') : 'N/A' }}</strong><br>
                                <span class="text-muted">{{ $log->created_at ? $log->created_at->format('H:i:s') : 'N/A' }}</span>
                            </td>
                            <td><strong>{{ $log->accion }}</strong></td>
                            <td>{{ $log->descripcion ?: '-' }}</td>
                            <td>
                                @switch($log->tipo)
                                    @case('success')
                                        <span class="badge badge-success">Exitoso</span>
                                        @break
                                    @case('info')
                                        <span class="badge badge-info">Info</span>
                                        @break
                                    @case('warning')
                                        <span class="badge badge-warning">Advertencia</span>
                                        @break
                                    @case('error')
                                        <span class="badge badge-error">Error</span>
                                        @break
                                    @default
                                        <span class="badge badge-secondary">{{ $log->tipo }}</span>
                                @endswitch
                            </td>
                            <td>{{ $log->ip_address ?? 'N/A' }}</td>
                            <td>{{ $log->metodo_http ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="text-align: center; color: #666; font-style: italic; padding: 20px;">
                No se encontraron logs con los filtros aplicados.
            </p>
        @endif
    </div>

    <div class="footer">
        <p>Generado el {{ now()->format('d/m/Y H:i:s') }} | Sistema de Administración</p>
        <p>Este documento contiene información confidencial del sistema.</p>
    </div>
</body>
</html> 