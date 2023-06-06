<?php
 
namespace App\Model;
 
use Illuminate\Database\Eloquent\Model;
 
class Raffle extends Model
{
    protected $table = 'raffle';

    protected $fillable = [
        'name',
        'slug',
        'value',
        'quantity'
    ];

    public function buyers () {
        return $this->hasMany("App\Model\BuyerRaffle");
    }
}