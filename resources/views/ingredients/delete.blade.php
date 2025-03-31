@extends('layouts.adminlte')

@section('title', 'Xóa nguyên liệu')

@section('page-title', 'Xóa nguyên liệu')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Xóa nguyên liệu</h3>
        </div>
        <div class="card-body">
            <p>Bạn có chắc chắn muốn xóa nguyên liệu <strong>{{ $ingredient->name }}</strong> không?</p>
            <form action="{{ route('ingredients.destroy', $ingredient->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Xóa</button>
                <a href="{{ route('ingredients.index') }}" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
@endsection
