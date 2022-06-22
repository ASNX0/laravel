<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject,MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
       protected $table="users";
    protected $fillable = [
        'type',
        'name',
        'token',
        'tiket',
        'email',
        'password',
        'phone_number',
        'social_number',
        'vehicle_registration',
        'driver_license',

    ];
       public function reservation(){
        return $this->hasMany(related:'App\Models\Reservation',foreignKey:'user_id',localKey:'id');
    }
     public function reservations(){
      return $this->belongsTo(related:'App\Models\localReservation',foreignKey:'user_id',localKey:'id');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['email_verified_at' => 'datetime'];


    public function getJWTIdentifier()
    {
        return $this->getKey();

    }//end getJWTIdentifier()


    public function getJWTCustomClaims()
    {
        return [];

    }//end getJWTCustomClaims()


    public function todos()
    {
        return $this->hasMany(Todo::class, 'created_by', 'id');

    }
    //end todos()


}//end class
