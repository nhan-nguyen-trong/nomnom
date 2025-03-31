<?php

namespace App\Helpers;

class FormatHelper
{
    /**
     * Định dạng tiền VND với dấu chấm phân cách hàng nghìn.
     *
     * @param float $amount Số tiền cần định dạng
     * @param int $decimals Số chữ số thập phân
     * @return string
     */
    public static function formatVND($amount, $decimals = 2)
    {
        // Định dạng số với dấu phẩy làm phân cách hàng nghìn
        $formatted = number_format($amount, $decimals, ',', '.');
        // Thay dấu phẩy bằng dấu chấm
        $formatted = str_replace(',', '.', $formatted);
        // Thêm ký hiệu đ
        return $formatted . 'đ';
    }
}
