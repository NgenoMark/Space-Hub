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

    public function provider()
{
    return $this->belongsTo(User::class, 'provider_id');
}

protected $primaryKey = 'space_id';


}
