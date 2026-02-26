<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\{FromCollection, WithTitle, WithHeadings,
    WithStyles, WithMapping, ShouldAutoSize, WithEvents};
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\{Fill, Border};
use Carbon\Carbon;

class ClientesSheet implements FromCollection, WithTitle, WithHeadings,
    WithStyles, WithMapping, ShouldAutoSize, WithEvents
{
    protected $cortes;
    protected $projections;

    public function __construct($cortes, $projections)
    {
        $this->cortes      = $cortes;
        $this->projections = $projections;
    }

    public function title(): string { return 'Clientes y Ticket'; }

    public function collection() { return $this->cortes; }

    public function headings(): array
    {
        $heads = ['Fecha','Cuentas','Clientes','Ticket Promedio'];
        if ($this->projections) $heads[] = 'Meta Ticket';
        return $heads;
    }

    public function map($corte): array
    {
        $ticket = $corte->total_clientes > 0
            ? round($corte->total_venta / $corte->total_clientes, 2)
            : 0;

        $row = [
            ucfirst(Carbon::parse($corte->dia)->isoFormat('ddd D MMM')),
            $corte->total_cuentas,
            $corte->total_clientes,
            $ticket,
        ];

        if ($this->projections) {
            $row[] = floatval($this->projections->projected_check ?? 0);
        }

        return $row;
    }

    public function styles($sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                  'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1A6B4A']]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet    = $event->sheet->getDelegate();
                $lastRow  = $this->cortes->count() + 2;
                $count    = $this->cortes->count() + 1;

                // Totales
                $sheet->setCellValue("A{$lastRow}", 'TOTAL / PROMEDIO');
                $sheet->setCellValue("B{$lastRow}", "=SUM(B2:B{$count})");
                $sheet->setCellValue("C{$lastRow}", "=SUM(C2:C{$count})");
                $sheet->setCellValue("D{$lastRow}", "=IFERROR(SUM(D2:D{$count})/COUNT(D2:D{$count}),0)"); // promedio ticket

                // Formato moneda
                $sheet->getStyle("D2:D{$lastRow}")
                      ->getNumberFormat()->setFormatCode('#,##0.00');

                // Estilo total
                $sheet->getStyle("A{$lastRow}:D{$lastRow}")->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFEEEEEE']],
                    'borders' => ['top' => ['borderStyle' => Border::BORDER_MEDIUM]],
                ]);
            }
        ];
    }
}
