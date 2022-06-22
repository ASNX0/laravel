<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class localPayment extends Model
{
    use HasFactory;
     protected $table="'local_payments'";
       protected $fillable = [
        'user_id',
        'date_payment'
        
    ];
     
       
}
