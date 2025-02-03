<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sfrt\Invoice;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;
use Illuminate\Support\Str;

class InvoicesController extends Controller
{

  public function index(Request $request)
  {
    $currentMonth = Carbon::now()->month;
    $currentYear = Carbon::now()->year;
    if ($request->ajax()) {

      $facturas = Invoice::query()->sinCancelados() ->whereMonth('fecha', $currentMonth)
      ->whereYear('fecha', $currentYear);
      return DataTables::of($facturas)
        ->addColumn('sfrtNotaDate', function ($result) {
          return '
                    <h5 class="text-truncate font-size-14 mb-1"><a href="javascript: void(0);" class="text-dark">' . $result->nota . '</a></h5>
                    <p class="text-muted mb-0">' . $result->cheques->fecha->format('d-m-Y') . '</p>';
        })
        ->addColumn('sfrtCustomer', function ($result) {
          return '<h5 class="text-truncate font-size-14 mb-1" data-toggle="tooltip" data-placement="top" title="' . $result->customer->nombre . '"><a href="javascript: void(0);" class="text-dark">' . Str::limit($result->customer->nombre, 15, '...') . '</a></h5>
                            <span class="badge badge-soft-primary" data-toggle="tooltip" data-placement="top" title="' . $result->customer->email . '">' . Str::limit($result->customer->email, 15, '...') . '</span>';
        })
        ->addColumn('sfrtCustomerEmail', function ($result) {
          return '<span class="badge badge-soft-primary">' . Str::limit($result->customer->email, 15, '...') . '</span>';
        })
        ->addColumn('formapago', function ($result) {
          $payment = '';
          if ($result->FormaDePagoTexto == 'Tarjeta de débito') {
            $payment .= '<i class="fab fa-cc-visa text-info me-1"></i>' . $result->FormaDePagoTexto;
          } elseif ($result->FormaDePagoTexto == 'Tarjeta de crédito') {
            $payment .= '<i class="fab fa-cc-mastercard text-primary me-1"></i>' . $result->FormaDePagoTexto;
          } elseif ($result->FormaDePagoTexto == 'Por definir') {
            $payment .= '<i class="fas fa-clock me-1"></i>' . $result->FormaDePagoTexto;
          } elseif ($result->FormaDePagoTexto == 'Transferencia electrónica de fondos') {
            $payment .= '<i class="fas fa-exchange-alt text-warning me-1"></i>' . $result->FormaDePagoTexto;
          } elseif ($result->FormaDePagoTexto == 'Efectivo') {
            $payment .= '<i class="fas fa-money-bill-alt text-success me-1"></i> ' . $result->FormaDePagoTexto;
          } else {
            $payment .= '<i class="fab fa-cc-other-credit-card me-1"></i> ' . $result->FormaDePagoTexto;
          }
          return $payment;
        })
        ->editColumn('idmetodopago_SAT', function ($result) {
          $opciones = '';
          if ($result->idmetodopago_SAT == 'PUE') {
            $opciones .= '<span class="badge bg-success">' . $result->idmetodopago_SAT . '</span>';
          } else {
            $opciones .=  '<span class="badge bg-warning">' . $result->idmetodopago_SAT . '</span>';
          }
          return $opciones;
        })
        ->editColumn('fecha', function ($result) {
          return '
                    <h5 class="text-truncate font-size-14 mb-1"><a href="javascript: void(0);" class="text-dark">' . $result->serie . $result->folio . '</a></h5>
                    <p class="text-muted mb-0">' . $result->fecha->format('d-m-Y') . '</p>';
        })
        ->rawColumns(['sfrtNotaDate', 'formapago', 'sfrtCustomer', 'sfrtCustomerEmail', 'idmetodopago_SAT', 'fecha'])
        ->make(true);
    }

    return view('invoices.index');
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}
