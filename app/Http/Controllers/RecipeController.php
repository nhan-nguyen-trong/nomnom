<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
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
        return view('recipes.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('recipes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
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
        return view('recipes.edit', compact('recipe'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
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
     * Show the form for deleting the specified resource.
     */
    public function delete(int $id): View
    {
        $recipe = Recipe::findOrFail($id);
        return view('recipes.delete', compact('recipe'));
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
