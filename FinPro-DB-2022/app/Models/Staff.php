<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Staff extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'gender',
        'phone',
        'jobDesc',
        'linkGambar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    public function cashierStaffID(){
        return $this->belongsTo(Transaction::class,'cashierStaffID','id');
    }
    
    public function chefStaffID(){
        return $this->belongsTo(Transaction::class,'chefStaffID','id');
    }

    public function staffID_delivery(){
        return $this->belongsTo(Delivery::class,'deliveryStaffID','id');
    }

}
