@extends('layouts.adminlte')

@section('title', 'Thùng rác công thức')

@section('page-title', 'Thùng rác công thức')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Thùng rác công thức</h3>
            <div class="card-tools">
                <a href="{{ route('recipes.index') }}" class="btn btn-primary">Quay lại danh sách</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Ngày xóa</th>
                    <th>Hành động</th>
                </tr>
                </thead>
                <tbody>
                @foreach (\App\Models\Recipe::onlyTrashed()->get() as $recipe)
                    <tr>
                        <td>{{ $recipe->id }}</td>
                        <td>{{ $recipe->name }}</td>
                        <td>{{ $recipe->deleted_at }}</td>
                        <td>
                            <a href="{{ route('recipes.restore', $recipe->id) }}" class="btn btn-success btn-sm">Khôi phục</a>
                            <a href="{{ route('recipes.forceDelete', $recipe->id) }}" class="btn btn-danger btn-sm">Xóa vĩnh viễn</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
