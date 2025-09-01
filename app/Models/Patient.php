<?php

namespace App\Models;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Patient extends Model
{
    use HasFactory;

    protected $primaryKey = 'patient_id';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'contact_no',
        'token',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($patient) {
            $patient->token = bin2hex(random_bytes(16));
        });
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id', 'patient_id');
    }
}