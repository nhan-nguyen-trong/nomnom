<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Packaging;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PackagingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $packagings = Packaging::latest()->paginate(10); // Phân trang, mỗi trang 10 bản ghi
        $totalPrice = Packaging::sum('price');
        return view('packagings.index', compact('packagings', 'totalPrice'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('packagings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'unit_price' => 'required|numeric|min:0',
        ]);

        Packaging::create($request->all());
        return redirect()->route('packagings.index')->with('success', 'Thêm bao bì thành công!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        $packaging = Packaging::findOrFail($id);
        return view('packagings.edit', compact('packaging'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'unit_price' => 'required|numeric|min:0',
        ]);

        $packaging = Packaging::findOrFail($id);
        $packaging->update($request->all());
        return redirect()->route('packagings.index')->with('success', 'Cập nhật bao bì thành công!');
    }

    /**
     * Remove the specified resource from storage (soft delete).
     */
    public function destroy(int $id): RedirectResponse
    {
        $packaging = Packaging::findOrFail($id);
        $packaging->delete();
        return redirect()->route('packagings.index')->with('success', 'Xóa bao bì thành công!');
    }

    /**
     * Display a listing of the trashed resources.
     */
    public function recycle(): View
    {
        $packagings = Packaging::onlyTrashed()->get();
        return view('packagings.recycle', compact('packagings'));
    }

    /**
     * Restore the specified resource from trash.
     */
    public function restore(int $id): RedirectResponse
    {
        $packaging = Packaging::withTrashed()->findOrFail($id);
        $packaging->restore();
        return redirect()->route('packagings.recycle')->with('success', 'Khôi phục bao bì thành công!');
    }

    /**
     * Permanently delete the specified resource from storage.
     */
    public function forceDelete(int $id): RedirectResponse
    {
        $packaging = Packaging::withTrashed()->findOrFail($id);
        $packaging->forceDelete();
        return redirect()->route('packagings.recycle')->with('success', 'Xóa vĩnh viễn bao bì thành công!');
    }
}
