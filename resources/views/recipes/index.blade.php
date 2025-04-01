@extends('layouts.adminlte')

@section('title', 'Quản lý công thức')

@section('page-title', 'Quản lý công thức')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách công thức</h3>
            <div class="card-tools">
                <a href="{{ route('recipes.create') }}" class="btn btn-primary">Thêm công thức</a>
                <a href="{{ route('recipes.recycle') }}" class="btn btn-warning">Thùng rác</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Nguyên liệu</th>
                    <th>Hành động</th>
                </tr>
                </thead>
                <tbody>
                @foreach (\App\Models\Recipe::all() as $recipe)
                    <tr>
                        <td>{{ $recipe->id }}</td>
                        <td>{{ $recipe->name }}</td>
                        <td>
                            @foreach ($recipe->ingredients as $ingredient)
                                {{ $ingredient->name }} ({{ Number::formatSmart($ingredient->pivot->quantity) }} {{ $ingredient->unit }}),
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('recipes.edit', $recipe->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                            <a href="{{ route('recipes.delete', $recipe->id) }}" class="btn btn-danger btn-sm">Xóa</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
