<?php

namespace App\Exports;

use App\Models\TaxCalculation; // Import Model TaxCalculation
use Maatwebsite\Excel\Concerns\FromCollection; // Interface để lấy dữ liệu từ Collection
use Maatwebsite\Excel\Concerns\WithHeadings;   // Interface để thêm dòng tiêu đề
use Maatwebsite\Excel\Concerns\WithMapping;    // Interface để map dữ liệu từ Model sang hàng Excel

class TaxCalculationsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $userId;

    /**
     * Constructor để nhận User ID, giúp lọc dữ liệu cho người dùng cụ thể.
     *
     * @param int $userId ID của người dùng mà bạn muốn xuất dữ liệu.
     */
    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * Lấy dữ liệu từ database.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Lấy tất cả các bản ghi TaxCalculation của người dùng hiện tại
        // Sắp xếp theo thời gian tạo giảm dần để hiển thị các bản ghi mới nhất trước.
        return TaxCalculation::where('user_id', $this->userId)->orderByDesc('created_at')->get();
    }

    /**
     * Định nghĩa tiêu đề cho các cột trong file Excel.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID Giao dịch',
            'Thời gian tính',
            'Tổng thu nhập (VNĐ)',
            'BHXH/BHYT/BHTN (VNĐ)',
            'Số người phụ thuộc',
            'Đóng góp từ thiện (VNĐ)',
            'Đóng quỹ hưu trí TN (Gốc - VNĐ)', // Giá trị người dùng nhập
            'Đóng quỹ hưu trí TN (Được trừ - VNĐ)', // Giá trị thực tế được giảm trừ sau khi áp trần
            'Giảm trừ bản thân (VNĐ)',
            'Giảm trừ người phụ thuộc (VNĐ)',
            'Tổng các khoản giảm trừ (VNĐ)',
            'Thu nhập tính thuế (VNĐ)',
            'Thuế TNCN phải nộp (VNĐ)',
        ];
    }

    /**
     * Map dữ liệu của từng bản ghi TaxCalculation vào một hàng trong Excel.
     * Đảm bảo thứ tự các trường khớp với thứ tự của headings.
     *
     * @param \App\Models\TaxCalculation $calculation Đối tượng TaxCalculation cần map.
     * @return array
     */
    public function map($calculation): array
    {
        return [
            $calculation->id,
            $calculation->created_at->format('d/m/Y H:i:s'), // Định dạng lại ngày giờ
            $calculation->total_income,
            $calculation->social_insurance_contribution,
            $calculation->number_of_dependents,
            $calculation->charitable_contributions,
            $calculation->retirement_fund_contributions,
            $calculation->calculated_retirement_fund_deduction,
            $calculation->personal_deduction_amount,
            $calculation->dependent_deduction_amount,
            $calculation->total_deductions,
            $calculation->taxable_income,
            $calculation->final_tax_amount,
        ];
    }
}