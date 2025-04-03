@extends('layouts.adminlte')

@section('title', 'Quản lý nguyên liệu')

@section('page-title', 'Quản lý nguyên liệu')

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách phân loại nguyên liệu</h3>
            <div class="card-tools">
                <a href="{{ route('ingredients.create') }}" class="btn btn-primary">Nhập loại nguyên liệu</a>
                <a href="{{ route('ingredients.recycle') }}" class="btn btn-warning">Thùng rác</a>
            </div>
        </div>
        <div class="card-body">
            <p><strong>Tổng tiền: {{ Str::formatVND($totalPrice) }}</strong></p>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Phân loại</th>
                    <th>Tổng số lượng</th>
                    <th>Hành động</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            {{ $category->ingredients->sum('quantity') }} {{ $category->ingredients->first()->unit ?? '' }}
                        </td>
                        <td>
                            <a href="{{ route('ingredients.show', $category->id) }}" class="btn btn-info btn-sm">Chi tiết</a>
                            <a href="{{ route('ingredients.edit', $category->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $category->id }}">Xóa</button>

                            <!-- Modal xác nhận xóa -->
                            <div class="modal fade" id="deleteModal{{ $category->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $category->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $category->id }}">Xác nhận xóa</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Bạn có chắc chắn muốn xóa loại nguyên liệu <strong>{{ $category->name }}</strong> không?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                            <form action="{{ route('ingredients.destroy', $category->id) }}" method="POST" style="display:inline;">
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
            <!-- Thêm phân trang -->
            <div class="mt-4">
                {{ $categories->links('pagination.custom') }}
            </div>
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
