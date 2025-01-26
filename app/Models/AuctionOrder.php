<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuctionOrder extends Model
{
    use HasFactory;
    protected $table = 'auction_order';
    protected $primaryKey = 'id';
    protected $fillable = ['najirsName', 'najirsMobile', 'buyersName', 'buyersMobile'];
    public $timestamps = false;
}
