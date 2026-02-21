<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialItem extends Model
{
    use HasFactory;

    protected $table = 'material_items';
    protected $primaryKey = 'material_item_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'cargo_id',
        'name',
        'quantity',
        'unit'
    ];

    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'cargo_id', 'cargo_id');
    }
}
