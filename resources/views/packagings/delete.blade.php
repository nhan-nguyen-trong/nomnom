@extends('layouts.adminlte')

@section('title', 'Xóa bao bì')

@section('page-title', 'Xóa bao bì')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Xóa bao bì</h3>
        </div>
        <div class="card-body">
            <p>Bạn có chắc chắn muốn xóa bao bì <strong>{{ $packaging->name }}</strong> không?</p>
            <form action="{{ route('packagings.destroy', $packaging->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Xóa</button>
                <a href="{{ route('packagings.index') }}" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
@endsection
