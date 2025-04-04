@extends('layouts.adminlte')

@section('title', 'Quản lý bao bì')

@section('page-title', 'Quản lý bao bì')

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách bao bì</h3>
            <div class="card-tools">
                <a href="{{ route('packagings.create') }}" class="btn btn-primary">Thêm bao bì</a>
                <a href="{{ route('packagings.recycle') }}" class="btn btn-warning">Thùng rác</a>
            </div>
        </div>
        <div class="card-body">
            @if ($packagings->isEmpty())
                <p>Không có bao bì nào.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên bao bì</th>
                        <th>Số lượng</th>
                        <th>Đơn vị</th>
                        <th>Giá niêm yết</th>
                        <th>Đơn giá</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($packagings as $packaging)
                        <tr>
                            <td>{{ $packaging->id }}</td>
                            <td>{{ $packaging->name }}</td>
                            <td>{{ $packaging->quantity }}</td>
                            <td>{{ $packaging->unit }}</td>
                            <td>{{  Str::formatVND($packaging->price) }}</td>
                            <td>{{  Str::formatVND($packaging->unit_price) }}</td>
                            <td>
                                <a href="{{ route('packagings.edit', $packaging->id) }}" class="btn btn-primary btn-sm">Sửa</a>
                                <a href="{{ route('packagings.delete', $packaging->id) }}" class="btn btn-danger btn-sm">Xóa</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $packagings->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
