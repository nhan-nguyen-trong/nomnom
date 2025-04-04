@extends('layouts.adminlte')

@section('title', 'Quản lý nguyên liệu')

@section('page-title', 'Quản lý nguyên liệu')

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách phân loại nguyên liệu</h3>
            <div class="card-tools">
                <a href="{{ route('ingredients.create') }}" class="btn btn-primary">Nhập loại nguyên liệu</a>
                <a href="{{ route('ingredients.recycle') }}" class="btn btn-warning">Thùng rác</a>
            </div>
        </div>
        <div class="card-body">
            <p><strong>Tổng tiền: {{ Str::formatVND($totalPrice) }}</strong></p>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Phân loại</th>
                    <th>Tổng số lượng</th>
                    <th>Hành động</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            {{ $category->ingredients->sum('quantity') }} {{ $category->ingredients->first()->unit ?? '' }}
                        </td>
                        <td>
                            <a href="{{ route('ingredients.show', $category->id) }}" class="btn btn-info btn-sm">Chi tiết</a>
                            <a href="{{ route('ingredients.edit', $category->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                            <button onclick="confirmDelete({{ $category->id }}, 'ingredients')" class="btn btn-danger btn-sm">Xóa</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <!-- Thêm phân trang -->
            <div class="mt-4">
                {{ $categories->links('pagination.custom') }}
            </div>
        </div>
    </div>
@endsection
