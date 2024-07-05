<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Space extends Model
{
    use HasFactory;

    protected $primaryKey = 'space_id';

    protected $fillable = [
        'space_name', 'space_type', 'location', 'description', 'capacity', 'price', 'provider_id'
    ];

    /**
     * Get the provider that owns the space.
     */
    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }
}
