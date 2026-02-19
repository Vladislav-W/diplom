<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutoPark extends Model
{
    use HasFactory;

    protected $table = 'auto_park';
    protected $primaryKey = 'auto_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'auto_name',
        'state_number',
        'capacity',
        'driver_tab_number'
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_tab_number', 'driver_tab_number');
    }
}