<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\{FromCollection, WithTitle, WithHeadings,
    WithStyles, WithColumnWidths, WithMapping, ShouldAutoSize, WithEvents};
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\{Fill, Alignment, Border, NumberFormat};
use Carbon\Carbon;

class VentasSheet implements FromCollection, WithTitle, WithHeadings,
    WithStyles, WithMapping, ShouldAutoSize, WithEvents
{
    protected $cortes;

    public function __construct($cortes) { $this->cortes = $cortes; }

    public function title(): string { return 'Ventas del Mes'; }

    public function collection() { return $this->cortes; }

    public function headings(): array
    {
        return ['Fecha','Cuentas','Clientes','Total','IVA','Subtotal','Efectivo','Propinas','Tarjeta','Descuento'];
    }

    public function map($corte): array
    {
        return [
            ucfirst(Carbon::parse($corte->dia)->isoFormat('ddd D MMM')),
            $corte->total_cuentas,
            $corte->total_clientes,
            $corte->total_venta,
            $corte->total_iva,
            $corte->total_subtotal,
            $corte->total_efectivo,
            $corte->total_propina,
            $corte->total_tarjeta,
            $corte->total_descuento,
        ];
    }

    public function styles($sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                  'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFC62300']]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet     = $event->sheet->getDelegate();
                $lastRow   = $this->cortes->count() + 2;
                $totalRow  = $lastRow;

                // Fila de totales
                $sheet->setCellValue("A{$totalRow}", 'TOTAL');
                foreach (['B','C','D','E','F','G','H','I','J'] as $i => $col) {
                    $sheet->setCellValue("{$col}{$totalRow}", "=SUM({$col}2:{$col}" . ($totalRow - 1) . ")");
                }

                // Formato moneda columnas D-J
                $moneyFormat = '#,##0.00';
                foreach (['D','E','F','G','H','I','J'] as $col) {
                    $sheet->getStyle("{$col}2:{$col}{$totalRow}")
                          ->getNumberFormat()->setFormatCode($moneyFormat);
                }

                // Estilo fila total
                $sheet->getStyle("A{$totalRow}:J{$totalRow}")->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFEEEEEE']],
                    'borders' => ['top' => ['borderStyle' => Border::BORDER_MEDIUM]],
                ]);
            }
        ];
    }
}