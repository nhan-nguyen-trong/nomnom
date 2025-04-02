<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $ingredients = Ingredient::latest()->paginate(10);
        return view('ingredients.index', compact('ingredients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('ingredients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Ingredient::create($request->all());
        return redirect()->route('ingredients.index')->with('success', 'Thêm nguyên liệu thành công!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        $ingredient = Ingredient::findOrFail($id);
        return view('ingredients.edit', compact('ingredient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $ingredient = Ingredient::findOrFail($id);
        $ingredient->update($request->all());
        return redirect()->route('ingredients.index')->with('success', 'Cập nhật nguyên liệu thành công!');
    }

    /**
     * Show the form for deleting the specified resource.
     */
    public function delete(int $id): View
    {
        $ingredient = Ingredient::findOrFail($id);
        return view('ingredients.delete', compact('ingredient'));
    }

    /**
     * Remove the specified resource from storage (soft delete).
     */
    public function destroy(int $id): RedirectResponse
    {
        $ingredient = Ingredient::findOrFail($id);
        $ingredient->delete();
        return redirect()->route('ingredients.index')->with('success', 'Xóa nguyên liệu thành công!');
    }

    /**
     * Display a listing of the trashed resources.
     */
    public function recycle(): View
    {
        return view('ingredients.recycle');
    }

    /**
     * Restore the specified resource from trash.
     */
    public function restore(int $id): RedirectResponse
    {
        $ingredient = Ingredient::withTrashed()->findOrFail($id);
        $ingredient->restore();
        return redirect()->route('ingredients.recycle')->with('success', 'Khôi phục nguyên liệu thành công!');
    }

    /**
     * Permanently delete the specified resource from storage.
     */
    public function forceDelete(int $id): RedirectResponse
    {
        $ingredient = Ingredient::withTrashed()->findOrFail($id);
        $ingredient->forceDelete();
        return redirect()->route('ingredients.recycle')->with('success', 'Xóa vĩnh viễn nguyên liệu thành công!');
    }
}
