@extends('layouts.adminlte')

@section('title', 'Xóa báo cáo doanh thu')

@section('page-title', 'Xóa báo cáo doanh thu')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Xóa báo cáo doanh thu</h3>
        </div>
        <div class="card-body">
            <p>Bạn có chắc chắn muốn xóa báo cáo doanh thu cho bánh <strong>{{ $product->cake->name }}</strong> (Số lượng: {{ $product->quantity_sold }}) không?</p>
            <form action="{{ route('reports.destroy', $product->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Xóa</button>
                <a href="{{ route('reports.index') }}" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
@endsection
