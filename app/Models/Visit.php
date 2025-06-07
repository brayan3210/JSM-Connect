<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'user_agent', 
        'page',
        'visited_at',
        'visit_date'
    ];

    protected $casts = [
        'visited_at' => 'datetime',
        'visit_date' => 'date'
    ];

    public $timestamps = false;

    /**
     * Registra una nueva visita
     */
    public static function registrarVisita($request, $page = '/')
    {
        $ip = $request->ip();
        $userAgent = $request->header('User-Agent');
        $today = Carbon::today();
        $now = Carbon::now();

        // Verificar si ya existe una visita de esta IP hoy en esta página
        $visitaExistente = self::where('ip_address', $ip)
            ->where('page', $page)
            ->where('visit_date', $today)
            ->exists();

        // Solo registrar si no existe una visita de esta IP hoy en esta página
        if (!$visitaExistente) {
            self::create([
                'ip_address' => $ip,
                'user_agent' => $userAgent,
                'page' => $page,
                'visited_at' => $now,
                'visit_date' => $today
            ]);
        }
    }

    /**
     * Obtiene el total de visitas únicas
     */
    public static function getTotalVisitas()
    {
        return self::distinct('ip_address')->count();
    }

    /**
     * Obtiene las visitas del día actual
     */
    public static function getVisitasHoy()
    {
        return self::where('visit_date', Carbon::today())
            ->distinct('ip_address')
            ->count();
    }

    /**
     * Obtiene las visitas de la semana actual
     */
    public static function getVisitasSemana()
    {
        $inicioSemana = Carbon::now()->startOfWeek();
        return self::where('visit_date', '>=', $inicioSemana)
            ->distinct('ip_address')
            ->count();
    }

    /**
     * Obtiene las visitas del mes actual
     */
    public static function getVisitasMes()
    {
        $inicioMes = Carbon::now()->startOfMonth();
        return self::where('visit_date', '>=', $inicioMes)
            ->distinct('ip_address')
            ->count();
    }

    /**
     * Obtiene estadísticas completas de visitas
     */
    public static function getEstadisticas()
    {
        return [
            'total' => self::getTotalVisitas(),
            'hoy' => self::getVisitasHoy(),
            'semana' => self::getVisitasSemana(),
            'mes' => self::getVisitasMes(),
            'total_paginas_vistas' => self::count(),
            'promedio_diario' => round(self::count() / max(self::distinct('visit_date')->count(), 1), 1)
        ];
    }

    /**
     * Obtiene las páginas más visitadas
     */
    public static function getPaginasMasVisitadas($limit = 10)
    {
        return self::selectRaw('page, COUNT(*) as total_visitas, COUNT(DISTINCT ip_address) as visitas_unicas')
            ->groupBy('page')
            ->orderByDesc('total_visitas')
            ->limit($limit)
            ->get();
    }

    /**
     * Limpia visitas antiguas (opcional, para mantener la base de datos limpia)
     */
    public static function limpiarVisitasAntiguas($dias = 365)
    {
        $fechaLimite = Carbon::now()->subDays($dias);
        return self::where('visit_date', '<', $fechaLimite)->delete();
    }
} 