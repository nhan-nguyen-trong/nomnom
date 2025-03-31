<div>
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="produce">
        <div>
            <label>Tên bánh:</label>
            <input type="text" wire:model="name" class="form-control">
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Công thức:</label>
            <select wire:model="recipe_id" class="form-control">
                <option value="">Chọn công thức</option>
                @if (isset($recipes) && $recipes->isNotEmpty())
                    @foreach ($recipes as $recipe)
                        <option value="{{ $recipe->id }}">{{ $recipe->name }}</option>
                    @endforeach
                @else
                    <option value="">Không có công thức nào</option>
                @endif
            </select>
            @error('recipe_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Số lượng:</label>
            <input type="number" wire:model="quantity" class="form-control">
            @error('quantity') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Bao bì:</label>
            <select wire:model="packaging_id" class="form-control">
                <option value="">Chọn bao bì</option>
                @if (isset($packagings) && $packagings->isNotEmpty())
                    @foreach ($packagings as $packaging)
                        <option value="{{ $packaging->id }}">{{ $packaging->name }}</option>
                    @endforeach
                @else
                    <option value="">Không có bao bì nào</option>
                @endif
            </select>
            @error('packaging_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Khấu hao:</label>
            <input type="number" wire:model="depreciation" class="form-control" step="0.01">
        </div>

        <button type="submit" class="btn btn-primary">Sản xuất</button>
    </form>
</div>
