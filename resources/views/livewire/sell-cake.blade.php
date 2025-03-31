<div>
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Bán bánh</h3>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="sell">
                <div class="form-group">
                    <label>Loại bánh:</label>
                    <select wire:model="cake_id" class="form-control">
                        <option value="">Chọn bánh</option>
                        @foreach ($cakes as $cake)
                            <option value="{{ $cake->id }}">{{ $cake->name }}</option>
                        @endforeach
                    </select>
                    @error('cake_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Số lượng bán:</label>
                    <input type="number" wire:model="quantity_sold" class="form-control">
                    @error('quantity_sold') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Giá bán:</label>
                    <input type="number" wire:model="selling_price" class="form-control" step="0.01">
                    @error('selling_price') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="btn btn-primary">Bán</button>
            </form>
        </div>
    </div>
</div>
