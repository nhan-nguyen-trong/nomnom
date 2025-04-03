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
            // Chuyển số thành chuỗi với độ chính xác đầy đủ
            $formatted = rtrim(sprintf('%.'.$decimals.'f', $number), '0'); // Loại bỏ số 0 thừa ở cuối
            $formatted = rtrim($formatted, '.'); // Loại bỏ dấu chấm nếu không còn phần thập phân

            // Thêm dấu chấm làm phân cách hàng nghìn cho phần nguyên
            $parts = explode('.', $formatted);
            $parts[0] = number_format((float)$parts[0], 0, '', '.');

            // Nối lại phần nguyên và phần thập phân (nếu có)
            return isset($parts[1]) ? $parts[0] . ',' . $parts[1] : $parts[0];
        });
    }
}
