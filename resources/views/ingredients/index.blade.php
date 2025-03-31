@extends('layouts.adminlte')

@section('title', 'Quản lý nguyên liệu')

@section('page-title', 'Quản lý nguyên liệu')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách nguyên liệu</h3>
            <div class="card-tools">
                <a href="{{ route('ingredients.create') }}" class="btn btn-primary">Thêm nguyên liệu</a>
                <a href="{{ route('ingredients.recycle') }}" class="btn btn-warning">Thùng rác</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Đơn vị</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Hành động</th>
                </tr>
                </thead>
                <tbody>
                @foreach (\App\Models\Ingredient::all() as $ingredient)
                    <tr>
                        <td>{{ $ingredient->id }}</td>
                        <td>{{ $ingredient->name }}</td>
                        <td>{{ $ingredient->unit }}</td>
                        <td>{{ $ingredient->price }}</td>
                        <td>{{ $ingredient->quantity }}</td>
                        <td>
                            <a href="{{ route('ingredients.edit', $ingredient->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                            <a href="{{ route('ingredients.delete', $ingredient->id) }}" class="btn btn-danger btn-sm">Xóa</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
