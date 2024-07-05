<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $primaryKey = 'booking_id'; // Specify the primary key

    protected $fillable = [
        'space_id',
        'space_name',
        'user_id',
        'space_id',
        'full_name',
        'email',
        'phone_number',
        'booking_date',
        'location',
        'status',
        'total_price',
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
