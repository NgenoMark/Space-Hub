<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_name',  // Assuming warehouse_name is equivalent to space_name for warehouses
        'description',
        'price',
        'deal_id',
        'provider_id',
    ];

    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }
}
