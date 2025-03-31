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
                <div class="form-group">
                    <label>Tên:</label>
                    <input type="text" name="name" class="form-control" value="{{ $packaging->name }}" required>
                </div>
                <div class="form-group">
                    <label>Đơn vị:</label>
                    <input type="text" name="unit" class="form-control" value="{{ $packaging->unit }}" required>
                </div>
                <div class="form-group">
                    <label>Giá:</label>
                    <input type="number" name="price" class="form-control" step="0.01" value="{{ $packaging->price }}" required>
                </div>
                <div class="form-group">
                    <label>Số lượng:</label>
                    <input type="number" name="quantity" class="form-control" step="0.01" value="{{ $packaging->quantity }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </form>
        </div>
    </div>
@endsection
