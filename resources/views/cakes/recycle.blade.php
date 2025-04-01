@extends('layouts.adminlte')

@section('title', 'Thùng rác bánh')

@section('page-title', 'Thùng rác bánh')

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách bánh đã xóa</h3>
            <div class="card-tools">
                <a href="{{ route('cakes.index') }}" class="btn btn-primary">Quay lại danh sách bánh</a>
            </div>
        </div>
        <div class="card-body">
            @if ($cakes->isEmpty())
                <p>Không có bánh nào trong thùng rác.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên bánh</th>
                        <th>Công thức</th>
                        <th>Khấu hao</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($cakes as $cake)
                        <tr>
                            <td>{{ $cake->id }}</td>
                            <td>{{ $cake->name }}</td>
                            <td>{{ $cake->recipe->name ?? 'N/A' }}</td>
                            <td>{{ Str::formatVND($cake->depreciation) }}</td>
                            <td>
                                <a href="{{ route('cakes.restore', $cake->id) }}" class="btn btn-success btn-sm">Khôi phục</a>
                                <a href="{{ route('cakes.forceDelete', $cake->id) }}" class="btn btn-danger btn-sm">Xóa vĩnh viễn</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
