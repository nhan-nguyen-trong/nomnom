<?php

namespace App\Http\Livewire;

use App\Http\Controllers\ProductController;
use App\Models\Cake;
use Illuminate\Http\Request;
use Livewire\Component;

/**
 * @used
 */
class SellCake extends Component
{
    public int $cake_id;
    public int $quantity_sold;
    public float $selling_price;

    /**
     * @used
     */
    public function sell(): void
    {
        $this->validate([
            'cake_id' => 'required|exists:cakes,id',
            'quantity_sold' => 'required|numeric|min:1',
            'selling_price' => 'required|numeric|min:0',
        ]);

        $controller = new ProductController();
        $controller->sell(new Request([
            'cake_id' => $this->cake_id,
            'quantity_sold' => $this->quantity_sold,
            "selling_price" => $this->selling_price,
        ]));

        $this->reset();
        session()->flash('success', 'Bán bánh thành công!');
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.sell-cake', [
            'cakes' => Cake::all(),
        ]);
    }
}
