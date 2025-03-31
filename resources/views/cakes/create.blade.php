@extends('layouts.adminlte')

@section('title', 'Thêm công thức')

@section('page-title', 'Thêm công thức')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Thêm công thức</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('recipes.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Tên công thức:</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Nguyên liệu:</label>
                    @foreach (\App\Models\Ingredient::all() as $ingredient)
                        <div>
                            <input type="checkbox" name="ingredients[{{ $ingredient->id }}][id]" value="{{ $ingredient->id }}">
                            <label>{{ $ingredient->name }}</label>
                            <input type="number" name="ingredients[{{ $ingredient->id }}][quantity]" placeholder="Số lượng" step="0.01">
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-primary">Thêm</button>
            </form>
        </div>
    </div>
@endsection
