@extends('layouts.adminlte')

@section('title', 'Sửa nguyên liệu')

@section('page-title', 'Sửa nguyên liệu')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Sửa nguyên liệu</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('ingredients.update', $ingredient->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Tên:</label>
                    <input type="text" name="name" class="form-control" value="{{ $ingredient->name }}" required>
                </div>
                <div class="form-group">
                    <label>Đơn vị:</label>
                    <input type="text" name="unit" class="form-control" value="{{ $ingredient->unit }}" required>
                </div>
                <div class="form-group">
                    <label>Giá:</label>
                    <input type="number" name="price" class="form-control" step="0.01" value="{{ $ingredient->price }}" required>
                </div>
                <div class="form-group">
                    <label>Số lượng:</label>
                    <input type="number" name="quantity" class="form-control" step="0.01" value="{{ $ingredient->quantity }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </form>
        </div>
    </div>
@endsection
