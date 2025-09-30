<?php

namespace App\DataTables;

use App\Models\Sfrt\Provider;
use Illuminate\Support\Facades\Auth;
// use Yajra\DataTables\DataTables;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Services\DataTable;


class ProvidersDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('name', function ($provider) {
                return $name = '
                    <h5 class="text-truncate font-size-14 mb-1"><a href="javascript: void(0);" class="text-dark">' . $provider->nombre . '</a></h5>
                    <p class="text-muted mb-0">' . $provider->razonsocial . '</p>';
            })
            ->addColumn('action', function ($provider) {
                $opciones = '';
                if (Auth::user()->can('read_providers')) {
                    $opciones .= '<button type="button"  onclick="btnInfo(' . $provider->id . ')" class="btn btn-sm text-info action-icon icon-dual-blue"><i class="mdi mdi-information-outline font-size-18"></i></button>';
                }
                return $opciones;
            })
            ->addColumn('purchases', function ($provider) {
                return $provider->purchases_count;
            })
            ->addColumn('average', function ($provider) {
                return '$' . number_format($provider->average_total ?? 0, 2);
            })
            ->rawColumns(['name', 'action']);
    }
    public function query()
{
    return Provider::query()
        ->select([
            'proveedores.idproveedor',
            'proveedores.nombre',
            'proveedores.razonsocial',
            'proveedores.credito',
            DB::raw('(SELECT COUNT(*) FROM compras WHERE compras.idproveedor = proveedores.idproveedor) as purchases_count'),
            DB::raw('ISNULL((SELECT AVG(total) FROM compras WHERE compras.idproveedor = proveedores.idproveedor), 0) as average_total')
        ]);
}

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('table_providers')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1, 'asc') // Ordenar por la primera columna (DT_RowIndex)
            ->parameters([
                'language' => [
                    'url' => '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                ]
            ]);
    }

    protected function getColumns()
    {
        return [
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => '#', 'orderable' => false],
            ['data' => 'nombre', 'name' => 'nombre', 'title' => 'Nombre'],
            ['data' => 'razonsocial', 'name' => 'razonsocial', 'title' => 'Razón Social'],
            ['data' => 'purchases_count', 'name' => 'purchases_count', 'title' => 'Compras', 'searchable' => false],
            ['data' => 'average_total', 'name' => 'average_total', 'title' => 'Promedio', 'searchable' => false],
            ['data' => 'credito', 'name' => 'credito', 'title' => 'Crédito'],
            ['data' => 'action', 'name' => 'action', 'title' => 'Acciones', 'orderable' => false, 'searchable' => false],
        ];
    }
}