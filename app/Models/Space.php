<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Space extends Model
{
    use HasFactory;

    protected $fillable = [
        'space_name', 'space_type', 'location', 'description', 'capacity', 'price', 'provider_id'
    ];

    public function provider(){
        return $this->belongsTo(User::class, 'provider_id');
    }

    protected $primaryKey = 'space_id';

    // Relationship with owner (user who owns the space)
    public function owner()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    // Relationship with bookings (one-to-many)
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

        // Space model
    public function update(array $attributes = [], array $options = [])
    {
        // Implement your update logic here
        return parent::update($attributes, $options);
    }

}