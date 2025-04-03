@extends('layouts.adminlte')

@section('title', 'Sửa phân loại nguyên liệu')

@section('page-title', 'Sửa phân loại nguyên liệu')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Sửa phân loại: {{ $category->name }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('ingredients.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Tên phân loại</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $category->name) }}" required>
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="{{ route('ingredients.index') }}" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
@endsection
