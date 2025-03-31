@extends('layouts.adminlte')

@section('title', 'Quản lý bao bì')

@section('page-title', 'Quản lý bao bì')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách bao bì</h3>
            <div class="card-tools">
                <a href="{{ route('packagings.create') }}" class="btn btn-primary">Thêm bao bì</a>
                <a href="{{ route('packagings.recycle') }}" class="btn btn-warning">Thùng rác</a>
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
                @foreach (\App\Models\Packaging::all() as $packaging)
                    <tr>
                        <td>{{ $packaging->id }}</td>
                        <td>{{ $packaging->name }}</td>
                        <td>{{ $packaging->unit }}</td>
                        <td>{{ Str::formatVND($packaging->price) }}</td>
                        <td>{{ Number::formatSmart($packaging->quantity) }}</td>
                        <td>
                            <a href="{{ route('packagings.edit', $packaging->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                            <a href="{{ route('packagings.delete', $packaging->id) }}" class="btn btn-danger btn-sm">Xóa</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
