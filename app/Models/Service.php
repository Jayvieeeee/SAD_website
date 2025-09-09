<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $primaryKey = 'service_id';
    public $incrementing = true; 
    protected $keyType = 'int';  

    protected $fillable = [
        'service_name',
        'description',
    ];

    public function appointments()
    {
        return $this->belongsToMany(Appointment::class, 'appointment_service', 'service_id', 'appointment_id');
    }

    public function tools()
    {
        return $this->belongsToMany(Tool::class, 'service_tools', 'service_id', 'tool_id');
    }
}


