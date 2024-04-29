<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable = ['v_code', 'v_name', 'p_code', 'p_name', 't_qty', 'p_rate', 'p_discount', 't_bill', 'cash', 'bank', 'balance'];

    protected $appends = ['total_bill', 'balance'];

    public function getTotalBillAttribute()
    {
        return $this->p_rate * $this->t_qty - $this->p_discount;
    }

    public function getBalanceAttribute()
    {
        return $this->total_bill - (($this['cash']) + ($this['bank']));
    }
}


