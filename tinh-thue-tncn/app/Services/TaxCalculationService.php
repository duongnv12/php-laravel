<?php

namespace App\Services; // Đảm bảo namespace là App\Services

use App\Models\TaxBracket;
use Illuminate\Support\Facades\Log;

class TaxCalculationService // Đảm bảo tên class là TaxCalculationService
{
    /**
     * Hàm tính thuế lũy tiến từng phần dựa trên các bậc thuế trong database.
     *
     * @param float $taxableIncome Thu nhập chịu thuế
     * @return float Tổng số thuế phải nộp, làm tròn đến đơn vị đồng
     */
    public function calculateProgressiveTax(float $taxableIncome): float // Đảm bảo tên phương thức chính xác, không thừa thiếu ký tự
    {
        $taxAmount = 0;

        // Lấy tất cả các bậc thuế, sắp xếp theo thứ tự đã định nghĩa
        $taxBrackets = TaxBracket::orderBy('order')->get();

        // Kiểm tra nếu không có bậc thuế nào được cấu hình
        if ($taxBrackets->isEmpty()) {
            Log::warning('Không tìm thấy cấu hình bậc thuế TNCN trong database. Thuế suất sẽ được tính là 0.');
            return 0;
        }

        foreach ($taxBrackets as $bracket) {
            $minIncome = $bracket->min_income;
            $maxIncome = $bracket->max_income;
            $taxRate = $bracket->tax_rate / 100;

            if ($taxableIncome <= $minIncome) {
                break;
            }

            $incomeInBracket = 0;
            if (is_null($maxIncome)) {
                $incomeInBracket = $taxableIncome - $minIncome;
            } else {
                if ($taxableIncome <= $maxIncome) {
                    $incomeInBracket = $taxableIncome - $minIncome;
                } else {
                    $incomeInBracket = $maxIncome - $minIncome;
                }
            }

            $taxAmount += $incomeInBracket * $taxRate;

            if ($taxableIncome <= $maxIncome || is_null($maxIncome)) {
                break;
            }
        }

        return round(max(0, $taxAmount), 0);
    }
}