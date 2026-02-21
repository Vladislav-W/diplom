<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $table = 'requests';
    protected $primaryKey = 'request_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'request_number',
        'status',
        'organization_from_id',
        'departure_city_id',
        'address_from',
        'notes_from',
        'organization_to_id',
        'arrival_city_id',
        'address_to',
        'notes_to',
        'departure_datetime',
        'arrival_datetime',
        'auto_id',
        'driver_id',
        'responsible_person_id',
        'attorney_for_driver'
    ];

    protected $casts = [
        'departure_datetime' => 'datetime',
        'arrival_datetime' => 'datetime',
        'attorney_for_driver' => 'boolean'
    ];

    public function organizationFrom()
    {
        return $this->belongsTo(Organization::class, 'organization_from_id', 'organization_id');
    }

    public function organizationTo()
    {
        return $this->belongsTo(Organization::class, 'organization_to_id', 'organization_id');
    }

    public function departureCity()
    {
        return $this->belongsTo(City::class, 'departure_city_id', 'city_id');
    }

    public function arrivalCity()
    {
        return $this->belongsTo(City::class, 'arrival_city_id', 'city_id');
    }

    public function responsiblePerson()
    {
        return $this->belongsTo(ResponsiblePerson::class, 'responsible_person_id', 'responsible_person_id');
    }
}