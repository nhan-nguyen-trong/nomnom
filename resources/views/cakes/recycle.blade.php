@extends('layouts.adminlte')

@section('title', 'Thùng rác bánh')

@section('page-title', 'Thùng rác bánh')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Thùng rác bánh</h3>
            <div class="card-tools">
                <a href="{{ route('cakes.index') }}" class="btn btn-primary">Quay lại</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên bánh</th>
                    <th>Ngày xóa</th>
                    <th>Hành động</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($cakes as $cake)
                    <tr>
                        <td>{{ $cake->id }}</td>
                        <td>{{ $cake->name }}</td>
                        <td>{{ $cake->deleted_at }}</td>
                        <td>
                            <a href="{{ route('cakes.restore', $cake->id) }}" class="btn btn-success btn-sm">Khôi phục</a>
                            <a href="{{ route('cakes.forceDelete', $cake->id) }}" class="btn btn-danger btn-sm">Xóa vĩnh viễn</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
