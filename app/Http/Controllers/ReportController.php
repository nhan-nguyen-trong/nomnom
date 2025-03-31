<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cake;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReportController extends Controller
{
    /**
     * Display a listing of the revenue reports.
     */
    public function index(): View
    {
        $products = Product::all();
        return view('reports.index', compact('products'));
    }

    /**
     * Show the form for creating a new report (selling a cake).
     */
    public function create(): View
    {
        $cakes = Cake::all();
        return view('reports.create', compact('cakes'));
    }

    /**
     * Store a newly created report in storage (sell a cake).
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

        return redirect()->route('reports.index')->with('success', 'Thêm báo cáo doanh thu thành công!');
    }

    /**
     * Show the form for editing the specified report.
     */
    public function edit(int $id): View
    {
        $product = Product::findOrFail($id);
        $cakes = Cake::all();
        return view('reports.edit', compact('product', 'cakes'));
    }

    /**
     * Update the specified report in storage.
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

        // Cập nhật thông tin báo cáo
        $product->update([
            'cake_id' => $cake->id,
            'ingredient_cost' => $ingredientCost,
            'packaging_cost' => $packagingCost,
            'depreciation_cost' => $depreciationCost,
            'quantity_sold' => $quantitySold,
            'total_cost' => $totalCost,
            'selling_price' => $sellingPrice
        ]);

        return redirect()->route('reports.index')->with('success', 'Cập nhật báo cáo doanh thu thành công!');
    }

    /**
     * Show the form for deleting the specified report.
     */
    public function delete(int $id): View
    {
        $product = Product::findOrFail($id);
        return view('reports.delete', compact('product'));
    }

    /**
     * Remove the specified report from storage (soft delete).
     */
    public function destroy(int $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('reports.index')->with('success', 'Xóa báo cáo doanh thu thành công!');
    }

    /**
     * Display a listing of the trashed reports.
     */
    public function recycle(): View
    {
        $products = Product::onlyTrashed()->get();
        return view('reports.recycle', compact('products'));
    }

    /**
     * Restore the specified report from trash.
     */
    public function restore(int $id): RedirectResponse
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();
        return redirect()->route('reports.recycle')->with('success', 'Khôi phục báo cáo doanh thu thành công!');
    }

    /**
     * Permanently delete the specified report from storage.
     */
    public function forceDelete(int $id): RedirectResponse
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->forceDelete();
        return redirect()->route('reports.recycle')->with('success', 'Xóa vĩnh viễn báo cáo doanh thu thành công!');
    }
}
