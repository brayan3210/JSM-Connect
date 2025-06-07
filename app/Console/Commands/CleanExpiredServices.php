<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Servicio;
use Carbon\Carbon;

class CleanExpiredServices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'services:clean-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Marca como expirados los servicios que han cumplido su tiempo límite';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando limpieza de servicios expirados...');
        
        // Buscar servicios que han expirado pero aún no están marcados como tal
        $serviciosExpirados = Servicio::where('expirado', false)
            ->where('disponible', true)
            ->whereNotNull('fecha_expiracion')
            ->where('fecha_expiracion', '<=', Carbon::now())
            ->get();
        
        $contador = 0;
        
        foreach ($serviciosExpirados as $servicio) {
            $servicio->markAsExpired();
            $contador++;
            
            $this->line("✓ Servicio expirado: {$servicio->titulo} (ID: {$servicio->id_servicio})");
        }
        
        if ($contador > 0) {
            $this->info("Se marcaron {$contador} servicios como expirados.");
        } else {
            $this->info('No se encontraron servicios para marcar como expirados.');
        }
        
        // Mostrar estadísticas
        $totalActivos = Servicio::active()->count();
        $totalExpirados = Servicio::expired()->count();
        
        $this->newLine();
        $this->info("Estadísticas actuales:");
        $this->line("- Servicios activos: {$totalActivos}");
        $this->line("- Servicios expirados: {$totalExpirados}");
        
        return Command::SUCCESS;
    }
}
