<?php

namespace App\Http\Controllers;

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
        return view('packagings.index');
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
        $packaging = Packaging::findOrFail($id);
        $packaging->update($request->all());
        return redirect()->route('packagings.index')->with('success', 'Cập nhật bao bì thành công!');
    }

    /**
     * Show the form for deleting the specified resource.
     */
    public function delete(int $id): View
    {
        $packaging = Packaging::findOrFail($id);
        return view('packagings.delete', compact('packaging'));
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
        return view('packagings.recycle');
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
