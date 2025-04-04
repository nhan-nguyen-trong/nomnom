@extends('layouts.adminlte')

@section('title', 'Sửa bao bì')

@section('page-title', 'Sửa bao bì')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Sửa bao bì</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('packagings.update', $packaging->id) }}" method="POST">
                @csrf
                @method('POST')
                <div class="form-group">
                    <label for="name">Tên bao bì</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $packaging->name) }}" required>
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="quantity">Số lượng</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" value="{{ old('quantity', $packaging->quantity) }}" required>
                    @error('quantity')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="unit">Đơn vị</label>
                    <input type="text" name="unit" id="unit" class="form-control" value="{{ old('unit', $packaging->unit) }}" required>
                    @error('unit')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="price">Giá niêm yết</label>
                    <input type="number" step="0.01" name="price" id="price" class="form-control" value="{{ old('price', $packaging->price) }}" required>
                    @error('price')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="unit_price">Đơn giá (giá 1 cái bao bì)</label>
                    <input type="number" step="0.01" name="unit_price" id="unit_price" class="form-control" value="{{ old('unit_price', $packaging->unit_price) }}" required>
                    @error('unit_price')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="{{ route('packagings.index') }}" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
@endsection
