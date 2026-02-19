<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponsiblePerson extends Model
{
    use HasFactory;

    protected $table = 'responsible_people';
    protected $primaryKey = 'responsible_person_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'last_name',
        'first_name',
        'second_name',
        'department',
        'post',
        'phone_number'
    ];
}