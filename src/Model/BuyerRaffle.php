<?php
 
namespace App\Model;
 
use Illuminate\Database\Eloquent\Model;
 
class BuyerRaffle extends Model
{
    protected $table = 'buyer_raffle';

    protected $fillable = [
        'buyer_id',
        'raffle_id',
        'number'
    ];

    public function raffle() {
        return $this->belongsTo("App\Model\Raffle");
    }

    public function buyer() {
        return $this->belongsTo("App\Model\Buyer");
    }
}