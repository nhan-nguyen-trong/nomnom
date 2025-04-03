<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\IngredientCategory;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class IngredientController extends Controller
{
    /**
     * Display a listing of the ingredient categories.
     */
    public function index(): View
    {
        $categories = IngredientCategory::with('ingredients')->paginate(10);
        $totalPrice = Ingredient::sum('price');
        return view('ingredients.index', compact('categories', 'totalPrice'));
    }

    /**
     * Show the form for creating a new ingredient category.
     */
    public function create(): View
    {
        return view('ingredients.create');
    }

    /**
     * Store a newly created ingredient category in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:ingredient_categories,name',
        ]);

        IngredientCategory::create([
            'name' => $request->name,
        ]);

        return redirect()->route('ingredients.index')->with('success', 'Thêm loại nguyên liệu thành công!');
    }

    /**
     * Display the details of a specific ingredient category.
     */
    public function show($id): View
    {
        $category = IngredientCategory::with('ingredients')->findOrFail($id);
        return view('ingredients.show', compact('category'));
    }

    /**
     * Show the form for editing the specified ingredient category.
     */
    public function edit($id): View
    {
        $category = IngredientCategory::findOrFail($id);
        return view('ingredients.edit', compact('category'));
    }

    /**
     * Update the specified ingredient category in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:ingredient_categories,name,' . $id,
        ]);

        $category = IngredientCategory::findOrFail($id);
        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('ingredients.index')->with('success', 'Cập nhật loại nguyên liệu thành công!');
    }

    /**
     * Remove the specified ingredient category from storage (soft delete).
     */
    public function destroy($id): RedirectResponse
    {
        $category = IngredientCategory::findOrFail($id);
        $category->delete();
        return redirect()->route('ingredients.index')->with('success', 'Xóa loại nguyên liệu thành công!');
    }

    /**
     * Display a listing of the trashed ingredient categories.
     */
    public function recycle(): View
    {
        $categories = IngredientCategory::onlyTrashed()->get();
        return view('ingredients.recycle', compact('categories'));
    }

    /**
     * Restore the specified ingredient category from trash.
     */
    public function restore($id): RedirectResponse
    {
        $category = IngredientCategory::withTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('ingredients.recycle')->with('success', 'Khôi phục loại nguyên liệu thành công!');
    }

    /**
     * Permanently delete the specified ingredient category from storage.
     */
    public function forceDelete($id): RedirectResponse
    {
        $category = IngredientCategory::withTrashed()->findOrFail($id);
        $category->forceDelete();
        return redirect()->route('ingredients.recycle')->with('success', 'Xóa vĩnh viễn loại nguyên liệu thành công!');
    }

    /**
     * Show the form for creating a new ingredient (within a category).
     */
    public function createIngredient($categoryId): View
    {
        $category = IngredientCategory::findOrFail($categoryId);
        return view('ingredients.create_ingredient', compact('category'));
    }

    /**
     * Store a newly created ingredient in storage.
     */
    public function storeIngredient(Request $request, $categoryId): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'unit_price' => 'required|numeric|min:0',
        ]);

        Ingredient::create([
            'category_id' => $categoryId,
            'name' => $request->name,
            'quantity' => $request->quantity,
            'unit' => $request->unit,
            'price' => $request->price,
            'unit_price' => $request->unit_price,
        ]);

        return redirect()->route('ingredients.show', $categoryId)->with('success', 'Thêm nguyên liệu thành công!');
    }

    /**
     * Show the form for editing the specified ingredient.
     */
    public function editIngredient($id): View
    {
        $ingredient = Ingredient::findOrFail($id);
        $category = $ingredient->category;
        return view('ingredients.edit_ingredient', compact('ingredient', 'category'));
    }

    /**
     * Update the specified ingredient in storage.
     */
    public function updateIngredient(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'unit_price' => 'required|numeric|min:0',
        ]);

        $ingredient = Ingredient::findOrFail($id);
        $categoryId = $ingredient->category_id;
        $ingredient->update([
            'name' => $request->name,
            'quantity' => $request->quantity,
            'unit' => $request->unit,
            'price' => $request->price,
            'unit_price' => $request->unit_price,
        ]);

        return redirect()->route('ingredients.show', $categoryId)->with('success', 'Cập nhật nguyên liệu thành công!');
    }

    /**
     * Remove the specified ingredient from storage (soft delete).
     */
    public function destroyIngredient($id): RedirectResponse
    {
        $ingredient = Ingredient::findOrFail($id);
        $categoryId = $ingredient->category_id;
        $ingredient->delete();
        return redirect()->route('ingredients.show', $categoryId)->with('success', 'Xóa nguyên liệu thành công!');
    }

    /**
     * Display a listing of the trashed ingredients in a category.
     */
    public function recycleIngredient($categoryId): View
    {
        $category = IngredientCategory::findOrFail($categoryId);
        $ingredients = Ingredient::onlyTrashed()->where('category_id', $categoryId)->get();
        return view('ingredients.recycle_ingredient', compact('category', 'ingredients'));
    }

    /**
     * Restore the specified ingredient from trash.
     */
    public function restoreIngredient($id): RedirectResponse
    {
        $ingredient = Ingredient::withTrashed()->findOrFail($id);
        $categoryId = $ingredient->category_id;
        $ingredient->restore();
        return redirect()->route('ingredients.recycleIngredient', $categoryId)->with('success', 'Khôi phục nguyên liệu thành công!');
    }

    /**
     * Permanently delete the specified ingredient from storage.
     */
    public function forceDeleteIngredient($id): RedirectResponse
    {
        $ingredient = Ingredient::withTrashed()->findOrFail($id);
        $categoryId = $ingredient->category_id;
        $ingredient->forceDelete();
        return redirect()->route('ingredients.recycleIngredient', $categoryId)->with('success', 'Xóa vĩnh viễn nguyên liệu thành công!');
    }
}
