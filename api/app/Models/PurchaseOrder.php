<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class PurchaseOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'bond_id',
        'order_date', //Y-m-d
        'number_bonds_received',//digit
      ];
    public function bonds(): BelongsTo
    {
        return $this->belongsTo(Bond::class);
    }
}
