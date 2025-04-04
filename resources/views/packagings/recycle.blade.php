@extends('layouts.adminlte')

@section('title', 'Thùng rác bao bì')

@section('page-title', 'Thùng rác bao bì')

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách bao bì đã xóa</h3>
            <div class="card-tools">
                <a href="{{ route('packagings.index') }}" class="btn btn-primary">Quay lại danh sách</a>
            </div>
        </div>
        <div class="card-body">
            @if ($packagings->isEmpty())
                <p>Không có bao bì nào trong thùng rác.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên bao bì</th>
                        <th>Số lượng</th>
                        <th>Đơn vị</th>
                        <th>Giá niêm yết</th>
                        <th>Đơn giá</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($packagings as $packaging)
                        <tr>
                            <td>{{ $packaging->id }}</td>
                            <td>{{ $packaging->name }}</td>
                            <td>{{ $packaging->quantity }}</td>
                            <td>{{ $packaging->unit }}</td>
                            <td>{{ number_format($packaging->price, 2) }} VNĐ</td>
                            <td>{{ number_format($packaging->unit_price, 2) }} VNĐ</td>
                            <td>
                                <form action="{{ route('packagings.restore', $packaging->id) }}" method="GET" style="display:inline;">
                                    <button type="submit" class="btn btn-success btn-sm">Khôi phục</button>
                                </form>
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#forceDeleteModal{{ $packaging->id }}">Xóa vĩnh viễn</button>

                                <!-- Modal xác nhận xóa vĩnh viễn -->
                                <div class="modal fade" id="forceDeleteModal{{ $packaging->id }}" tabindex="-1" role="dialog" aria-labelledby="forceDeleteModalLabel{{ $packaging->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="forceDeleteModalLabel{{ $packaging->id }}">Xác nhận xóa vĩnh viễn</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Bạn có chắc chắn muốn xóa vĩnh viễn bao bì <strong>{{ $packaging->name }}</strong> không?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                                <form action="{{ route('packagings.forceDelete', $packaging->id) }}" method="GET" style="display:inline;">
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
