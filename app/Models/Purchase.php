<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable = ['v_code', 'v_name', 'p_code', 'p_name', 't_qty', 'p_rate', 'p_discount', 't_bill', 'cash', 'bank', 'balance'];
}
