<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class localLocatin extends Model
{
    use HasFactory;
     protected $table="local_locations";
      protected $fillable = [
       
       "depart_location",
    'arrivel_location',
     'depart_station',
    'arrivel_station'
    ];
      public function trips(){
    return $this->hasMany(related:'App\Models\localLocatin',foreignKey:'location_id',localKey:'id');
    }

}
