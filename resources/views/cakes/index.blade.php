@extends('layouts.adminlte')

@section('title', 'Quản lý bánh')

@section('page-title', 'Quản lý bánh')

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách bánh</h3>
            <div class="card-tools">
                <a href="{{ route('cakes.create') }}" class="btn btn-primary">Thêm bánh</a>
                <a href="{{ route('cakes.recycle') }}" class="btn btn-warning">Thùng rác</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên bánh</th>
                    <th>Công thức</th>
                    <th>Số lượng</th>
                    <th>Bao bì</th>
                    <th>Khấu hao</th>
                    <th>Hành động</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($cakes as $cake)
                    <tr>
                        <td>{{ $cake->id }}</td>
                        <td>{{ $cake->name }}</td>
                        <td>{{ $cake->recipes->first()->name ?? 'N/A' }}</td>
                        <td>{{ $cake->recipes->first()->pivot->quantity ?? 'N/A' }}</td>
                        <td>{{ $cake->packagings->first()->name ?? 'N/A' }}</td>
                        <td>{{ Str::formatVND($cake->packagings->first()->pivot->depreciation) }}</td>
                        <td>
                            <a href="{{ route('cakes.edit', $cake->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                            <a href="{{ route('cakes.delete', $cake->id) }}" class="btn btn-danger btn-sm">Xóa</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
