<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class localbus extends Model
{
    use HasFactory;
     protected $table="local_buses";
       protected $fillable = [
      ' bus_number',
    'bus_status'
    ];
    public function localTrips(){
        return $this->hasMany(related:'App\Models\localbus ',foreignKey:'bus_id',localKey:'id');}
       
}
