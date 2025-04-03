@extends('layouts.adminlte')

@section('title', 'Thùng rác giao dịch bán bánh')

@section('page-title', 'Thùng rác giao dịch bán bánh')

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách giao dịch đã xóa</h3>
            <div class="card-tools">
                <a href="{{ route('products.index') }}" class="btn btn-primary">Quay lại danh sách giao dịch</a>
            </div>
        </div>
        <div class="card-body">
            @if ($products->isEmpty())
                <p>Không có giao dịch nào trong thùng rác.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên bánh</th>
                        <th>Số lượng bán</th>
                        <th>Tổng chi phí</th>
                        <th>Giá bán</th>
                        <th>Lợi nhuận</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->cake->name }}</td>
                            <td>{{ $product->quantity_sold }}</td>
                            <td>{{ Str::formatVND($product->total_cost) }}</td>
                            <td>{{ Str::formatVND($product->selling_price) }}</td>
                            <td>{{ Str::formatVND($product->selling_price - $product->total_cost) }}</td>
                            <td>
                                <a href="{{ route('products.restore', $product->id) }}" class="btn btn-success btn-sm">Khôi phục</a>
                                <!-- Nút xóa vĩnh viễn với form xác nhận -->
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $product->id }}">Xóa vĩnh viễn</button>

                                <!-- Modal xác nhận xóa -->
                                <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $product->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $product->id }}">Xác nhận xóa vĩnh viễn</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Bạn có chắc chắn muốn xóa vĩnh viễn giao dịch bán <strong>{{ $product->cake->name }}</strong> (Số lượng: {{ $product->quantity_sold }}) không?</p>
                                                <p><strong>Hoàn lại nguyên liệu và bao bì?</strong></p>
                                                <form id="deleteForm{{ $product->id }}" action="{{ route('products.forceDelete', $product->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="restore_inventory" id="restoreYes{{ $product->id }}" value="yes" checked>
                                                        <label class="form-check-label" for="restoreYes{{ $product->id }}">
                                                            Yes (Hoàn lại nguyên liệu và bao bì)
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="restore_inventory" id="restoreNo{{ $product->id }}" value="no">
                                                        <label class="form-check-label" for="restoreNo{{ $product->id }}">
                                                            No (Không hoàn lại)
                                                        </label>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                                <button type="submit" class="btn btn-danger">Xóa vĩnh viễn</button>
                                            </div>
                                            </form>
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
            // Đảm bảo modal hoạt động đúng
            $('[data-toggle="modal"]').on('click', function () {
                const target = $(this).data('target');
                $(target).modal('show');
            });
        });
    </script>
@endsection
