<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;
    protected $table="features";
      protected $fillable = [
        'comany_name',
        'wifi',
        'condition',
        'mobile_charger',
    ];
    public function buses(){
        return $this->hasMany(related:'App\Models\Bus',foreignKey:'company_ID',localKey:'id');
    }
      public function trip(){
        return $this->hasMany(related:'App\Models\Trip',foreignKey:'company_ID',localKey:'id');
    }
    

}
