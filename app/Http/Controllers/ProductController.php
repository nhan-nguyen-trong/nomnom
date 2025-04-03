<?php

namespace App\Http\Controllers;

use App\Models\Cake;
use App\Models\Ingredient;
use App\Models\Packaging;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(): View
    {
        $products = Product::with('cake')->get();
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

        $cake = Cake::with(['recipe.ingredients', 'packagings'])->findOrFail($request->cake_id);
        $quantitySold = $request->quantity_sold;
        $sellingPrice = $request->selling_price;

        // 1. Kiểm tra số lượng tồn kho
        // Kiểm tra nguyên liệu
        if ($cake->recipe && $cake->recipe->ingredients) {
            foreach ($cake->recipe->ingredients as $ingredient) {
                $requiredQuantity = $ingredient->pivot->quantity * $quantitySold;
                if ($requiredQuantity > $ingredient->quantity) {
                    return redirect()->back()->with('error', "Không đủ nguyên liệu {$ingredient->name} trong kho. Cần {$requiredQuantity} {$ingredient->unit}, nhưng chỉ có {$ingredient->quantity} {$ingredient->unit}.");
                }
            }
        }

        // Kiểm tra bao bì
        foreach ($cake->packagings as $packaging) {
            $requiredQuantity = $quantitySold; // Mỗi bánh dùng 1 bao bì
            if ($requiredQuantity > $packaging->quantity) {
                return redirect()->back()->with('error', "Không đủ bao bì {$packaging->name} trong kho. Cần {$requiredQuantity} {$packaging->unit}, nhưng chỉ có {$packaging->quantity} {$packaging->unit}.");
            }
        }

        // 2. Tính chi phí
        // Chi phí nguyên liệu
        $ingredientCostPerCake = 0;
        if ($cake->recipe && $cake->recipe->ingredients) {
            $ingredientCostPerCake = $cake->recipe->ingredients->sum(function ($ingredient) {
                $unitPrice = $ingredient->price / $ingredient->quantity;
                $requiredQuantity = $ingredient->pivot->quantity;
                return $unitPrice * $requiredQuantity;
            });
        }
        $totalIngredientCost = $ingredientCostPerCake * $quantitySold;

        // Chi phí bao bì
        $packagingCostPerCake = $cake->packagings->sum('price');
        $totalPackagingCost = $packagingCostPerCake * $quantitySold;

        // Khấu hao
        $depreciationCostPerCake = $cake->depreciation;
        $totalDepreciationCost = $depreciationCostPerCake * $quantitySold;

        // Tổng chi phí
        $totalCost = $totalIngredientCost + $totalPackagingCost + $totalDepreciationCost;

        // 3. Trừ số lượng tồn kho và lưu giao dịch (dùng transaction để đảm bảo tính toàn vẹn dữ liệu)
        DB::transaction(function () use ($cake, $quantitySold, $totalIngredientCost, $totalPackagingCost, $totalDepreciationCost, $totalCost, $sellingPrice) {
            // Trừ số lượng nguyên liệu
            if ($cake->recipe && $cake->recipe->ingredients) {
                foreach ($cake->recipe->ingredients as $ingredient) {
                    $requiredQuantity = $ingredient->pivot->quantity * $quantitySold;
                    $ingredient->quantity -= $requiredQuantity;
                    $ingredient->save();
                }
            }

            // Trừ số lượng bao bì
            foreach ($cake->packagings as $packaging) {
                $requiredQuantity = $quantitySold; // Mỗi bánh dùng 1 bao bì
                $packaging->quantity -= $requiredQuantity;
                $packaging->save();
            }

            // Lưu giao dịch
            Product::create([
                'cake_id' => $cake->id,
                'ingredient_cost' => $totalIngredientCost,
                'packaging_cost' => $totalPackagingCost,
                'depreciation_cost' => $totalDepreciationCost,
                'quantity_sold' => $quantitySold,
                'total_cost' => $totalCost,
                'selling_price' => $sellingPrice,
            ]);
        });

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
        $oldQuantitySold = $product->quantity_sold; // Số lượng cũ để hoàn lại tồn kho
        $cake = Cake::with(['recipe.ingredients', 'packagings'])->findOrFail($request->cake_id);
        $quantitySold = $request->quantity_sold;
        $sellingPrice = $request->selling_price;

        // 1. Hoàn lại số lượng tồn kho (dựa trên số lượng cũ)
        DB::transaction(function () use ($product, $oldQuantitySold) {
            $oldCake = Cake::with(['recipe.ingredients', 'packagings'])->findOrFail($product->cake_id);

            // Hoàn lại nguyên liệu
            if ($oldCake->recipe && $oldCake->recipe->ingredients) {
                foreach ($oldCake->recipe->ingredients as $ingredient) {
                    $requiredQuantity = $ingredient->pivot->quantity * $oldQuantitySold;
                    $ingredient->quantity += $requiredQuantity;
                    $ingredient->save();
                }
            }

            // Hoàn lại bao bì
            foreach ($oldCake->packagings as $packaging) {
                $requiredQuantity = $oldQuantitySold;
                $packaging->quantity += $requiredQuantity;
                $packaging->save();
            }
        });

        // 2. Kiểm tra số lượng tồn kho với số lượng mới
        // Kiểm tra nguyên liệu
        if ($cake->recipe && $cake->recipe->ingredients) {
            foreach ($cake->recipe->ingredients as $ingredient) {
                $requiredQuantity = $ingredient->pivot->quantity * $quantitySold;
                if ($requiredQuantity > $ingredient->quantity) {
                    return redirect()->back()->with('error', "Không đủ nguyên liệu {$ingredient->name} trong kho. Cần {$requiredQuantity} {$ingredient->unit}, nhưng chỉ có {$ingredient->quantity} {$ingredient->unit}.");
                }
            }
        }

        // Kiểm tra bao bì
        foreach ($cake->packagings as $packaging) {
            $requiredQuantity = $quantitySold;
            if ($requiredQuantity > $packaging->quantity) {
                return redirect()->back()->with('error', "Không đủ bao bì {$packaging->name} trong kho. Cần {$requiredQuantity} {$packaging->unit}, nhưng chỉ có {$packaging->quantity} {$packaging->unit}.");
            }
        }

        // 3. Tính chi phí
        // Chi phí nguyên liệu
        $ingredientCostPerCake = 0;
        if ($cake->recipe && $cake->recipe->ingredients) {
            $ingredientCostPerCake = $cake->recipe->ingredients->sum(function ($ingredient) {
                $unitPrice = $ingredient->price / $ingredient->quantity;
                $requiredQuantity = $ingredient->pivot->quantity;
                return $unitPrice * $requiredQuantity;
            });
        }
        $totalIngredientCost = $ingredientCostPerCake * $quantitySold;

        // Chi phí bao bì
        $packagingCostPerCake = $cake->packagings->sum('price');
        $totalPackagingCost = $packagingCostPerCake * $quantitySold;

        // Khấu hao
        $depreciationCostPerCake = $cake->depreciation;
        $totalDepreciationCost = $depreciationCostPerCake * $quantitySold;

        // Tổng chi phí
        $totalCost = $totalIngredientCost + $totalPackagingCost + $totalDepreciationCost;

        // 4. Trừ số lượng tồn kho và cập nhật giao dịch
        DB::transaction(function () use ($cake, $quantitySold, $product, $totalIngredientCost, $totalPackagingCost, $totalDepreciationCost, $totalCost, $sellingPrice) {
            // Trừ số lượng nguyên liệu
            if ($cake->recipe && $cake->recipe->ingredients) {
                foreach ($cake->recipe->ingredients as $ingredient) {
                    $requiredQuantity = $ingredient->pivot->quantity * $quantitySold;
                    $ingredient->quantity -= $requiredQuantity;
                    $ingredient->save();
                }
            }

            // Trừ số lượng bao bì
            foreach ($cake->packagings as $packaging) {
                $requiredQuantity = $quantitySold;
                $packaging->quantity -= $requiredQuantity;
                $packaging->save();
            }

            // Cập nhật giao dịch
            $product->update([
                'cake_id' => $cake->id,
                'ingredient_cost' => $totalIngredientCost,
                'packaging_cost' => $totalPackagingCost,
                'depreciation_cost' => $totalDepreciationCost,
                'quantity_sold' => $quantitySold,
                'total_cost' => $totalCost,
                'selling_price' => $sellingPrice,
            ]);
        });

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
        $product = Product::withTrashed()->with('cake.recipe.ingredients', 'cake.packagings')->findOrFail($id);
        $cake = $product->cake;
        $quantitySold = $product->quantity_sold;

        // Kiểm tra lựa chọn của người dùng
        $restoreInventory = request()->input('restore_inventory', 'no'); // Mặc định là 'no' nếu không có giá trị

        if ($restoreInventory === 'yes') {
            // Hoàn lại số lượng tồn kho
            DB::transaction(function () use ($cake, $quantitySold) {
                // Hoàn lại nguyên liệu
                if ($cake->recipe && $cake->recipe->ingredients) {
                    foreach ($cake->recipe->ingredients as $ingredient) {
                        $requiredQuantity = $ingredient->pivot->quantity * $quantitySold;
                        $ingredient->quantity += $requiredQuantity;
                        $ingredient->save();
                    }
                }

                // Hoàn lại bao bì
                foreach ($cake->packagings as $packaging) {
                    $requiredQuantity = $quantitySold; // Mỗi bánh dùng 1 bao bì
                    $packaging->quantity += $requiredQuantity;
                    $packaging->save();
                }
            });
        }

        // Xóa vĩnh viễn giao dịch
        $product->forceDelete();

        return redirect()->route('products.recycle')->with('success', 'Xóa vĩnh viễn giao dịch thành công!');
    }
}
