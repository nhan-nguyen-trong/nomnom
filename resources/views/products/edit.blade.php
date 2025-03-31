@extends('layouts.adminlte')

@section('title', 'Sửa công thức')

@section('page-title', 'Sửa công thức')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Sửa công thức</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('recipes.update', $recipe->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Tên công thức:</label>
                    <input type="text" name="name" class="form-control" value="{{ $recipe->name }}" required>
                </div>
                <div class="form-group">
                    <label>Nguyên liệu:</label>
                    @foreach (\App\Models\Ingredient::all() as $ingredient)
                        <div>
                            <input type="checkbox" name="ingredients[{{ $ingredient->id }}][id]" value="{{ $ingredient->id }}"
                                   @if ($recipe->ingredients->contains($ingredient->id)) checked @endif>
                            <label>{{ $ingredient->name }}</label>
                            <input type="number" name="ingredients[{{ $ingredient->id }}][quantity]" placeholder="Số lượng" step="0.01"
                                   value="{{ $recipe->ingredients->find($ingredient->id) ? $recipe->ingredients->find($ingredient->id)->pivot->quantity : '' }}">
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </form>
        </div>
    </div>
@endsection
