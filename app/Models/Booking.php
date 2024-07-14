<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $primaryKey = 'booking_id'; // Specify the primary key

    protected $fillable = [
        'provider_id',
        'space_id',
        'user_id',
        'space_name',
        'full_name',
        'email',
        'phone_number',
        'start_date',
        'end_date',
        'location',
        'status',
        'total_price',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with client (user who booked the space)
    public function client()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship with space (space that was booked)
    public function space()
    {
        return $this->belongsTo(Space::class, 'space_id');
    }

    // Relationship with provider (space provider)
    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }
}
