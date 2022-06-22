<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $table="reservations";

      protected $fillable = [
        'user_id',
        'trip_id',
        'seat_number',
        'date',
        'time'
    ];
     public function trip(){
        return $this->belongsTo(related:'App\Models\Trip',foreignKey:'trip_id',ownerKey:'id');
    }
     public function user(){
        return $this->belongsTo(related:'App\Models\User',foreignKey:'user_id',ownerKey:'id');
    }
    public function trip_dates(){
        return $this->hasMany(related:'App\Models\Reservation',foreignKey:'date',localKey:'date');
    }
    
}




 
   

   

