<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $table = 'drivers';
    protected $primaryKey = 'driver_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'driver_tab_number',
        'last_name',
        'first_name',
        'second_name',
        'driver_phone_number'
    ];
}