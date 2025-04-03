@extends('layouts.adminlte')

@section('title', 'Chi tiết phân loại nguyên liệu')

@section('page-title', 'Chi tiết phân loại nguyên liệu')

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Chi tiết phân loại: {{ $category->name }}</h3>
            <div class="card-tools">
                <a href="{{ route('ingredients.createIngredient', $category->id) }}" class="btn btn-primary">Nhập nguyên liệu</a>
                <a href="{{ route('ingredients.recycleIngredient', $category->id) }}" class="btn btn-warning">Thùng rác</a>
                <a href="{{ route('ingredients.index') }}" class="btn btn-secondary">Quay lại</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên nguyên liệu</th>
                    <th>Số lượng</th>
                    <th>Đơn vị</th>
                    <th>Giá niêm yết</th>
                    <th>Giá mỗi đơn vị</th>
                    <th>Hành động</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($category->ingredients as $ingredient)
                    <tr>
                        <td>{{ $ingredient->id }}</td>
                        <td>{{ $ingredient->name }}</td>
                        <td>{{ $ingredient->quantity }}</td>
                        <td>{{ $ingredient->unit }}</td>
                        <td>{{ Str::formatVND($ingredient->price) }}</td>
                        <td>{{ Str::formatVND($ingredient->unit_price) }} / {{ $ingredient->unit }}</td>
                        <td>
                            <a href="{{ route('ingredients.editIngredient', $ingredient->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteIngredientModal{{ $ingredient->id }}">Xóa</button>

                            <!-- Modal xác nhận xóa nguyên liệu -->
                            <div class="modal fade" id="deleteIngredientModal{{ $ingredient->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteIngredientModalLabel{{ $ingredient->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteIngredientModalLabel{{ $ingredient->id }}">Xác nhận xóa</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Bạn có chắc chắn muốn xóa nguyên liệu <strong>{{ $ingredient->name }}</strong> không?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                            <form action="{{ route('ingredients.destroyIngredient', $ingredient->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Xóa</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('[data-toggle="modal"]').on('click', function () {
                const target = $(this).data('target');
                $(target).modal('show');
            });
        });
    </script>
@endsection
