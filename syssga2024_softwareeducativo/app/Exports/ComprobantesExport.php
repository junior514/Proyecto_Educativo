<?php

namespace App\Exports;

use App\Models\Comprobante;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Facades\Event;

class ComprobantesExport implements FromCollection, WithHeadings
{
    use RegistersEventListeners;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('comprobantes as com')
        ->select('com.fechaHora', 'com.tipoDoc','com.serieComprobante', 'com.numComprobante','e.tipoDoc as tipoDocEst', 'e.nroDoc', 'e.nomEst', 'com.igv', 'com.totalComprobante', 'com.doc_relacionado')
        ->join('matriculas as m', 'm.idMatricula', '=', 'com.idMatricula')
        ->join('estudiantes as e', 'e.idEstudiante', '=', 'm.idEstudiante')
        ->where('com.sunat_estado', '!=', 2)
        ->whereDate('com.fechaHora', '=', now()->toDateString())
        ->get();    
    }

    /**
     * Specify headings for the export.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Fecha',
            'Tipo',
            'N° Serie',
            'N° Comprobante',
            'Tipo Doc',
            'N° Doc',
            'Nombre',
            'IGV',
            'Total',
            'Doc Afectado',
        ];
    }

    /**
     * Add styles to the headings.
     *
     * @return void
     */
    public static function afterSheet(AfterSheet $event)
    {
        $event->sheet->getDelegate()->getStyle('A1:Z1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'FFFF00', // Color de fondo amarillo
                ],
            ],
        ]);
    }
}