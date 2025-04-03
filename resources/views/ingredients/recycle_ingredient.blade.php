@extends('layouts.adminlte')

@section('title', 'Thùng rác nguyên liệu')

@section('page-title', 'Thùng rác nguyên liệu')

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách nguyên liệu đã xóa trong phân loại: {{ $category->name }}</h3>
            <div class="card-tools">
                <a href="{{ route('ingredients.show', $category->id) }}" class="btn btn-primary">Quay lại danh sách</a>
            </div>
        </div>
        <div class="card-body">
            @if ($ingredients->isEmpty())
                <p>Không có nguyên liệu nào trong thùng rác.</p>
            @else
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
                    @foreach ($ingredients as $ingredient)
                        <tr>
                            <td>{{ $ingredient->id }}</td>
                            <td>{{ $ingredient->name }}</td>
                            <td>{{ $ingredient->quantity }}</td>
                            <td>{{ $ingredient->unit }}</td>
                            <td>{{ Str::formatVND($ingredient->price) }}</td>
                            <td>{{ Str::formatVND($ingredient->unit_price) }} / {{ $ingredient->unit }}</td>
                            <td>
                                <!-- Nút Khôi phục -->
                                <form action="{{ route('ingredients.restoreIngredient', $ingredient->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Khôi phục</button>
                                </form>

                                <!-- Nút Xóa vĩnh viễn -->
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#forceDeleteIngredientModal{{ $ingredient->id }}">Xóa vĩnh viễn</button>

                                <!-- Modal xác nhận xóa vĩnh viễn -->
                                <div class="modal fade" id="forceDeleteIngredientModal{{ $ingredient->id }}" tabindex="-1" role="dialog" aria-labelledby="forceDeleteIngredientModalLabel{{ $ingredient->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="forceDeleteIngredientModalLabel{{ $ingredient->id }}">Xác nhận xóa vĩnh viễn</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Bạn có chắc chắn muốn xóa vĩnh viễn nguyên liệu <strong>{{ $ingredient->name }}</strong> không?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                                <form action="{{ route('ingredients.forceDeleteIngredient', $ingredient->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">Xóa vĩnh viễn</button>
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
            @endif
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
