<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examination extends Model
{
    use HasFactory;
    protected $guarded = []; 
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'examination_services')
            ->withPivot('price');
    }

    public function medications()
    {
        return $this->belongsToMany(Medication::class, 'examination_medications')
            ->withPivot('quantity', 'note');
    }
}
