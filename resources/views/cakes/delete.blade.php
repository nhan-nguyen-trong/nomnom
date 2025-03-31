@extends('layouts.adminlte')

@section('title', 'Xóa bánh')

@section('page-title', 'Xóa bánh')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Xóa bánh</h3>
        </div>
        <div class="card-body">
            <p>Bạn có chắc chắn muốn xóa bánh <strong>{{ $cake->name }}</strong> không?</p>
            <form action="{{ route('cakes.destroy', $cake->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Xóa</button>
                <a href="{{ route('cakes.index') }}" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
@endsection
