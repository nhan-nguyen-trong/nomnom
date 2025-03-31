@extends('layouts.adminlte')

@section('title', 'Bán bánh')

@section('page-title', 'Bán bánh')

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Bán bánh</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('products.sell') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Loại bánh:</label>
                    <select name="cake_id" class="form-control" required>
                        <option value="">Chọn bánh</option>
                        @foreach (\App\Models\Cake::all() as $cake)
                            <option value="{{ $cake->id }}">{{ $cake->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Số lượng bán:</label>
                    <input type="number" name="quantity_sold" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Giá bán:</label>
                    <input type="number" name="selling_price" class="form-control" step="0.01" required>
                </div>

                <button type="submit" class="btn btn-primary">Bán</button>
            </form>
        </div>
    </div>
@endsection
