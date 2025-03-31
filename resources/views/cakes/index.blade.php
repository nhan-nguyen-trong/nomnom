@extends('layouts.adminlte')

@section('title', 'Sản xuất bánh')

@section('page-title', 'Sản xuất bánh')

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Sản xuất bánh</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('cakes.produce') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Tên bánh:</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Công thức:</label>
                    <select name="recipe_id" class="form-control" required>
                        <option value="">Chọn công thức</option>
                        @foreach (\App\Models\Recipe::all() as $recipe)
                            <option value="{{ $recipe->id }}">{{ $recipe->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Số lượng:</label>
                    <input type="number" name="quantity" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Bao bì:</label>
                    <select name="packaging_id" class="form-control" required>
                        <option value="">Chọn bao bì</option>
                        @foreach (\App\Models\Packaging::all() as $packaging)
                            <option value="{{ $packaging->id }}">{{ $packaging->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Khấu hao:</label>
                    <input type="number" name="depreciation" class="form-control" step="0.01">
                </div>

                <button type="submit" class="btn btn-primary">Sản xuất</button>
            </form>
        </div>
    </div>
@endsection
