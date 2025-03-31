@extends('layouts.adminlte')

@section('title', 'Thùng rác nguyên liệu')

@section('page-title', 'Thùng rác nguyên liệu')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Thùng rác nguyên liệu</h3>
            <div class="card-tools">
                <a href="{{ route('ingredients.index') }}" class="btn btn-primary">Quay lại danh sách</a>
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
                @foreach (\App\Models\Ingredient::onlyTrashed()->get() as $ingredient)
                    <tr>
                        <td>{{ $ingredient->id }}</td>
                        <td>{{ $ingredient->name }}</td>
                        <td>{{ $ingredient->unit }}</td>
                        <td>{{ $ingredient->price }}</td>
                        <td>{{ $ingredient->quantity }}</td>
                        <td>{{ $ingredient->deleted_at }}</td>
                        <td>
                            <a href="{{ route('ingredients.restore', $ingredient->id) }}" class="btn btn-success btn-sm">Khôi phục</a>
                            <a href="{{ route('ingredients.forceDelete', $ingredient->id) }}" class="btn btn-danger btn-sm">Xóa vĩnh viễn</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
