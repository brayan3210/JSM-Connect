<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PolicyController extends Controller
{
    /**
     * Mostrar la política de tratamiento de datos personales
     */
    public function showDataPolicy(Request $request)
    {
        $data = [
            'company' => 'JSM Connect',
            'date' => now()->format('d/m/Y'),
            'version' => '1.0'
        ];

        // Si se solicita como PDF, generar PDF
        if ($request->get('format') === 'pdf') {
            return $this->generatePdfStream($data);
        }

        // Mostrar como HTML por defecto
        return view('policies.data-policy-html', $data);
    }

    /**
     * Descargar la política de tratamiento de datos personales
     */
    public function downloadDataPolicy()
    {
        $data = [
            'company' => 'JSM Connect',
            'date' => now()->format('d/m/Y'),
            'version' => '1.0'
        ];

        return $this->generatePdfDownload($data);
    }

    /**
     * Generar PDF para visualización
     */
    private function generatePdfStream($data)
    {
        try {
            // Usar DomPDF directamente con vista completa
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('policies.data-policy-pdf', $data);
            $pdf->setPaper('A4', 'portrait');

            return $pdf->stream('politica-tratamiento-datos-personales-jsm-connect.pdf');
        } catch (\Exception $e) {
            \Log::error('Error generando PDF: ' . $e->getMessage());
            return redirect()->route('policy.data')->with('error', 'Error al generar PDF. Visualice la versión HTML.');
        }
    }

    /**
     * Generar PDF para descarga
     */
    private function generatePdfDownload($data)
    {
        try {
            // Usar DomPDF directamente con vista completa
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('policies.data-policy-pdf', $data);
            $pdf->setPaper('A4', 'portrait');

            return $pdf->download('politica-tratamiento-datos-personales-jsm-connect.pdf');
        } catch (\Exception $e) {
            \Log::error('Error descargando PDF: ' . $e->getMessage());
            return redirect()->route('policy.data')->with('error', 'Error al descargar PDF. Intente nuevamente.');
        }
    }
} 