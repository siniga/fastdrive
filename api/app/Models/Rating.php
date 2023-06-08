<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'driver_id', 'rating', 'comment',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function drivers()
    {
        return $this->belongsTo(Driver::class);
    }

    public function rides()
    {
        return $this->belongsTo(Ride::class);
    }
}
