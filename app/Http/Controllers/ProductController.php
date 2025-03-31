<?php

namespace App\Http\Controllers;

use App\Models\Cake;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('sell-cake');
    }

    public function sell(Request $request)
    {
        $cake = Cake::find($request->cake_id);
        $quantitySold = $request->quantity_sold;
        $sellingPrice = $request->selling_price;

        $recipe = $cake->recipes()->first();
        $ingredientCost = 0;
        foreach ($recipe->ingredients as $ingredient) {
            $requiredQuantity = $ingredient->pivot->quantity * $quantitySold;
            $ingredientCost += $requiredQuantity * $ingredient->price;
        }

        $packaging = $cake->packagings()->first();
        $packagingCost = $packaging->pivot->quantity * $packaging->price;
        $depreciationCost = $packaging->pivot->depreciation;

        $totalCost = $ingredientCost + $packagingCost + $depreciationCost;

        Product::create([
            'cake_id' => $cake->id,
            'ingredient_cost' => $ingredientCost,
            'packaging_cost' => $packagingCost,
            'depreciation_cost' => $depreciationCost,
            'quantity_sold' => $quantitySold,
            'total_cost' => $totalCost,
            'selling_price' => $sellingPrice
        ]);

        return redirect()->route('products.index')->with('success', 'Bán bánh thành công!');
    }
}
