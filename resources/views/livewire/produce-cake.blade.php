<div>
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Sản xuất bánh</h3>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="produce">
                <div class="form-group">
                    <label>Tên bánh:</label>
                    <input type="text" wire:model="name" class="form-control">
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Công thức:</label>
                    <select wire:model="recipe_id" class="form-control">
                        <option value="">Chọn công thức</option>
                        @foreach ($recipes as $recipe)
                            <option value="{{ $recipe->id }}">{{ $recipe->name }}</option>
                        @endforeach
                    </select>
                    @error('recipe_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Số lượng:</label>
                    <input type="number" wire:model="quantity" class="form-control">
                    @error('quantity') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Bao bì:</label>
                    <select wire:model="packaging_id" class="form-control">
                        <option value="">Chọn bao bì</option>
                        @foreach ($packagings as $packaging)
                            <option value="{{ $packaging->id }}">{{ $packaging->name }}</option>
                        @endforeach
                    </select>
                    @error('packaging_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Khấu hao:</label>
                    <input type="number" wire:model="depreciation" class="form-control" step="0.01">
                </div>

                <button type="submit" class="btn btn-primary">Sản xuất</button>
            </form>
        </div>
    </div>
</div>
