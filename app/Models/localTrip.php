<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class localTrip extends Model
{
    use HasFactory;
     protected $table=" 'local_trips'";
       protected $fillable = [
  'bus_id',
'location_id',
'time',
'date'];

 public function localBus(){
         return $this->belongsTo(related:'App\Models\localBus',foreignKey:'bus_id',ownerKey:'id');
     }
      public function trips(){
        return $this->hasMany(related:'App\Models\localTrip',foreignKey:'trip_id',localKey:'id');
    }
    public function localBus(){
return $this->belongsTo(related:'App\Models\localLocatin',foreignKey:'location_id',ownerKey:'id');
     }

}
   
