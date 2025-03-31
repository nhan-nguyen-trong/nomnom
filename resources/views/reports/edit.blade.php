@extends('layouts.adminlte')

@section('title', 'Sửa báo cáo doanh thu')

@section('page-title', 'Sửa báo cáo doanh thu')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Sửa báo cáo doanh thu</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('reports.update', $product->id) }}" method="POST">
                @csrf
                @method('POST')
                <div class="form-group">
                    <label>Loại bánh:</label>
                    <select name="cake_id" class="form-control" required>
                        <option value="">Chọn bánh</option>
                        @foreach ($cakes as $cake)
                            <option value="{{ $cake->id }}" {{ $product->cake_id == $cake->id ? 'selected' : '' }}>
                                {{ $cake->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('cake_id')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Số lượng bán:</label>
                    <input type="number" name="quantity_sold" class="form-control" value="{{ $product->quantity_sold }}" required>
                    @error('quantity_sold')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Giá bán:</label>
                    <input type="number" name="selling_price" class="form-control" step="0.01" value="{{ $product->selling_price }}" required>
                    @error('selling_price')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </form>
        </div>
    </div>
@endsection
