<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $primaryKey = 'appointment_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'patient_id',
        'service_id',
        'schedule_datetime',
        'status',
        'confirmation_code',
    ];

    public function services()
    {
        return $this->belongsToMany(Service::class, 'appointment_service', 'appointment_id', 'service_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'patient_id');
    }
}
