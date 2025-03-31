@extends('layouts.adminlte')

@section('title', 'Thêm giao dịch bán bánh')

@section('page-title', 'Thêm giao dịch bán bánh')

@section('content')
    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Thêm giao dịch bán bánh</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('products.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Loại bánh:</label>
                    <select name="cake_id" class="form-control" required>
                        <option value="">Chọn bánh</option>
                        @foreach ($cakes as $cake)
                            <option value="{{ $cake->id }}" {{ old('cake_id') == $cake->id ? 'selected' : '' }}>
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
                    <input type="number" name="quantity_sold" class="form-control" value="{{ old('quantity_sold') }}" required>
                    @error('quantity_sold')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Giá bán:</label>
                    <input type="number" name="selling_price" class="form-control" step="0.01" value="{{ old('selling_price') }}" required>
                    @error('selling_price')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Thêm</button>
            </form>
        </div>
    </div>
@endsection
