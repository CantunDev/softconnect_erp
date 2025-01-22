<?php

namespace App\Models\Sfrt;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Products extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'productos';
    public $timestamps = false;
    protected $primaryKey = 'idproducto';
    protected $keyType = 'string';


    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'idgrupo','idgrupo');
    }

    public function cheques_details(): HasMany
    {
        return $this->hasMany(ChequesDetails::class, 'idproducto', 'idproducto');
    }
}
