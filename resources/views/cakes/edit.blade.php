@extends('layouts.adminlte')

@section('title', 'Sửa bánh')

@section('page-title', 'Sửa bánh')

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title">Sửa bánh</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('cakes.update', $cake->id) }}" method="POST">
                @csrf
                @method('POST')
                <div class="form-group mb-4">
                    <label for="name" class="font-weight-bold">Tên bánh:</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $cake->name }}" required>
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label class="font-weight-bold">Chọn công thức:</label>
                    <select name="recipe_id" id="recipe-select" class="form-control" required>
                        <option value="">Chọn công thức</option>
                        @foreach ($recipes as $recipe)
                            <option value="{{ $recipe->id }}" {{ $cake->recipe_id == $recipe->id ? 'selected' : '' }}>
                                {{ $recipe->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('recipe_id')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label class="font-weight-bold">Chọn bao bì:</label>
                    <div class="input-group">
                        <select id="packaging-select" class="form-control">
                            <option value="">Chọn bao bì</option>
                            @foreach ($packagings as $packaging)
                                <option value="{{ $packaging->id }}" data-name="{{ $packaging->name }}" data-unit="{{ $packaging->unit }}">
                                    {{ $packaging->name }} ({{ $packaging->quantity }} {{ $packaging->unit }} còn lại)
                                </option>
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <button type="button" id="add-packaging" class="btn btn-success">
                                <i class="fas fa-plus"></i> Thêm
                            </button>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="font-weight-bold">Bao bì đã chọn:</label>
                    <table class="table table-bordered table-hover" id="selected-packagings">
                        <thead class="thead-light">
                        <tr>
                            <th>Bao bì</th>
                            <th>Số lượng</th>
                            <th>Đơn vị</th>
                            <th>Khấu hao (VND)</th>
                            <th>Hành động</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($cake->packagings as $packaging)
                            <tr data-id="{{ $packaging->id }}">
                                <td>{{ $packaging->name }}</td>
                                <td>
                                    <input type="number" name="packagings[{{ $packaging->id }}][quantity]" class="form-control" step="0.01" value="{{ $packaging->pivot->quantity }}" required>
                                    <input type="hidden" name="packagings[{{ $packaging->id }}][id]" value="{{ $packaging->id }}">
                                </td>
                                <td>{{ $packaging->unit }}</td>
                                <td>
                                    <input type="number" name="packagings[{{ $packaging->id }}][depreciation]" class="form-control" step="0.01" value="{{ $packaging->pivot->depreciation }}" required>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm remove-packaging">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <button type="submit" class="btn btn-primary btn-lg">Cập nhật bánh</button>
            </form>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        /* Cải thiện giao diện Select2 */
        .select2-container--default .select2-selection--single {
            border: 1px solid #ced4da;
            border-radius: 4px;
            height: 38px;
            padding: 5px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 28px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }

        /* Cải thiện bảng bao bì đã chọn */
        #selected-packagings th, #selected-packagings td {
            vertical-align: middle;
        }

        #selected-packagings input[type="number"] {
            width: 100px;
        }

        /* Cải thiện nút Thêm */
        #add-packaging {
            transition: background-color 0.3s;
        }

        #add-packaging:hover {
            background-color: #28a745;
        }

        /* Cải thiện nút Xóa */
        .remove-packaging {
            transition: background-color 0.3s;
        }

        .remove-packaging:hover {
            background-color: #c82333;
        }
    </style>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            // Khởi tạo Select2 cho công thức
            $('#recipe-select').select2({
                placeholder: "Chọn hoặc tìm kiếm công thức",
                allowClear: true,
                width: '100%',
                minimumResultsForSearch: 1,
                matcher: function(params, data) {
                    if (params.term == null || params.term.trim() === '') {
                        return data;
                    }
                    const term = params.term.toLowerCase();
                    const text = data.text.toLowerCase();
                    return text.indexOf(term) > -1 ? data : null;
                }
            });

            // Khởi tạo Select2 cho bao bì
            $('#packaging-select').select2({
                placeholder: "Chọn hoặc tìm kiếm bao bì",
                allowClear: true,
                width: '100%',
                minimumResultsForSearch: 1,
                matcher: function(params, data) {
                    if (params.term == null || params.term.trim() === '') {
                        return data;
                    }
                    const term = params.term.toLowerCase();
                    const text = data.text.toLowerCase();
                    return text.indexOf(term) > -1 ? data : null;
                }
            });

            // Xử lý sự kiện khi nhấn nút "+"
            $('#add-packaging').click(function () {
                const selectedOption = $('#packaging-select option:selected');
                const packagingId = selectedOption.val();
                const packagingName = selectedOption.data('name');
                const packagingUnit = selectedOption.data('unit');

                if (!packagingId) {
                    alert('Vui lòng chọn một bao bì!');
                    return;
                }

                // Kiểm tra xem bao bì đã được thêm chưa
                if ($(`input[name="packagings[${packagingId}][id]"]`).length > 0) {
                    alert('Bao bì này đã được thêm!');
                    return;
                }

                // Thêm hàng mới vào bảng
                const row = `
                    <tr data-id="${packagingId}">
                        <td>${packagingName}</td>
                        <td>
                            <input type="number" name="packagings[${packagingId}][quantity]" class="form-control" step="0.01" required>
                            <input type="hidden" name="packagings[${packagingId}][id]" value="${packagingId}">
                        </td>
                        <td>${packagingUnit}</td>
                        <td>
                            <input type="number" name="packagings[${packagingId}][depreciation]" class="form-control" step="0.01" required>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm remove-packaging">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                $('#selected-packagings tbody').append(row);

                // Xóa lựa chọn trong dropdown
                $('#packaging-select').val('').trigger('change');
            });

            // Xử lý sự kiện xóa bao bì
            $(document).on('click', '.remove-packaging', function () {
                $(this).closest('tr').remove();
            });
        });
    </script>
@endsection
