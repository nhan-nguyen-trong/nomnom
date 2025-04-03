@extends('layouts.adminlte')

@section('title', 'Nhập loại nguyên liệu')

@section('page-title', 'Nhập loại nguyên liệu')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Nhập loại nguyên liệu mới</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('ingredients.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Tên loại nguyên liệu</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Lưu</button>
                <a href="{{ route('ingredients.index') }}" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
@endsection
