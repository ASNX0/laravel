<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;
    protected $table="buses";
     protected $casts = [
        'bus_status' => 'boolean',
    ];
     protected $fillable = [
        'bus_name',
        'bus_status',
        'company_ID',
        'location_id',
    ];

    public function feature(){
        return $this->belongsTo(related:'App\Models\Feature',foreignKey:'company_ID',ownerKey:'id');
    }
       public function trip(){
        return $this->hasMany(related:'App\Models\Trip',foreignKey:'bus_id',localKey:'id');
    }
}
