<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class localReservation extends Model
{
    use HasFactory;
     protected $table="local_reservations";
       protected $fillable = [
    'user_id',
    'trip_id',
    'ticket_days',
    'enabel'
    ];
public function localBus(){
         return $this->belongsTo(related:'App\Models\localTrip',foreignKey:'trip_id',ownerKey:'id');
     }
     public function localBus(){
         return $this->belongsTo(related:'App\Models\User',foreignKey:'user_id',ownerKey:'id');
     }
    
}
       