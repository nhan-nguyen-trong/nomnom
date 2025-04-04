@extends('layouts.adminlte')

@section('title', 'Chi tiết phân loại nguyên liệu')

@section('page-title', 'Chi tiết phân loại nguyên liệu')

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Chi tiết phân loại: {{ $category->name }}</h3>
            <div class="card-tools">
                <a href="{{ route('ingredients.createIngredient', $category->id) }}" class="btn btn-primary">Nhập nguyên liệu</a>
                <a href="{{ route('ingredients.recycleIngredient', $category->id) }}" class="btn btn-warning">Thùng rác</a>
                <a href="{{ route('ingredients.index') }}" class="btn btn-secondary">Quay lại</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên nguyên liệu</th>
                    <th>Số lượng</th>
                    <th>Giá niêm yết</th>
                    <th>Giá mỗi đơn vị</th>
                    <th>Hành động</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($category->ingredients as $ingredient)
                    <tr>
                        <td>{{ $ingredient->id }}</td>
                        <td>{{ $ingredient->name }}</td>
                        <td>{{ $ingredient->quantity }} {{ $ingredient->unit }}</td>
                        <td>{{ Str::formatVND($ingredient->price) }}</td>
                        <td>{{ Str::formatVND($ingredient->unit_price) }} / {{ $ingredient->unit }}</td>
                        <td>
                            <a href="{{ route('ingredients.editIngredient', $ingredient->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                            <button onclick="confirmDelete({{ $ingredient->id }}, 'ingredients/destroyIngredient')" class="btn btn-danger btn-sm">Xóa</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
