<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    
    protected $table="locations";
       protected $fillable = [
        'depart_location',
        'arrival_location',
        'depart_station',
        'arrival_station'
    ];
       public function trips(){
        return $this->hasMany(related:'App\Models\Trip',foreignKey:'location_id',localKey:'id');
    }
}
