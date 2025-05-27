<?php

namespace App\Imports;

use App\Models\TaxCalculation;
use App\Models\TaxSetting; // Import TaxSetting
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow; // Để bỏ qua hàng tiêu đề và ánh xạ theo tên cột
use Maatwebsite\Excel\Concerns\WithValidation; // Để thêm validation
use Maatwebsite\Excel\Concerns\Importable; // Sử dụng trait Importable
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // Import 
use App\Models\TaxBracket; // Import TaxBracket model
use App\Services\TaxCalculationService;

class TaxCalculationsImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable; // Cho phép sử dụng các phương thức như import()

    private $errors = []; // Mảng để lưu trữ các lỗi cụ thể
    protected $taxCalculationService; // Thêm thuộc tính này

    public function __construct() // Thêm constructor này
    {
        $this->taxCalculationService = new TaxCalculationService(); // Khởi tạo Service
    }
    public function model(array $row)
    {
        // Lấy cài đặt thuế hiện hành.
        $taxSettings = TaxSetting::first();

        // **ĐIỂM QUAN TRỌNG CẦN ĐẢM BẢO CHÍNH XÁC**
        // Định nghĩa giá trị mặc định nếu không tìm thấy cài đặt thuế
        $personalDeduction = $taxSettings ? $taxSettings->personal_deduction : 11000000;
        $dependentDeductionPerPerson = $taxSettings ? $taxSettings->dependent_deduction_per_person : 4400000;
        $maxRetirementFundDeduction = $taxSettings ? $taxSettings->max_retirement_fund_deduction : 1000000;

        // Bắt đầu từ đây trở đi, các biến $personalDeduction, $dependentDeductionPerPerson,
        // $maxRetirementFundDeduction KHÔNG BAO GIỜ LÀ NULL nữa.
        // Chúng sẽ có giá trị từ DB nếu có, hoặc giá trị mặc định nếu không có.


        $socialInsurance = $row['social_insurance_contribution'] ?? 0;
        $dependents = $row['number_of_dependents'] ?? 0;
        $charitable = $row['charitable_contributions'] ?? 0;
        $retirementFund = $row['retirement_fund_contributions'] ?? 0;

        // Tính toán tổng các khoản giảm trừ hợp lệ
        $deductiblePersonal = $personalDeduction;
        $deductibleDependents = $dependents * $dependentDeductionPerPerson;
        $deductibleCharitable = $charitable;
        $deductibleRetirementFund = min($retirementFund, $maxRetirementFundDeduction);

        // Tổng giảm trừ KHÔNG bao gồm bảo hiểm (để tính taxableIncome)
        $totalDeductionsForTaxableIncome = $deductiblePersonal + $deductibleDependents + $deductibleCharitable + $deductibleRetirementFund;

        // Thu nhập tính thuế = Tổng thu nhập - Bảo hiểm bắt buộc - Tổng các khoản giảm trừ khác
        $taxableIncome = ($row['total_income'] ?? 0) - $socialInsurance - $totalDeductionsForTaxableIncome;

        // Đảm bảo thu nhập tính thuế không âm
        if ($taxableIncome < 0) {
            $taxableIncome = 0;
        }

        // Tính thuế lũy tiến từng phần
        $finalTaxAmount = $this->taxCalculationService->calculateProgressiveTax($taxableIncome); // Thay đổi ở đây
        
        return new TaxCalculation([
            'user_id' => Auth::id(),
            'total_income' => $row['total_income'] ?? 0,
            'social_insurance_contribution' => $socialInsurance,
            'number_of_dependents' => $dependents,
            'charitable_contributions' => $charitable,
            'retirement_fund_contributions' => $retirementFund,
            'personal_deduction_amount' => $deductiblePersonal, // Đây là nơi giá trị được gán
            'dependent_deduction_amount' => $deductibleDependents, // Đây là nơi giá trị được gán
            'calculated_retirement_fund_deduction' => $deductibleRetirementFund,
            'total_deductions' => $totalDeductionsForTaxableIncome + $socialInsurance,
            'taxable_income' => $taxableIncome,
            'final_tax_amount' => $finalTaxAmount,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }

    /**
     * Định nghĩa các quy tắc xác thực cho từng dòng.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'total_income' => 'required|numeric|min:0',
            'social_insurance_contribution' => 'required|numeric|min:0',
            'number_of_dependents' => 'required|integer|min:0',
            'charitable_contributions' => 'nullable|numeric|min:0',
            'retirement_fund_contributions' => 'nullable|numeric|min:0',
        ];
    }

    /**
     * Tùy chỉnh thông báo lỗi xác thực.
     *
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'total_income.required' => 'Cột "Tổng thu nhập" không được để trống.',
            'total_income.numeric' => 'Cột "Tổng thu nhập" phải là một số.',
            'total_income.min' => 'Cột "Tổng thu nhập" không được nhỏ hơn 0.',
            'social_insurance_contribution.required' => 'Cột "Bảo hiểm bắt buộc" không được để trống.',
            'social_insurance_contribution.numeric' => 'Cột "Bảo hiểm bắt buộc" phải là một số.',
            'social_insurance_contribution.min' => 'Cột "Bảo hiểm bắt buộc" không được nhỏ hơn 0.',
            'number_of_dependents.required' => 'Cột "Số người phụ thuộc" không được để trống.',
            'number_of_dependents.integer' => 'Cột "Số người phụ thuộc" phải là số nguyên.',
            'number_of_dependents.min' => 'Cột "Số người phụ thuộc" không được nhỏ hơn 0.',
            'charitable_contributions.numeric' => 'Cột "Đóng góp từ thiện" phải là một số.',
            'charitable_contributions.min' => 'Cột "Đóng góp từ thiện" không được nhỏ hơn 0.',
            'retirement_fund_contributions.numeric' => 'Cột "Quỹ hưu trí tự nguyện" phải là một số.',
            'retirement_fund_contributions.min' => 'Cột "Quỹ hưu trí tự nguyện" không được nhỏ hơn 0.',
        ];
    }

    /**
     * Bắt các lỗi xác thực và lưu trữ.
     *
     * @param \Illuminate\Validation\ValidationException $e
     */
    public function onFailure(\Throwable $e)
    {
        if ($e instanceof \Maatwebsite\Excel\Validators\ValidationException) {
            foreach ($e->failures() as $failure) {
                $this->errors[] = [
                    'row' => $failure->row(),
                    'attribute' => $failure->attribute(),
                    'message' => implode(', ', $failure->errors()),
                    'values' => $failure->values()
                ];
            }
        } else {
            $this->errors[] = [
                'row' => $this->getRowNum(),
                'message' => 'Lỗi không xác định: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Trả về danh sách các lỗi đã xảy ra.
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Lấy số dòng hiện tại đang được xử lý (ước lượng).
     * Điều này không hoàn toàn chính xác với Maatwebsite, nhưng hữu ích để debug.
     * @return int
     */
    private function getRowNum() {
        // Maatwebsite/Excel không cung cấp trực tiếp số dòng đang xử lý trong model()
        // Cần truyền thông tin này vào hoặc ước lượng.
        // Đối với mục đích hiển thị lỗi, $failure->row() trong onFailure() là chính xác.
        // Phần này chỉ để tránh lỗi nếu cần 1 số dòng tạm thời.
        return 0; // Sẽ được cập nhật chính xác hơn qua onFailure
    }

    /**
     * Hàm tính thuế lũy tiến từng phần dựa trên các bậc thuế trong database.
     * Đặt ở đây để có thể tái sử dụng. Tốt nhất nên tách ra một Service class.
     *
     * @param float $taxableIncome
     * @return float
     */
    private function calculateProgressiveTax(float $taxableIncome): float
    {
        $taxAmount = 0;

        // Lấy tất cả các bậc thuế, sắp xếp theo thứ tự
        $taxBrackets = TaxBracket::orderBy('order')->get();

        if ($taxBrackets->isEmpty()) {
            \Log::warning('Không tìm thấy cấu hình bậc thuế TNCN. Thuế suất sẽ được tính là 0.');
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

        return round($taxAmount, 0);
    }
}