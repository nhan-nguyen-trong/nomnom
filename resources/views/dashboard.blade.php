@extends('layouts.adminlte')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')
    <div class="row">
        <!-- Card Nguyên liệu -->
        <div class="col-md-3">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Nguyên liệu</h3>
                </div>
                <div class="card-body">
                    <p>Tổng số nguyên liệu: {{ \App\Models\Ingredient::count() }}</p>
                    <p>Số lượng tồn kho: {{ \App\Models\Ingredient::sum('quantity') }}</p>
                </div>
            </div>
        </div>

        <!-- Card Bao bì -->
        <div class="col-md-3">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Bao bì</h3>
                </div>
                <div class="card-body">
                    <p>Tổng số bao bì: {{ \App\Models\Packaging::count() }}</p>
                    <p>Số lượng tồn kho: {{ \App\Models\Packaging::sum('quantity') }}</p>
                </div>
            </div>
        </div>

        <!-- Card Bánh -->
        <div class="col-md-3">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Bánh</h3>
                </div>
                <div class="card-body">
                    <p>Tổng số bánh: {{ \App\Models\Cake::count() }}</p>
                </div>
            </div>
        </div>

        <!-- Card Doanh thu -->
        <div class="col-md-3">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Doanh thu</h3>
                </div>
                <div class="card-body">
                    <p>Tổng doanh thu: {{ \App\Models\Product::sum('selling_price') }} VND</p>
                    <p>Tổng lợi nhuận: {{ \App\Models\Product::sum('selling_price') - \App\Models\Product::sum('total_cost') }} VND</p>
                </div>
            </div>
        </div>
    </div>
@endsection
