<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'dob',
        'age',
        'gender',
        'contact_number',
        'email',
        'address',
        'username',
        'password',
        'height',
        'Weight', 
        'BMI',
        'BMIStatus',
        'bloodtype',
        'sex',
        'insurance_provider',
        'policy_number',
        'picture'
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
     public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'appointments');
    }

     public function getAgeAttribute()
    {
        if ($this->dob) {
            return Carbon::parse($this->dob)->age;
        }
        return null;
    }
}
