<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelCars extends Model
{
    use HasFactory;
    protected $fillable = ['name']; // Add this line



    public function cars()
    {
        return $this->hasMany(Cars::class);
    }

}
