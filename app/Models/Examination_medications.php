<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examination_medications extends Model
{
    use HasFactory;
    protected $guarded = []; 
    public function medication()
    {
        return $this->belongsTo(Medication::class);
    }
}
