<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\User;
use App\Models\Stock;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function sales(Request $request)
    {


        // if ($type === 'sale') {
        //record sales effect and decrease the sale
        //     $sale = new Sale();
        //     $sale->item = $item;
        //     $sale->qty = $qty;
        //     $sale->price = $price;
        //     $sale->save();
        //     //update stock after sale
        //     $stock = Stock::where('item', $item)->first();
        //     if ($stock) {
        //         $stock->qty -= $qty;
        //         $stock->save();
        //     }
        //     return response()->json(["message" => $sale, "has been sold"], 201);
        // }
        // return response()->json(["message" => "invalid data"], 400);
    }
}

