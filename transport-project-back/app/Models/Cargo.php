<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;

    protected $table = 'cargo';
    protected $primaryKey = 'cargo_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'cargo_name',
        'date_of_taking_cargo',
        'type_of_packaging',
        'weight_of_cargo',
        'cargo_volume',
        'quantity',
        'cargo_unit',
        'danger_class',
        'delivery_time',
        'notes'
    ];

    protected $casts = [
        'date_of_taking_cargo' => 'date',
        'delivery_time' => 'datetime',
        'weight_of_cargo' => 'decimal:2',
        'cargo_volume' => 'decimal:2'
    ];
}