<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $fillable = ['p_code', 'p_name', 't_qty', 'p_rate'];


    protected $appends=['sale_price'];
    public function getSalePriceAttribute(){
        
    }
}
