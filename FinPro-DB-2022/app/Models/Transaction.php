<?php

namespace App\Models;

use App\Models\Transaction as ModelsTransaction;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Transaction extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pembeliID',
        'staffID',
        'totalHarga',
        'status',
    ];

    public function pembeliID(){
        return $this->hasOne(User::class,'id','pembeliID');
    }

    public function staffID(){
        return $this->hasOne(Staff::class,'id','staffID');
    }

    public function transaksiID(){
        return $this->belongsTo(TransactionDetail::class,'transactionID','id');
    }
}
