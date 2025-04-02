@extends('layouts.adminlte')

@section('title', 'Xóa bánh')

@section('page-title', 'Xóa bánh')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-danger text-white">
            <h3 class="card-title">Xóa bánh</h3>
        </div>
        <div class="card-body">
            <p>Bạn có chắc chắn muốn xóa bánh <strong>{{ $cake->name }}</strong> không?</p>
            <p><strong>Công thức:</strong> {{ $cake->recipe->name ?? 'N/A' }}</p>
            <p><strong>Khấu hao:</strong> {{ Str::formatVND($cake->depreciation) }}</p>
            <p><strong>Bao bì:</strong></p>
            @if ($cake->packagings->isNotEmpty())
                <ul>
                    @foreach ($cake->packagings as $packaging)
                        <li>{{ $packaging->name }}</li>
                    @endforeach
                </ul>
            @else
                <p>Không có bao bì.</p>
            @endif

            <form action="{{ route('cakes.destroy', $cake->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Xóa</button>
                <a href="{{ route('cakes.index') }}" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
@endsection
