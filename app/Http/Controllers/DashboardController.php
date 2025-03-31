<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Packaging;
use App\Models\Cake;
use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index(): View
    {
        $totalIngredients = Ingredient::count();
        $totalIngredientQuantity = Ingredient::sum('quantity');
        $totalPackagings = Packaging::count();
        $totalPackagingQuantity = Packaging::sum('quantity');
        $totalCakes = Cake::count();
        $totalRevenue = Product::sum('selling_price');
        $totalProfit = Product::sum('selling_price') - Product::sum('total_cost');

        return view('dashboard', compact(
            'totalIngredients',
            'totalIngredientQuantity',
            'totalPackagings',
            'totalPackagingQuantity',
            'totalCakes',
            'totalRevenue',
            'totalProfit'
        ));
    }
}
