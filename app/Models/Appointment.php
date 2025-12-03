<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    // Fillable fields for mass assignment
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_date',
        'appointment_time',
        'remarks',
        'status',
        'services',
    ];

    // Relationship: each appointment has one prescription
    public function prescription()
    {
        return $this->hasOne(Prescription::class, 'appointment_id');
    }

    // Relationship: appointment belongs to a patient
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // Relationship: appointment belongs to a doctor
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
}
