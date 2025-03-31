<?php

namespace App\Http\Controllers;

use App\Models\Cake;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(): View
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product (selling a cake).
     */
    public function create(): View
    {
        $cakes = Cake::all();
        return view('products.create', compact('cakes'));
    }

    /**
     * Store a newly created product in storage (sell a cake).
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'cake_id' => 'required|exists:cakes,id',
            'quantity_sold' => 'required|numeric|min:1',
            'selling_price' => 'required|numeric|min:0',
        ]);

        $cake = Cake::findOrFail($request->cake_id);
        $quantitySold = $request->quantity_sold;
        $sellingPrice = $request->selling_price;

        // Lấy công thức và tính chi phí nguyên liệu
        $recipe = $cake->recipes()->first();
        $ingredientCost = 0;
        foreach ($recipe->ingredients as $ingredient) {
            $requiredQuantity = $ingredient->pivot->quantity * $quantitySold;
            $ingredientCost += $requiredQuantity * $ingredient->price;
        }

        // Lấy bao bì và tính chi phí bao bì
        $packaging = $cake->packagings()->first();
        $packagingCost = $packaging->pivot->quantity * $packaging->price;
        $depreciationCost = $packaging->pivot->depreciation;

        $totalCost = $ingredientCost + $packagingCost + $depreciationCost;

        // Lưu thông tin bán hàng
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

    /**
     * Show the form for editing the specified product.
     */
    public function edit(int $id): View
    {
        $product = Product::findOrFail($id);
        $cakes = Cake::all();
        return view('products.edit', compact('product', 'cakes'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'cake_id' => 'required|exists:cakes,id',
            'quantity_sold' => 'required|numeric|min:1',
            'selling_price' => 'required|numeric|min:0',
        ]);

        $product = Product::findOrFail($id);
        $cake = Cake::findOrFail($request->cake_id);
        $quantitySold = $request->quantity_sold;
        $sellingPrice = $request->selling_price;

        // Lấy công thức và tính chi phí nguyên liệu
        $recipe = $cake->recipes()->first();
        $ingredientCost = 0;
        foreach ($recipe->ingredients as $ingredient) {
            $requiredQuantity = $ingredient->pivot->quantity * $quantitySold;
            $ingredientCost += $requiredQuantity * $ingredient->price;
        }

        // Lấy bao bì và tính chi phí bao bì
        $packaging = $cake->packagings()->first();
        $packagingCost = $packaging->pivot->quantity * $packaging->price;
        $depreciationCost = $packaging->pivot->depreciation;

        $totalCost = $ingredientCost + $packagingCost + $depreciationCost;

        // Cập nhật thông tin bán hàng
        $product->update([
            'cake_id' => $cake->id,
            'ingredient_cost' => $ingredientCost,
            'packaging_cost' => $packagingCost,
            'depreciation_cost' => $depreciationCost,
            'quantity_sold' => $quantitySold,
            'total_cost' => $totalCost,
            'selling_price' => $sellingPrice
        ]);

        return redirect()->route('products.index')->with('success', 'Cập nhật giao dịch thành công!');
    }

    /**
     * Show the form for deleting the specified product.
     */
    public function delete(int $id): View
    {
        $product = Product::findOrFail($id);
        return view('products.delete', compact('product'));
    }

    /**
     * Remove the specified product from storage (soft delete).
     */
    public function destroy(int $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Xóa giao dịch thành công!');
    }

    /**
     * Display a listing of the trashed products.
     */
    public function recycle(): View
    {
        $products = Product::onlyTrashed()->get();
        return view('products.recycle', compact('products'));
    }

    /**
     * Restore the specified product from trash.
     */
    public function restore(int $id): RedirectResponse
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();
        return redirect()->route('products.recycle')->with('success', 'Khôi phục giao dịch thành công!');
    }

    /**
     * Permanently delete the specified product from storage.
     */
    public function forceDelete(int $id): RedirectResponse
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->forceDelete();
        return redirect()->route('products.recycle')->with('success', 'Xóa vĩnh viễn giao dịch thành công!');
    }
}
