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
        // calculate the Amount of total bill
        $totalBill = $data['t_qty'] * $data['p_rate'];
        // now substract discount
        if (isset($data["p_discount"])) {
            $totalBill -= $data["p_discount"];
        }
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
            't_bill' => $totalBill,
        ]);
        // create purchase with calculated bill



        DB::transaction(function () use ($data) {
            $stock = Stock::where('p_code', $data['p_code'])->first();
            if ($stock) {
                $cost = $stock->t_qty * $stock->p_rate;
                $newCost = $data['t_qty'] * $data['p_rate'];
                $newTotalqty = $stock->t_qty + $data['t_qty'];
                $avgPrice = ($cost + $newCost) / $newTotalqty;
                $avgprice = $cost / ($data['t_qty'] * $data['p_rate']);
                $stock->p_rate = $avgprice;
                $stock->p_rate = $avgPrice;
                $stock->t_qty += $data['t_qty'];

                $stock->save();
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

        $balance = $totalBill - (($data['cash'] ?? 0) + ($data['bank'] ?? 0));
        $purchase->balance = $balance;
        $purchase->save();
        return $purchase;

    }
    public function index(Request $request)
    {
        return Purchase::all();
    }
}
