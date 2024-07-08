<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    protected $fillable = [
        'name',
        'description',
        'discount',
    ];

    // Relationship with Space model
    public function spaces()
    {
        return $this->hasMany(Space::class);
    }
}
