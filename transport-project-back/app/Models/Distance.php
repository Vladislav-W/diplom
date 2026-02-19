<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distance extends Model
{
    use HasFactory;

    protected $table = 'distances';
    protected $primaryKey = 'distance_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'departure_city_id',
        'arrival_city_id',
        'distance'
    ];

    public function departureCity()
    {
        return $this->belongsTo(City::class, 'departure_city_id', 'city_id');
    }

    public function arrivalCity()
    {
        return $this->belongsTo(City::class, 'arrival_city_id', 'city_id');
    }
}