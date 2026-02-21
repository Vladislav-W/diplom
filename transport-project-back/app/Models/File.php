<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $table = 'files';
    protected $primaryKey = 'file_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'request_id',
        'file_name',
        'file_type',
        'file_data',
        'file_size'
    ];

    protected $casts = [
        'file_data' => 'string'
    ];

    /**
     * Устанавливаем бинарные данные для PostgreSQL
     */
    public function setFileDataAttribute($value)
    {
        $this->attributes['file_data'] = $value;
    }

    /**
     * Получаем бинарные данные
     */
    public function getFileDataAttribute($value)
    {
        return $value;
    }

    public function request()
    {
        return $this->belongsTo(Request::class, 'request_id', 'request_id');
    }
}