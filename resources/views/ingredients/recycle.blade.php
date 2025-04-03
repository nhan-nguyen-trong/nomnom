@extends('layouts.adminlte')

@section('title', 'Thùng rác loại nguyên liệu')

@section('page-title', 'Thùng rác loại nguyên liệu')

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách loại nguyên liệu đã xóa</h3>
            <div class="card-tools">
                <a href="{{ route('ingredients.index') }}" class="btn btn-primary">Quay lại danh sách</a>
            </div>
        </div>
        <div class="card-body">
            @if ($categories->isEmpty())
                <p>Không có loại nguyên liệu nào trong thùng rác.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên loại nguyên liệu</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>
                                <!-- Nút Khôi phục -->
                                <form action="{{ route('ingredients.restore', $category->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Khôi phục</button>
                                </form>

                                <!-- Nút Xóa vĩnh viễn -->
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#forceDeleteModal{{ $category->id }}">Xóa vĩnh viễn</button>

                                <!-- Modal xác nhận xóa vĩnh viễn -->
                                <div class="modal fade" id="forceDeleteModal{{ $category->id }}" tabindex="-1" role="dialog" aria-labelledby="forceDeleteModalLabel{{ $category->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="forceDeleteModalLabel{{ $category->id }}">Xác nhận xóa vĩnh viễn</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Bạn có chắc chắn muốn xóa vĩnh viễn loại nguyên liệu <strong>{{ $category->name }}</strong> không?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                                <form action="{{ route('ingredients.forceDelete', $category->id) }}" method="POST" style="display:inline;">
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
