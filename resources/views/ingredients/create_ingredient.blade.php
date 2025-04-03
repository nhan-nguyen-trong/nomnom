@extends('layouts.adminlte')

@section('title', 'Nhập nguyên liệu')

@section('page-title', 'Nhập nguyên liệu')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Nhập nguyên liệu mới cho phân loại: {{ $category->name }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('ingredients.storeIngredient', $category->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Tên nguyên liệu</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="quantity">Số lượng</label>
                    <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}" step="0.01" required>
                    @error('quantity')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="unit">Đơn vị</label>
                    <input type="text" name="unit" id="unit" class="form-control @error('unit') is-invalid @enderror" value="{{ old('unit') }}" required>
                    @error('unit')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="price">Giá niêm yết</label>
                    <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" step="0.01" required>
                    @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="unit_price">Giá mỗi đơn vị</label>
                    <input type="number" name="unit_price" id="unit_price" class="form-control @error('unit_price') is-invalid @enderror" value="{{ old('unit_price') }}" step="0.01" required>
                    @error('unit_price')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Lưu</button>
                <a href="{{ route('ingredients.show', $category->id) }}" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
@endsection
