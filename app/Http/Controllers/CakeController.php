<?php

namespace App\Http\Controllers;

use App\Models\Cake;
use App\Models\Ingredient;
use App\Models\Packaging;
use App\Models\Recipe;
use Illuminate\Http\Request;

class CakeController extends Controller
{
    public function index()
    {
        return view('produce-cake');
    }

    public function produce(Request $request)
    {
        $cake = Cake::create(['name' => $request->name]);
        $recipe = Recipe::find($request->recipe_id);
        $quantity = $request->quantity;
        $packaging = Packaging::find($request->packaging_id);

        $cake->recipes()->attach($recipe->id, ['quantity' => $quantity]);
        $cake->packagings()->attach($packaging->id, [
            'quantity' => $quantity,
            'depreciation' => $request->depreciation ?? 0
        ]);

        foreach ($recipe->ingredients as $ingredient) {
            $requiredQuantity = $ingredient->pivot->quantity * $quantity;
            $ingredient->quantity -= $requiredQuantity;
            $ingredient->save();
        }

        $packaging->quantity -= $quantity;
        $packaging->save();

        return redirect()->route('cakes.index')->with('success', 'Sản xuất bánh thành công!');
    }
}
