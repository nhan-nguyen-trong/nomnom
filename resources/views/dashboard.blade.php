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
                    <p>Tổng số nguyên liệu: {{ Number::formatSmart($totalIngredients) }}</p>
                    <p>Số lượng tồn kho: {{ Number::formatSmart($totalIngredientQuantity) }}</p>
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
                    <p>Tổng số bao bì: {{ Number::formatSmart($totalPackagings) }}</p>
                    <p>Số lượng tồn kho: {{ Number::formatSmart($totalPackagingQuantity) }}</p>
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
                    <p>Tổng số bánh: {{ Number::formatSmart($totalCakes) }}</p>
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
                    <p>Tổng doanh thu: {{ Str::formatVND($totalRevenue) }}</p>
                    <p>Tổng lợi nhuận: {{ Str::formatVND($totalProfit) }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
