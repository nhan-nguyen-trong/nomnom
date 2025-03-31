@extends('layouts.adminlte')

@section('title', 'Báo cáo doanh thu')

@section('page-title', 'Báo cáo doanh thu')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách giao dịch</h3>
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
                </tr>
                </thead>
                <tbody>
                @foreach (\App\Models\Product::all() as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->cake->name }}</td>
                        <td>{{ $product->quantity_sold }}</td>
                        <td>{{ $product->ingredient_cost }}</td>
                        <td>{{ $product->packaging_cost }}</td>
                        <td>{{ $product->depreciation_cost }}</td>
                        <td>{{ $product->total_cost }}</td>
                        <td>{{ $product->selling_price }}</td>
                        <td>{{ $product->selling_price - $product->total_cost }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
