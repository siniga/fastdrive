<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLocation extends Model
{
    use HasFactory;

    protected $table = 'user_locations';

    protected $fillable = [
        'user_id',
        'name',
        'status',
        'latitude',
        'longitude',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
