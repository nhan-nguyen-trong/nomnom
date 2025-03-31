<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Support\Number;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Đăng ký macro 'formatVND' để định dạng tiền VND
        Str::macro('formatVND', function ($value) {
            // Chuyển đổi giá trị thành số và định dạng với dấu chấm
            $formatted = number_format($value, 0, ',', '.');
            // Thêm ký hiệu 'đ' vào cuối
            return $formatted . 'đ';
        });

        // Đăng ký macro formatSmart cho Number
        Number::macro('formatSmart', function (float $number, int $decimals = 2) {
            // Nếu phần thập phân bằng 0, chỉ hiển thị số nguyên
            if (floor($number * pow(10, $decimals)) == $number * pow(10, $decimals)) {
                return number_format($number, 0, ',', '.');
            }
            // Nếu không, hiển thị đầy đủ với số chữ số thập phân được chỉ định
            return number_format($number, $decimals, ',', '.');
        });
    }
}
