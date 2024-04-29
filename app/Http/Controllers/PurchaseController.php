<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\User;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function purchase(Request $request, Purchase $purchase)
    {
        $data = $request->validate([
            "v_code" => "required",
            "v_name" => "required",
            "p_code" => "required",
            "p_name" => "required",
            "t_qty" => "required|numeric|min:1",
            "p_rate" => "required|numeric|min:1",
            "p_discount" => "nullable|numeric",
            "cash" => "nullable|numeric|min:0",
            "bank" => "nullable|numeric|min:0",
        ]);

        // now genrate bill
        $purchase = Purchase::create([
            'v_code' => $data['v_code'],
            'v_name' => $data['v_name'],
            'p_code' => $data['p_code'],
            'p_name' => $data['p_name'],
            't_qty' => $data['t_qty'],
            'p_rate' => $data['p_rate'],
            'p_discount' => $data['p_discount'],
            'cash' => $data['cash'],
            'bank' => $data['bank'],
        ]);
        // create purchase with calculated bill

        $purchase->total_bill;

        DB::transaction(function () use ($data) {
            $stock = Stock::where('p_code', $data['p_code'])->first();
            if ($stock) {
                $cost = $stock->t_qty * $stock->p_rate; //total cost of current stock
                $newCost = $data['t_qty'] * $data['p_rate']; //cost of new stock
                $newTotalqty = $stock->t_qty + $data['t_qty']; //total quantity after adding new stock
                $avgPrice = ($cost + $newCost) / $newTotalqty; //update average price
                $stock->p_rate = $avgPrice;  //assigning new average price
                $stock->t_qty += $data['t_qty']; //updating new qty

                $stock->save();   //save the stock
            } else {
                Stock::create([
                    'p_code' => $data['p_code'],
                    'p_name' => $data['p_name'],
                    't_qty' => $data['t_qty'],
                    'p_rate' => $data['p_rate'],
                ]);
            }
        });
        // now check if cash and bank fields are eneterd then update the purchase

        return $purchase;

    }
    public function index(Request $request)
    {
        return Purchase::all();
    }

    // public function update(Purchase $purchase, Request $request)
    // {
    //     $purchase->update($request->all());
    //     return $purchase;
    // }
    public function update(Request $request, Purchase $purchase)
    {
        $data = $request->validate([
            "v_code" => "nullable",
            "v_name" => "nullable",
            "p_code" => "nullable",
            "p_name" => "nullable",
            "t_qty" => "nullable|numeric|min:1",
            "p_rate" => "nullable|numeric|min:1",
            "p_discount" => "nullable|numeric",
            "cash" => "nullable|numeric|min:0",
            "bank" => "nullable|numeric|min:0",
        ]);


        $purchase->update($data);


        $stock = Stock::where('p_code', $purchase['p_code'])->first();
        if ($stock) {
            $cost = $stock->t_qty * $stock->p_rate; //total cost of current stock
            $newCost = $purchase['t_qty'] * $purchase['p_rate']; //cost of new stock
            $newTotalqty = $stock->t_qty + $purchase['t_qty']; //total quantity after adding new stock
            $avgPrice = ($cost + $newCost) / $newTotalqty; //update average price
            $stock->p_rate = $avgPrice;  //assigning new average price
            $stock->t_qty += $purchase['t_qty']; //updating new qty

            $stock->save();   //save the stock
        }

        // now check if cash and bank fields are eneterd then update the purchase

        return $purchase;
    }
}
