<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;
    protected $table="trips";
       protected $fillable = [
         'bus_id',
         'location_id',
         'date',
         'time',
         'company_ID'
    ];  
       public function reservations(){
        return $this->hasMany(related:'App\Models\Reservation',foreignKey:'trip_id',localKey:'id');
    }
     public function reservation_dates(){
        return $this->hasMany(related:'App\Models\Reservation',foreignKey:'date',localKey:'date');
    }


    public function buses(){
        return $this->belongsTo(related:'App\Models\Bus',foreignKey:'bus_id',ownerKey:'id');
    }
    public function locations(){
        return $this->belongsTo(related:'App\Models\Location',foreignKey:'location_id',ownerKey:'id');
    }
      public function feature(){
        return $this->belongsTo(related:'App\Models\Feature',foreignKey:'company_ID',ownerKey:'id');
    }
}

