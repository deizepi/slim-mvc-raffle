<?php
 
namespace App\Model;
 
use Illuminate\Database\Eloquent\Model;
 
class Buyer extends Model
{
    protected $table = 'buyer';

    protected $fillable = [
        'name',
        'phone',
        'notes'
    ];

    public function raffles () {
        return $this->hasMany("App\Model\Raffle");
    }
}