<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Space extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'location', 'capacity', 'price'];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
