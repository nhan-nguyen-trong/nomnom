@extends('layouts.adminlte')

@section('title', 'Sửa công thức')

@section('page-title', 'Sửa công thức')

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
            <h3 class="card-title">Sửa công thức</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('recipes.update', $recipe->id) }}" method="POST">
                @csrf
                @method('POST')
                <div class="form-group mb-4">
                    <label for="name" class="font-weight-bold">Tên công thức:</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $recipe->name }}" required>
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label class="font-weight-bold">Chọn nguyên liệu:</label>
                    <div class="input-group mb-3">
                        <select id="ingredient-select" class="form-control" aria-label="Chọn nguyên liệu">
                            <option value="">Chọn hoặc tìm kiếm nguyên liệu</option>
                            @foreach ($ingredients as $ingredient)
                                <option value="{{ $ingredient->id }}" data-name="{{ $ingredient->name }}" data-unit="{{ $ingredient->unit }}">
                                    {{ $ingredient->name }} ({{ $ingredient->quantity }} {{ $ingredient->unit }} còn lại)
                                </option>
                            @endforeach
                        </select>
                        <span class="input-group-text" id="add-ingredient" style="cursor: pointer;">
                            <i class="fas fa-plus"></i> Thêm
                        </span>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="font-weight-bold">Nguyên liệu đã chọn:</label>
                    <table class="table table-bordered table-hover" id="selected-ingredients">
                        <thead class="thead-light">
                        <tr>
                            <th>Nguyên liệu</th>
                            <th>Số lượng</th>
                            <th>Đơn vị</th>
                            <th>Hành động</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($recipe->ingredients as $ingredient)
                            <tr data-id="{{ $ingredient->id }}">
                                <td>{{ $ingredient->name }}</td>
                                <td>
                                    <input type="number" name="ingredients[{{ $ingredient->id }}][quantity]" class="form-control" step="0.01" value="{{ $ingredient->pivot->quantity }}" required>
                                    <input type="hidden" name="ingredients[{{ $ingredient->id }}][id]" value="{{ $ingredient->id }}">
                                </td>
                                <td>{{ $ingredient->unit }}</td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm remove-ingredient">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <button type="submit" class="btn btn-primary btn-lg">Cập nhật công thức</button>
            </form>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        /* Cải thiện giao diện Select2 */
        .select2-container--default .select2-selection--single {
            border: 1px solid #ced4da;
            border-radius: 4px 0 0 4px; /* Bo góc bên trái */
            height: 38px;
            padding: 5px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 28px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }

        /* Cải thiện nút Thêm trong input-group */
        .input-group-text {
            background-color: #28a745;
            color: white;
            border: 1px solid #28a745;
            border-radius: 0 4px 4px 0; /* Bo góc bên phải */
            transition: background-color 0.3s;
        }

        .input-group-text:hover {
            background-color: #218838;
        }

        /* Cải thiện bảng nguyên liệu đã chọn */
        #selected-ingredients th, #selected-ingredients td {
            vertical-align: middle;
        }

        #selected-ingredients input[type="number"] {
            width: 100px;
        }

        /* Cải thiện nút Xóa */
        .remove-ingredient {
            transition: background-color 0.3s;
        }

        .remove-ingredient:hover {
            background-color: #c82333;
        }
    </style>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            // Khởi tạo Select2 với tìm kiếm
            $('#ingredient-select').select2({
                placeholder: "Chọn hoặc tìm kiếm nguyên liệu",
                allowClear: true,
                width: '40%',
                minimumResultsForSearch: 1, // Hiển thị thanh tìm kiếm ngay cả khi có ít mục
                matcher: function(params, data) {
                    // Tìm kiếm không phân biệt hoa thường
                    if (params.term == null || params.term.trim() === '') {
                        return data;
                    }
                    const term = params.term.toLowerCase();
                    const text = data.text.toLowerCase();
                    return text.indexOf(term) > -1 ? data : null;
                }
            });

            // Xử lý sự kiện khi nhấn nút "+"
            $('#add-ingredient').click(function () {
                const selectedOption = $('#ingredient-select option:selected');
                const ingredientId = selectedOption.val();
                const ingredientName = selectedOption.data('name');
                const ingredientUnit = selectedOption.data('unit');

                if (!ingredientId) {
                    alert('Vui lòng chọn một nguyên liệu!');
                    return;
                }

                // Kiểm tra xem nguyên liệu đã được thêm chưa
                if ($(`input[name="ingredients[${ingredientId}][id]"]`).length > 0) {
                    alert('Nguyên liệu này đã được thêm!');
                    return;
                }

                // Thêm hàng mới vào bảng
                const row = `
                    <tr data-id="${ingredientId}">
                        <td>${ingredientName}</td>
                        <td>
                            <input type="number" name="ingredients[${ingredientId}][quantity]" class="form-control" step="0.01" required>
                            <input type="hidden" name="ingredients[${ingredientId}][id]" value="${ingredientId}">
                        </td>
                        <td>${ingredientUnit}</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm remove-ingredient">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                $('#selected-ingredients tbody').append(row);

                // Xóa lựa chọn trong dropdown
                $('#ingredient-select').val('').trigger('change');
            });

            // Xử lý sự kiện xóa nguyên liệu
            $(document).on('click', '.remove-ingredient', function () {
                $(this).closest('tr').remove();
            });
        });
    </script>
@endsection
