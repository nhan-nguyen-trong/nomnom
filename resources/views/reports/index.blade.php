@extends('layouts.adminlte')

@section('title', 'Quản lý báo cáo doanh thu')

@section('page-title', 'Quản lý báo cáo doanh thu')

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách báo cáo doanh thu</h3>
            <div class="card-tools">
                <a href="{{ route('reports.create') }}" class="btn btn-primary">Thêm báo cáo</a>
                <a href="{{ route('reports.recycle') }}" class="btn btn-warning">Thùng rác</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên bánh</th>
                    <th>Số lượng bán</th>
                    <th>Chi phí nguyên liệu</th>
                    <th>Chi phí bao bì</th>
                    <th>Khấu hao</th>
                    <th>Tổng chi phí</th>
                    <th>Giá bán</th>
                    <th>Lợi nhuận</th>
                    <th>Hành động</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->cake->name }}</td>
                        <td>{{ $product->quantity_sold }}</td>
                        <td>{{ Str::formatVND($product->ingredient_cost) }}</td>
                        <td>{{ Str::formatVND($product->packaging_cost) }}</td>
                        <td>{{ Str::formatVND($product->depreciation_cost) }}</td>
                        <td>{{ Str::formatVND($product->total_cost) }}</td>
                        <td>{{ Str::formatVND($product->selling_price) }}</td>
                        <td>{{ Str::formatVND($product->selling_price - $product->total_cost) }}</td>
                        <td>
                            <a href="{{ route('reports.edit', $product->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                            <a href="{{ route('reports.delete', $product->id) }}" class="btn btn-danger btn-sm">Xóa</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
