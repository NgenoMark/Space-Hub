<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'space_id',
        'space_name',
        'user_id',
        'booking_date',
        'total_price',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with client (user who booked the space)
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    // Relationship with space (space that was booked)
    public function space()
    {
        return $this->belongsTo(Space::class);
    }

}
