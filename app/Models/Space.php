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

    public function provider(){
        return $this->belongsTo(User::class, 'provider_id');
    }

    // Relationship with owner (user who owns the space)
    public function owner()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    // Space model
    
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'space_id');
    }

    public function update(array $attributes = [], array $options = [])
    {
        // Implement your update logic here
        return parent::update($attributes, $options);
    }

}
