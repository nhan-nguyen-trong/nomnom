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
    public function index(): View
    {
        $products = Product::with('cake')->get();
        return view('products.index', compact('products'));
    }

    public function create(): View
    {
        $cakes = Cake::all();
        return view('products.create', compact('cakes'));
    }

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

        // Kiểm tra số lượng nguyên liệu và bao bì
        if ($cake->recipe && $cake->recipe->ingredients) {
            foreach ($cake->recipe->ingredients as $ingredient) {
                $requiredQuantity = $ingredient->pivot->quantity * $quantitySold;
                if ($requiredQuantity > $ingredient->quantity) {
                    return redirect()->back()->with('error', "Không đủ nguyên liệu {$ingredient->name} trong kho. Cần {$requiredQuantity} {$ingredient->unit}, nhưng chỉ có {$ingredient->quantity} {$ingredient->unit}.");
                }
            }
        }

        foreach ($cake->packagings as $packaging) {
            $requiredQuantity = $quantitySold;
            if ($requiredQuantity > $packaging->quantity) {
                return redirect()->back()->with('error', "Không đủ bao bì {$packaging->name} trong kho. Cần {$requiredQuantity} {$packaging->unit}, nhưng chỉ có {$packaging->quantity} {$packaging->unit}.");
            }
        }

        // Tính chi phí nguyên liệu
        $ingredientCostPerCake = 0;
        if ($cake->recipe && $cake->recipe->ingredients) {
            $ingredientCostPerCake = $cake->recipe->ingredients->sum(function ($ingredient) {
                $unitPrice = $ingredient->unit_price;
                $requiredQuantity = $ingredient->pivot->quantity;
                return $unitPrice * $requiredQuantity;
            });
        }
        $totalIngredientCost = $ingredientCostPerCake * $quantitySold;

        // Tính chi phí bao bì (dùng unit_price thay vì price)
        $packagingCostPerCake = $cake->packagings->sum('unit_price');
        $totalPackagingCost = $packagingCostPerCake * $quantitySold;

        // Tính chi phí khấu hao
        $depreciationCostPerCake = $cake->depreciation;
        $totalDepreciationCost = $depreciationCostPerCake * $quantitySold;

        // Tổng chi phí
        $totalCost = $totalIngredientCost + $totalPackagingCost + $totalDepreciationCost;

        // Lưu giao dịch và cập nhật kho
        DB::transaction(function () use ($cake, $quantitySold, $totalIngredientCost, $totalPackagingCost, $totalDepreciationCost, $totalCost, $sellingPrice) {
            if ($cake->recipe && $cake->recipe->ingredients) {
                foreach ($cake->recipe->ingredients as $ingredient) {
                    $requiredQuantity = $ingredient->pivot->quantity * $quantitySold;
                    $ingredient->quantity -= $requiredQuantity;
                    $ingredient->save();
                }
            }

            foreach ($cake->packagings as $packaging) {
                $requiredQuantity = $quantitySold;
                $packaging->quantity -= $requiredQuantity;
                $packaging->save();
            }

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

    public function edit(int $id): View
    {
        $product = Product::findOrFail($id);
        $cakes = Cake::all();
        return view('products.edit', compact('product', 'cakes'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'cake_id' => 'required|exists:cakes,id',
            'quantity_sold' => 'required|numeric|min:1',
            'selling_price' => 'required|numeric|min:0',
        ]);

        $product = Product::findOrFail($id);
        $oldQuantitySold = $product->quantity_sold;
        $cake = Cake::with(['recipe.ingredients', 'packagings'])->findOrFail($request->cake_id);
        $quantitySold = $request->quantity_sold;
        $sellingPrice = $request->selling_price;

        // Hoàn lại số lượng nguyên liệu và bao bì của giao dịch cũ
        DB::transaction(function () use ($product, $oldQuantitySold) {
            $oldCake = Cake::with(['recipe.ingredients', 'packagings'])->findOrFail($product->cake_id);

            if ($oldCake->recipe && $oldCake->recipe->ingredients) {
                foreach ($oldCake->recipe->ingredients as $ingredient) {
                    $requiredQuantity = $ingredient->pivot->quantity * $oldQuantitySold;
                    $ingredient->quantity += $requiredQuantity;
                    $ingredient->save();
                }
            }

            foreach ($oldCake->packagings as $packaging) {
                $requiredQuantity = $oldQuantitySold;
                $packaging->quantity += $requiredQuantity;
                $packaging->save();
            }
        });

        // Kiểm tra số lượng nguyên liệu và bao bì cho giao dịch mới
        if ($cake->recipe && $cake->recipe->ingredients) {
            foreach ($cake->recipe->ingredients as $ingredient) {
                $requiredQuantity = $ingredient->pivot->quantity * $quantitySold;
                if ($requiredQuantity > $ingredient->quantity) {
                    return redirect()->back()->with('error', "Không đủ nguyên liệu {$ingredient->name} trong kho. Cần {$requiredQuantity} {$ingredient->unit}, nhưng chỉ có {$ingredient->quantity} {$ingredient->unit}.");
                }
            }
        }

        foreach ($cake->packagings as $packaging) {
            $requiredQuantity = $quantitySold;
            if ($requiredQuantity > $packaging->quantity) {
                return redirect()->back()->with('error', "Không đủ bao bì {$packaging->name} trong kho. Cần {$requiredQuantity} {$packaging->unit}, nhưng chỉ có {$packaging->quantity} {$packaging->unit}.");
            }
        }

        // Tính chi phí nguyên liệu
        $ingredientCostPerCake = 0;
        if ($cake->recipe && $cake->recipe->ingredients) {
            $ingredientCostPerCake = $cake->recipe->ingredients->sum(function ($ingredient) {
                $unitPrice = $ingredient->unit_price;
                $requiredQuantity = $ingredient->pivot->quantity;
                return $unitPrice * $requiredQuantity;
            });
        }
        $totalIngredientCost = $ingredientCostPerCake * $quantitySold;

        // Tính chi phí bao bì (dùng unit_price thay vì price)
        $packagingCostPerCake = $cake->packagings->sum('unit_price');
        $totalPackagingCost = $packagingCostPerCake * $quantitySold;

        // Tính chi phí khấu hao
        $depreciationCostPerCake = $cake->depreciation;
        $totalDepreciationCost = $depreciationCostPerCake * $quantitySold;

        // Tổng chi phí
        $totalCost = $totalIngredientCost + $totalPackagingCost + $totalDepreciationCost;

        // Cập nhật giao dịch và kho
        DB::transaction(function () use ($cake, $quantitySold, $product, $totalIngredientCost, $totalPackagingCost, $totalDepreciationCost, $totalCost, $sellingPrice) {
            if ($cake->recipe && $cake->recipe->ingredients) {
                foreach ($cake->recipe->ingredients as $ingredient) {
                    $requiredQuantity = $ingredient->pivot->quantity * $quantitySold;
                    $ingredient->quantity -= $requiredQuantity;
                    $ingredient->save();
                }
            }

            foreach ($cake->packagings as $packaging) {
                $requiredQuantity = $quantitySold;
                $packaging->quantity -= $requiredQuantity;
                $packaging->save();
            }

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

    public function destroy(int $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Xóa giao dịch thành công!');
    }

    public function recycle(): View
    {
        $products = Product::onlyTrashed()->get();
        return view('products.recycle', compact('products'));
    }

    public function restore(int $id): RedirectResponse
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();
        return redirect()->route('products.recycle')->with('success', 'Khôi phục giao dịch thành công!');
    }

    public function forceDelete(int $id): RedirectResponse
    {
        $product = Product::withTrashed()->with('cake.recipe.ingredients', 'cake.packagings')->findOrFail($id);
        $cake = $product->cake;
        $quantitySold = $product->quantity_sold;

        $restoreInventory = request()->input('restore_inventory', 'no');

        if ($restoreInventory === 'yes') {
            DB::transaction(function () use ($cake, $quantitySold) {
                if ($cake->recipe && $cake->recipe->ingredients) {
                    foreach ($cake->recipe->ingredients as $ingredient) {
                        $requiredQuantity = $ingredient->pivot->quantity * $quantitySold;
                        $ingredient->quantity += $requiredQuantity;
                        $ingredient->save();
                    }
                }

                foreach ($cake->packagings as $packaging) {
                    $requiredQuantity = $quantitySold;
                    $packaging->quantity += $requiredQuantity;
                    $packaging->save();
                }
            });
        }

        $product->forceDelete();

        return redirect()->route('products.recycle')->with('success', 'Xóa vĩnh viễn giao dịch thành công!');
    }
}
