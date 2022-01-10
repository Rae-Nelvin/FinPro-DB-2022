<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class TransactionDetail extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'transaksiID',
        'barangID',
        'jumlahBarang',
        'totalHarga',
        'additionalNotes'
    ];

    public function transaksiID(){
        return $this->hasOne(Transaction::class,'id','transaksiID');
    }

    public function barangID(){
        return $this->hasOne(Menu::class,'id','barangID');
    }
}
