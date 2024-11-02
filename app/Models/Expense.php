<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $table = 'expenses';
    protected $fillable = [
        'date',
        'folio',
        'provider_id',
        'invoiced',
        'folio_invoiced',
        'payment_method_id',
        'subtotal',
        'tax',
        'discount',
        'amount',
        'type',
        'subtype',
        'sub_subtype',
        'description',
        'status'
    ]
}
