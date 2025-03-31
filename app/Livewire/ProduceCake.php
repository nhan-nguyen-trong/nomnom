<?php

namespace App\Http\Livewire;

use App\Models\Packaging;
use App\Models\Recipe;
use Livewire\Component;

class ProduceCake extends Component
{
    public $name;
    public $recipe_id;
    public $quantity;
    public $packaging_id;
    public $depreciation;

    public function produce()
    {
        $this->validate([
            'name' => 'required',
            'recipe_id' => 'required|exists:recipes,id',
            'quantity' => 'required|numeric|min:1',
            'packaging_id' => 'required|exists:packagings,id',
        ]);

        $controller = new \App\Http\Controllers\CakeController();
        $controller->produce(new \Illuminate\Http\Request([
            'name' => $this->name,
            'recipe_id' => $this->recipe_id,
            'quantity' => $this->quantity,
            'packaging_id' => $this->packaging_id,
            'depreciation' => $this->depreciation,
        ]));

        $this->reset();
        session()->flash('success', 'Sản xuất bánh thành công!');
    }

    public function render()
    {
        return view('livewire.produce-cake', [
            'recipes' => Recipe::all(), // Đảm bảo biến này luôn được truyền
            'packagings' => Packaging::all(), // Đảm bảo biến này luôn được truyền
        ]);
    }
}
