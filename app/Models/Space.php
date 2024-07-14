<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Space extends Model
{
    use HasFactory;

    protected $primaryKey = 'space_id';

    protected $fillable = [
        'space_name', 'space_type', 'location', 'description', 'capacity', 'price', 'provider_id', 'images'
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function provider(){
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'space_id');
    }

    public function update(array $attributes = [], array $options = [])
    {
        return parent::update($attributes, $options);
    }
}
