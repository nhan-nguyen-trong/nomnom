@extends('layouts.adminlte')

@section('title', 'Xóa công thức')

@section('page-title', 'Xóa công thức')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Xóa công thức</h3>
        </div>
        <div class="card-body">
            <p>Bạn có chắc chắn muốn xóa công thức <strong>{{ $recipe->name }}</strong> không?</p>
            <form action="{{ route('recipes.destroy', $recipe->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Xóa</button>
                <a href="{{ route('recipes.index') }}" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
@endsection
