@extends('layouts.adminlte')

@section('title', 'Xóa giao dịch bán bánh')

@section('page-title', 'Xóa giao dịch bán bánh')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Xóa giao dịch bán bánh</h3>
        </div>
        <div class="card-body">
            <p>Bạn có chắc chắn muốn xóa giao dịch bán bánh <strong>{{ $product->cake->name }}</strong> (Số lượng: {{ $product->quantity_sold }}) không?</p>
            <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Xóa</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
@endsection
