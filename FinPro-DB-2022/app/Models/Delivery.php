<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Delivery extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'transaksiID',
        'status',
        'alamatPembeli',
        'pembeliID',
        'staffID',
    ];

    public function transaksiID_delivery(){
        return $this->hasOne(Transaction::class,'id','transaksiID');
    }
    public function pembeliID_delivery(){
        return $this->hasOne(User::class,'id','pembeliID');
    }
    public function staffID_delivery(){
        return $this->hasOne(Staff::class,'id','staffID');
    }
    
}
