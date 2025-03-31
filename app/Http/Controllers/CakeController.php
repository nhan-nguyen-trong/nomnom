<?php

namespace App\Http\Controllers;

use App\Models\Cake;
use App\Models\Ingredient;
use App\Models\Packaging;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CakeController extends Controller
{
    /**
     * Display a listing of the cakes.
     */
    public function index(): View
    {
        $cakes = Cake::all();
        return view('cakes.index', compact('cakes'));
    }

    /**
     * Show the form for creating a new cake.
     */
    public function create(): View
    {
        $recipes = Recipe::all();
        $packagings = Packaging::all();
        return view('cakes.create', compact('recipes', 'packagings'));
    }

    /**
     * Store a newly created cake in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'recipe_id' => 'required|exists:recipes,id',
            'packagings' => 'required|array',
            'packagings.*.id' => 'required|exists:packagings,id',
            'packagings.*.quantity' => 'required|numeric|min:0',
            'packagings.*.depreciation' => 'required|numeric|min:0',
        ]);

        // Kiểm tra số lượng tồn kho của bao bì
        foreach ($request->packagings as $packagingId => $data) {
            if (isset($data['id'])) {
                $packaging = Packaging::findOrFail($packagingId);
                $requiredQuantity = $data['quantity'];
                if ($requiredQuantity > $packaging->quantity) {
                    return redirect()->back()->with('error', "Không đủ bao bì {$packaging->name} trong kho. Cần {$requiredQuantity} {$packaging->unit}, nhưng chỉ có {$packaging->quantity} {$packaging->unit}.");
                }
            }
        }

        // Tạo bánh
        $cake = Cake::create([
            'name' => $request->name,
            'recipe_id' => $request->recipe_id,
        ]);

        // Gắn bao bì cho bánh
        foreach ($request->packagings as $packagingId => $data) {
            if (isset($data['id'])) {
                $cake->packagings()->attach($packagingId, [
                    'quantity' => $data['quantity'],
                    'depreciation' => $data['depreciation'],
                ]);
            }
        }

        return redirect()->route('cakes.index')->with('success', 'Thêm bánh thành công!');
    }

    /**
     * Show the form for editing the specified cake.
     */
    public function edit(int $id): View
    {
        $cake = Cake::findOrFail($id);
        $recipes = Recipe::all();
        $packagings = Packaging::all();
        $recipe = $cake->recipes()->first();
        $packaging = $cake->packagings()->first();
        return view('cakes.edit', compact('cake', 'recipes', 'packagings', 'recipe', 'packaging'));
    }

    /**
     * Update the specified cake in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'recipe_id' => 'required|exists:recipes,id',
            'packagings' => 'required|array',
            'packagings.*.id' => 'required|exists:packagings,id',
            'packagings.*.quantity' => 'required|numeric|min:0',
            'packagings.*.depreciation' => 'required|numeric|min:0',
        ]);

        // Kiểm tra số lượng tồn kho của bao bì
        foreach ($request->packagings as $packagingId => $data) {
            if (isset($data['id'])) {
                $packaging = Packaging::findOrFail($packagingId);
                $requiredQuantity = $data['quantity'];
                if ($requiredQuantity > $packaging->quantity) {
                    return redirect()->back()->with('error', "Không đủ bao bì {$packaging->name} trong kho. Cần {$requiredQuantity} {$packaging->unit}, nhưng chỉ có {$packaging->quantity} {$packaging->unit}.");
                }
            }
        }

        // Cập nhật bánh
        $cake = Cake::findOrFail($id);
        $cake->update([
            'name' => $request->name,
            'recipe_id' => $request->recipe_id,
        ]);

        // Cập nhật bao bì
        $cake->packagings()->sync([]);
        foreach ($request->packagings as $packagingId => $data) {
            if (isset($data['id'])) {
                $cake->packagings()->attach($packagingId, [
                    'quantity' => $data['quantity'],
                    'depreciation' => $data['depreciation'],
                ]);
            }
        }

        return redirect()->route('cakes.index')->with('success', 'Cập nhật bánh thành công!');
    }

    /**
     * Show the form for deleting the specified cake.
     */
    public function delete(int $id): View
    {
        $cake = Cake::findOrFail($id);
        return view('cakes.delete', compact('cake'));
    }

    /**
     * Remove the specified cake from storage (soft delete).
     */
    public function destroy(int $id): RedirectResponse
    {
        $cake = Cake::findOrFail($id);
        $cake->delete();
        return redirect()->route('cakes.index')->with('success', 'Xóa bánh thành công!');
    }

    /**
     * Display a listing of the trashed cakes.
     */
    public function recycle(): View
    {
        $cakes = Cake::onlyTrashed()->get();
        return view('cakes.recycle', compact('cakes'));
    }

    /**
     * Restore the specified cake from trash.
     */
    public function restore(int $id): RedirectResponse
    {
        $cake = Cake::withTrashed()->findOrFail($id);
        $cake->restore();
        return redirect()->route('cakes.recycle')->with('success', 'Khôi phục bánh thành công!');
    }

    /**
     * Permanently delete the specified cake from storage.
     */
    public function forceDelete(int $id): RedirectResponse
    {
        $cake = Cake::withTrashed()->findOrFail($id);
        $cake->forceDelete();
        return redirect()->route('cakes.recycle')->with('success', 'Xóa vĩnh viễn bánh thành công!');
    }
}
