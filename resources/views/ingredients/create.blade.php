@extends('layouts.adminlte')

@section('title', 'Thêm nguyên liệu')

@section('page-title', 'Thêm nguyên liệu')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Thêm nguyên liệu</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('ingredients.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Tên:</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Đơn vị:</label>
                    <input type="text" name="unit" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Số lượng:</label>
                    <input type="number" name="quantity" class="form-control" step="0.01" required>
                </div>
                <div class="form-group">
                    <label>Giá:</label>
                    <input type="number" name="price" class="form-control" step="0.01" required>
                </div>
                <button type="submit" class="btn btn-primary">Thêm</button>
            </form>
        </div>
    </div>
@endsection
