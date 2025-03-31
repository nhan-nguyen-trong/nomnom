@extends('layouts.adminlte')

@section('title', 'Thùng rác bao bì')

@section('page-title', 'Thùng rác bao bì')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Thùng rác bao bì</h3>
            <div class="card-tools">
                <a href="{{ route('packagings.index') }}" class="btn btn-primary">Quay lại danh sách</a>
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
                    <th>Ngày xóa</th>
                    <th>Hành động</th>
                </tr>
                </thead>
                <tbody>
                @foreach (\App\Models\Packaging::onlyTrashed()->get() as $packaging)
                    <tr>
                        <td>{{ $packaging->id }}</td>
                        <td>{{ $packaging->name }}</td>
                        <td>{{ $packaging->unit }}</td>
                        <td>{{ $packaging->price }}</td>
                        <td>{{ $packaging->quantity }}</td>
                        <td>{{ $packaging->deleted_at }}</td>
                        <td>
                            <a href="{{ route('packagings.restore', $packaging->id) }}" class="btn btn-success btn-sm">Khôi phục</a>
                            <a href="{{ route('packagings.forceDelete', $packaging->id) }}" class="btn btn-danger btn-sm">Xóa vĩnh viễn</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
