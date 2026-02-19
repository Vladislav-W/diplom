<?php
// app/Models/RequestCargo.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestCargo extends Model
{
    use HasFactory;

    protected $table = 'request_cargo';
    protected $primaryKey = 'request_cargo_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'request_id',
        'cargo_id',
        'quantity',
        'unit'
    ];

    public function request()
    {
        return $this->belongsTo(Request::class, 'request_id', 'request_id');
    }

    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'cargo_id', 'cargo_id');
    }
}