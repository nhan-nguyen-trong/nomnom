@extends('layouts.adminlte')

@section('title', 'Thùng rác giao dịch bán bánh')

@section('page-title', 'Thùng rác giao dịch bán bánh')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Thùng rác giao dịch bán bánh</h3>
            <div class="card-tools">
                <a href="{{ route('products.index') }}" class="btn btn-primary">Quay lại</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên bánh</th>
                    <th>Số lượng bán</th>
                    <th>Giá bán</th>
                    <th>Ngày xóa</th>
                    <th>Hành động</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->cake->name }}</td>
                        <td>{{ $product->quantity_sold }}</td>
                        <td>{{ number_format($product->selling_price, 2) }} VND</td>
                        <td>{{ $product->deleted_at }}</td>
                        <td>
                            <a href="{{ route('products.restore', $product->id) }}" class="btn btn-success btn-sm">Khôi phục</a>
                            <a href="{{ route('products.forceDelete', $product->id) }}" class="btn btn-danger btn-sm">Xóa vĩnh viễn</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
