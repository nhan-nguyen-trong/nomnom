<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $recipes = Recipe::latest()->paginate(10); // Phân trang, mỗi trang 10 bản ghi
        return view('recipes.index', compact('recipes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $ingredients = Ingredient::all(); // Lấy tất cả nguyên liệu
        return view('recipes.create', compact('ingredients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'ingredients' => 'required|array',
            'ingredients.*.id' => 'required|exists:ingredients,id',
            'ingredients.*.quantity' => 'required|numeric|min:0',
        ]);

        // Kiểm tra số lượng tồn kho của nguyên liệu
        foreach ($request->ingredients as $ingredientId => $data) {
            if (isset($data['id'])) {
                $ingredient = Ingredient::findOrFail($ingredientId);
                $requiredQuantity = $data['quantity'];
                if ($requiredQuantity > $ingredient->quantity) {
                    return redirect()->back()->with('error', "Không đủ nguyên liệu {$ingredient->name} trong kho. Cần {$requiredQuantity} {$ingredient->unit}, nhưng chỉ có {$ingredient->quantity} {$ingredient->unit}.");
                }
            }
        }

        // Nếu kiểm tra thành công, tạo công thức
        $recipe = Recipe::create(['name' => $request->name]);
        foreach ($request->ingredients as $ingredientId => $data) {
            if (isset($data['id'])) {
                $recipe->ingredients()->attach($ingredientId, ['quantity' => $data['quantity']]);
            }
        }

        return redirect()->route('recipes.index')->with('success', 'Thêm công thức thành công!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        $recipe = Recipe::findOrFail($id);
        $ingredients = Ingredient::all(); // Lấy tất cả nguyên liệu
        return view('recipes.edit', compact('recipe', 'ingredients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'ingredients' => 'required|array',
            'ingredients.*.id' => 'required|exists:ingredients,id',
            'ingredients.*.quantity' => 'required|numeric|min:0',
        ]);

        // Kiểm tra số lượng tồn kho của nguyên liệu
        foreach ($request->ingredients as $ingredientId => $data) {
            if (isset($data['id'])) {
                $ingredient = Ingredient::findOrFail($ingredientId);
                $requiredQuantity = $data['quantity'];
                if ($requiredQuantity > $ingredient->quantity) {
                    return redirect()->back()->with('error', "Không đủ nguyên liệu {$ingredient->name} trong kho. Cần {$requiredQuantity} {$ingredient->unit}, nhưng chỉ có {$ingredient->quantity} {$ingredient->unit}.");
                }
            }
        }

        // Nếu kiểm tra thành công, cập nhật công thức
        $recipe = Recipe::findOrFail($id);
        $recipe->update(['name' => $request->name]);
        $recipe->ingredients()->sync([]);
        foreach ($request->ingredients as $ingredientId => $data) {
            if (isset($data['id'])) {
                $recipe->ingredients()->attach($ingredientId, ['quantity' => $data['quantity']]);
            }
        }

        return redirect()->route('recipes.index')->with('success', 'Cập nhật công thức thành công!');
    }

    /**
     * Remove the specified resource from storage (soft delete).
     */
    public function destroy(int $id): RedirectResponse
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->delete();
        return redirect()->route('recipes.index')->with('success', 'Xóa công thức thành công!');
    }

    /**
     * Display a listing of the trashed resources.
     */
    public function recycle(): View
    {
        return view('recipes.recycle');
    }

    /**
     * Restore the specified resource from trash.
     */
    public function restore(int $id): RedirectResponse
    {
        $recipe = Recipe::withTrashed()->findOrFail($id);
        $recipe->restore();
        return redirect()->route('recipes.recycle')->with('success', 'Khôi phục công thức thành công!');
    }

    /**
     * Permanently delete the specified resource from storage.
     */
    public function forceDelete(int $id): RedirectResponse
    {
        $recipe = Recipe::withTrashed()->findOrFail($id);
        $recipe->forceDelete();
        return redirect()->route('recipes.recycle')->with('success', 'Xóa vĩnh viễn công thức thành công!');
    }
}
