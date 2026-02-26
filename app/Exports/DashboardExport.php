<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\VentasSheet;
use App\Exports\Sheets\ClientesSheet;

class DashboardExport implements WithMultipleSheets
{
    public function __construct(
        protected $cortes,
        protected $projections,
        protected $restaurant
    ) {}

    public function sheets(): array
    {
        return [
            new VentasSheet($this->cortes),
            new ClientesSheet($this->cortes, $this->projections),
        ];
    }
}