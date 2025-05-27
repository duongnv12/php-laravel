<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\TaxSetting; // Import Model TaxSetting
use App\Models\TaxCalculation; // Import Model TaxCalculation
use Illuminate\Support\Facades\Auth; // Import Auth facade
use Maatwebsite\Excel\Facades\Excel; // Import facade cho Laravel Excel
use App\Exports\TaxCalculationsExport; // Import lớp Export Excel
use Barryvdh\DomPDF\Facade\Pdf; // Import facade cho DomPDF
use App\Imports\TaxCalculationsImport; // Import lớp Import Excel
use Illuminate\Support\Facades\DB; // Import DB facade để sử dụng transaction
use App\Models\TaxBracket; // Import Model TaxBracket
use App\Services\TaxCalculationService; // Import service tính thuế

class TaxCalculatorController extends Controller
{
    // Biểu thuế lũy tiến từng phần theo tháng (Ngưỡng trên, Thuế suất, Số thuế tính nhanh tại ngưỡng)
    // Tạm thời vẫn để trong Controller vì nó là một cấu trúc phức tạp và ít thay đổi
    // Nếu cần thay đổi biểu thuế động, sẽ cần một hệ thống quản lý phức tạp hơn
    // (ví dụ: một bảng riêng trong DB cho tax_brackets với các trường from_income, to_income, rate, quick_tax_amount)
    const TAX_BRACKETS = [
        [5000000, 5, 0],       // Bậc 1: đến 5 triệu, 5%, (0 + 5M*5% = 250K)
        [10000000, 10, 250000],  // Bậc 2: trên 5 đến 10 triệu, 10%, (250K + (10M-5M)*10% = 750K)
        [18000000, 15, 750000],  // Bậc 3: trên 10 đến 18 triệu, 15%, (750K + (18M-10M)*15% = 1.950K)
        [32000000, 20, 1950000], // Bậc 4: trên 18 đến 32 triệu, 20%, (1.950K + (32M-18M)*20% = 4.750K)
        [52000000, 25, 4750000], // Bậc 5: trên 32 đến 52 triệu, 25%, (4.750K + (52M-32M)*25% = 9.750K)
        [80000000, 30, 9750000], // Bậc 6: trên 52 đến 80 triệu, 30%, (9.750K + (80M-52M)*30% = 18.150K)
        [PHP_INT_MAX, 35, 18150000], // Bậc 7: trên 80 triệu, 35%
    ];

    public const MAX_RETIREMENT_FUND_DEDUCTION = 3000000; // Đặt giá trị phù hợp theo quy định

    protected $taxCalculationService; // Thêm thuộc tính này

    public function __construct(TaxCalculationService $taxCalculationService) // Thêm constructor này
    {
        $this->taxCalculationService = $taxCalculationService;
    }

    /**
     * Hiển thị form tính thuế cho người dùng.
     *
     * @return \Illuminate\View\View
     */
    public function showCalculatorForm(): \Illuminate\View\View
    {
        return view('calculator.form');
    }

    /**
     * Xử lý yêu cầu tính thuế và lưu lịch sử.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function calculateTax(Request $request): \Illuminate\Http\RedirectResponse|\Illuminate\View\View
    {
        // 1. Validate dữ liệu đầu vào
        try {
            $validated = $request->validate([
                'total_income' => 'required|numeric|min:0',
                'social_insurance_contribution' => 'required|numeric|min:0',
                'number_of_dependents' => 'required|integer|min:0',
                'charitable_contributions' => 'nullable|numeric|min:0',
                'retirement_fund_contributions' => 'nullable|numeric|min:0',
            ]);
        } catch (ValidationException $e) {
            // Nếu có lỗi validation, quay lại form với thông báo lỗi
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

        // 2. Lấy dữ liệu từ request
        $totalIncome = (float) $validated['total_income'];
        $socialInsurance = (float) $validated['social_insurance_contribution'];
        $numberOfDependents = (int) $validated['number_of_dependents'];
        $charitableContributions = (float) ($validated['charitable_contributions'] ?? 0);
        $retirementFundContributions = (float) ($validated['retirement_fund_contributions'] ?? 0);

        // 3. Lấy các hằng số giảm trừ từ database
        // Đảm bảo các TaxSetting đã được tạo trong bảng tax_settings
        $personalDeductionAmount = (float) TaxSetting::where('key', 'personal_deduction')->value('value');
        $dependentDeductionAmount = (float) TaxSetting::where('key', 'dependent_deduction')->value('value');
        $maxRetirementFundDeduction = (float) TaxSetting::where('key', 'max_retirement_fund_deduction')->value('value');

        // 4. Tính toán các khoản giảm trừ
        $actualRetirementFundDeduction = min($retirementFundContributions, $maxRetirementFundDeduction);

        $totalDeductions = $personalDeductionAmount // Giảm trừ bản thân
                         + ($numberOfDependents * $dependentDeductionAmount) // Giảm trừ người phụ thuộc
                         + $socialInsurance // Bảo hiểm bắt buộc
                         + $charitableContributions // Từ thiện, nhân đạo, khuyến học
                         + $actualRetirementFundDeduction; // Quỹ hưu trí tự nguyện (đã áp trần)

        // 5. Tính thu nhập tính thuế
        $taxableIncome = $totalIncome - $totalDeductions;
        // Đảm bảo thu nhập tính thuế không âm
        if ($taxableIncome < 0) {
            $taxableIncome = 0;
        }

        // 6. Tính thuế TNCN theo biểu lũy tiến
        $finalTaxAmount = $this->taxCalculationService->calculateProgressiveTax($taxableIncome); // Thay đổi ở đây

        // 7. Lưu lịch sử tính toán vào database (nếu người dùng đã đăng nhập)
        if (Auth::check()) {
            Auth::user()->taxCalculations()->create([
                'total_income' => $totalIncome,
                'social_insurance_contribution' => $socialInsurance,
                'number_of_dependents' => $numberOfDependents,
                'charitable_contributions' => $charitableContributions,
                'retirement_fund_contributions' => $retirementFundContributions, // Giá trị gốc người dùng nhập
                'calculated_retirement_fund_deduction' => $actualRetirementFundDeduction, // Giá trị thực tế được giảm trừ
                'personal_deduction_amount' => $personalDeductionAmount,
                'dependent_deduction_amount' => $dependentDeductionAmount,
                'total_deductions' => $totalDeductions,
                'taxable_income' => $taxableIncome,
                'final_tax_amount' => $finalTaxAmount,
            ]);
        }

        // 8. Trả về view kết quả
        return view('calculator.result', compact(
            'totalIncome',
            'socialInsurance',
            'numberOfDependents',
            'totalDeductions',
            'taxableIncome',
            'finalTaxAmount',
            'personalDeductionAmount',
            'dependentDeductionAmount',
            'charitableContributions',
            'retirementFundContributions', // Vẫn truyền giá trị gốc để người dùng xem lại
            'actualRetirementFundDeduction' // Truyền giá trị đã được áp trần để hiển thị chính xác
        ));
    }

    /**
     * Hàm tính thuế lũy tiến từng phần dựa trên các bậc thuế trong database.
     *
     * @param float $taxableIncome
     * @return float
     */
    // private function calculateProgressiveTax(float $taxableIncome): float
    // {
    //     $taxAmount = 0;

    //     // Lấy tất cả các bậc thuế, sắp xếp theo thứ tự
    //     $taxBrackets = TaxBracket::orderBy('order')->get();

    //     if ($taxBrackets->isEmpty()) {
    //         // Xử lý trường hợp không có bậc thuế nào được cấu hình
    //         // Có thể log lỗi, ném exception, hoặc trả về 0 thuế
    //         \Log::warning('Không tìm thấy cấu hình bậc thuế TNCN. Thuế suất sẽ được tính là 0.');
    //         return 0;
    //     }

    //     foreach ($taxBrackets as $bracket) {
    //         $minIncome = $bracket->min_income;
    //         $maxIncome = $bracket->max_income; // Có thể là null
    //         $taxRate = $bracket->tax_rate / 100; // Chuyển từ % sang thập phân

    //         // Nếu thu nhập chịu thuế nhỏ hơn hoặc bằng mức tối thiểu của bậc hiện tại, dừng lại.
    //         // Điều này xử lý trường hợp thu nhập nằm trong bậc 0 hoặc không đủ để đạt đến bậc này.
    //         if ($taxableIncome <= $minIncome) {
    //             break;
    //         }

    //         // Tính phần thu nhập chịu thuế trong bậc hiện tại
    //         $incomeInBracket = 0;
    //         if (is_null($maxIncome)) { // Bậc cuối cùng (không có giới hạn tối đa)
    //             $incomeInBracket = $taxableIncome - $minIncome;
    //         } else { // Các bậc giữa
    //             if ($taxableIncome <= $maxIncome) {
    //                 $incomeInBracket = $taxableIncome - $minIncome;
    //             } else {
    //                 $incomeInBracket = $maxIncome - $minIncome;
    //             }
    //         }

    //         // Cộng thuế của phần thu nhập trong bậc này
    //         $taxAmount += $incomeInBracket * $taxRate;

    //         // Nếu đã tính hết phần thu nhập chịu thuế (đã nằm hoàn toàn trong bậc hiện tại và không còn phần nào cho bậc cao hơn)
    //         if ($taxableIncome <= $maxIncome || is_null($maxIncome)) {
    //             break;
    //         }
    //     }

    //     return round($taxAmount, 0); // Làm tròn đến đơn vị đồng
    // }


    /**
     * Hiển thị form cấu hình các hằng số thuế (chỉ dành cho Admin).
     *
     * @return \Illuminate\View\View
     */
    public function showTaxSettingsForm(): \Illuminate\View\View
    {
        // Đọc giá trị cấu hình từ database
        $personalDeduction = (float) TaxSetting::where('key', 'personal_deduction')->value('value');
        $dependentDeduction = (float) TaxSetting::where('key', 'dependent_deduction')->value('value');
        $maxRetirementFundDeduction = (float) TaxSetting::where('key', 'max_retirement_fund_deduction')->value('value');
        $taxBrackets = self::TAX_BRACKETS; // Biểu thuế vẫn lấy từ hằng số

        return view('admin.tax_settings', compact('personalDeduction', 'dependentDeduction', 'maxRetirementFundDeduction', 'taxBrackets'));
    }

    /**
     * Xử lý lưu các cấu hình thuế (chỉ dành cho Admin).
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveTaxSettings(Request $request): \Illuminate\Http\RedirectResponse
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'new_personal_deduction' => 'required|numeric|min:0',
            'new_dependent_deduction' => 'required|numeric|min:0',
            'new_max_retirement_fund_deduction' => 'required|numeric|min:0',
        ]);

        // Cập nhật hoặc tạo mới các cài đặt trong database
        TaxSetting::updateOrCreate(
            ['key' => 'personal_deduction'],
            ['value' => $request->new_personal_deduction, 'description' => 'Mức giảm trừ bản thân']
        );
        TaxSetting::updateOrCreate(
            ['key' => 'dependent_deduction'],
            ['value' => $request->new_dependent_deduction, 'description' => 'Mức giảm trừ người phụ thuộc']
        );
        TaxSetting::updateOrCreate(
            ['key' => 'max_retirement_fund_deduction'],
            ['value' => $request->new_max_retirement_fund_deduction, 'description' => 'Mức tối đa giảm trừ quỹ hưu trí tự nguyện']
        );

        return redirect()->route('admin.tax_settings')->with('success', 'Cấu hình thuế đã được cập nhật thành công!');
    }

    /**
     * Hiển thị trang lịch sử tính thuế của người dùng với bộ lọc.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showTaxHistory(Request $request): \Illuminate\View\View|\Illuminate\Http\RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để xem lịch sử.');
        }

        $query = Auth::user()->taxCalculations()->orderByDesc('created_at');

        // Lấy tham số lọc từ request
        $filterYear = $request->input('year');
        $filterMonth = $request->input('month');

        // Áp dụng bộ lọc năm
        if ($filterYear) {
            $query->whereYear('created_at', $filterYear);
        }

        // Áp dụng bộ lọc tháng
        if ($filterMonth) {
            $query->whereMonth('created_at', $filterMonth);
        }

        // Lấy lịch sử tính toán đã được lọc và phân trang
        $calculations = $query->paginate(10);

        // Truyền các tham số lọc trở lại view để giữ giá trị selected trong dropdown
        return view('calculator.history', compact('calculations'));
    }

    /**
     * Hiển thị trang chi tiết của một bản ghi tính thuế cụ thể.
     *
     * @param \App\Models\TaxCalculation $calculation Đối tượng TaxCalculation cần hiển thị (sử dụng Route Model Binding).
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showTaxCalculationDetail(TaxCalculation $calculation): \Illuminate\View\View|\Illuminate\Http\RedirectResponse
    {
        // Kiểm tra quyền: Đảm bảo chỉ người dùng sở hữu bản ghi hoặc admin mới có thể xem.
        if (!Auth::check() || Auth::id() !== $calculation->user_id) {
            // Nếu người dùng không phải chủ sở hữu và không phải admin, từ chối truy cập.
            if (!Auth::user()->is_admin) { // Giả định bạn có cột 'is_admin' trong bảng users
                abort(403, 'Bạn không có quyền xem chi tiết bản ghi này.');
            }
        }

        return view('calculator.detail', compact('calculation'));
    }


    /**
     * Xuất lịch sử tính thuế của người dùng ra file Excel.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\RedirectResponse
     */
    public function exportExcel(): \Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Bạn cần đăng nhập để xuất dữ liệu.');
        }

        $userId = Auth::id();
        $userName = Auth::user()->name ?? 'Người_dùng'; // Lấy tên người dùng
        $fileName = 'lich_su_tinh_thue_' . $userName . '_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new TaxCalculationsExport($userId), $fileName);
    }

    /**
     * Xuất BÁO CÁO TỔNG HỢP tất cả lịch sử tính thuế của người dùng ra file PDF.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function exportPdfAll(): \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Bạn cần đăng nhập để xuất dữ liệu.');
        }

        $user = Auth::user();
        // Lấy TẤT CẢ các bản ghi lịch sử của người dùng
        $calculations = $user->taxCalculations()->orderByDesc('created_at')->get();

        // Kiểm tra nếu không có bản ghi nào để xuất
        if ($calculations->isEmpty()) {
            return redirect()->back()->with('error', 'Không có dữ liệu lịch sử tính thuế để xuất PDF.');
        }

        // Tải view HTML với TẤT CẢ các bản ghi
        // Chúng ta sẽ cần điều chỉnh lại view pdfs/tax_calculation_report.blade.php để xử lý collection các bản ghi
        $pdf = Pdf::loadView('pdfs.tax_calculation_report_all', compact('calculations', 'user')); // Đặt tên view mới là tax_calculation_report_all
        $pdf->setPaper('A4', 'portrait');

        $userName = $user->name ?? 'Người_dùng';
        $fileName = 'lich_su_tinh_thue_tong_hop_' . $userName . '_' . now()->format('Ymd_His') . '.pdf';

        return $pdf->download($fileName);
    }

    
    /**
     * Xóa một bản ghi lịch sử tính thuế.
     *
     * @param \App\Models\TaxCalculation $calculation Đối tượng TaxCalculation cần xóa (sử dụng Route Model Binding).
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteTaxCalculation(TaxCalculation $calculation): \Illuminate\Http\RedirectResponse
    {
        // Kiểm tra quyền: Đảm bảo chỉ người dùng sở hữu bản ghi hoặc admin mới có thể xóa.
        // Bạn có thể thêm middleware 'admin' cho route này nếu chỉ admin được xóa.
        // Hoặc kiểm tra chi tiết quyền ở đây.
        if (!Auth::check() || Auth::id() !== $calculation->user_id) {
            // Nếu người dùng không phải chủ sở hữu, từ chối truy cập.
            // Có thể mở rộng để cho phép admin xóa bản ghi của người khác nếu cần.
            if (!Auth::user()->is_admin) { // Giả định bạn có cột 'is_admin' trong bảng users
                abort(403, 'Bạn không có quyền xóa bản ghi này.');
            }
        }

        try {
            $calculation->delete();
            return redirect()->route('tax.history')->with('success', 'Bản ghi lịch sử đã được xóa thành công.');
        } catch (\Exception $e) {
            // Xử lý lỗi nếu việc xóa không thành công
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa bản ghi: ' . $e->getMessage());
        }
    }

        /**
     * Hiển thị trang tải lên file Excel để nhập liệu hàng loạt.
     *
     * @return \Illuminate\View\View
     */
    public function showImportForm(): \Illuminate\View\View
    {
        return view('calculator.import');
    }

    /**
     * Xử lý file Excel được tải lên và nhập dữ liệu tính thuế.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processImport(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx|max:10240', // Max 10MB
        ], [
            'excel_file.required' => 'Vui lòng chọn một file Excel.',
            'excel_file.file' => 'File tải lên không hợp lệ.',
            'excel_file.mimes' => 'File phải có định dạng .xlsx.',
            'excel_file.max' => 'Kích thước file không được vượt quá 10MB.',
        ]);

        $file = $request->file('excel_file');
        $import = new TaxCalculationsImport();

        try {
            DB::beginTransaction(); // Bắt đầu transaction

            Excel::import($import, $file);

            // Kiểm tra các lỗi xác thực hoặc lỗi khác trong quá trình import
            if ($import->getErrors()) {
                DB::rollBack(); // Rollback nếu có lỗi
                return redirect()->back()->withInput()->with('error', 'Có lỗi xảy ra trong quá trình nhập liệu. Vui lòng kiểm tra file Excel và thử lại.')->with('errors_import', $import->getErrors());
            }

            DB::commit(); // Commit transaction nếu tất cả thành công

            return redirect()->route('tax.history')->with('success', 'Dữ liệu tính thuế đã được nhập liệu thành công từ file Excel!');

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            DB::rollBack(); // Rollback nếu có lỗi xác thực
            $failures = $e->failures();
            $errors = [];
            foreach ($failures as $failure) {
                $errors[] = [
                    'row' => $failure->row(),
                    'message' => implode(', ', $failure->errors()),
                ];
            }
            return redirect()->back()->withInput()->with('error', 'Có lỗi xác thực dữ liệu trong file Excel.')->with('errors_import', $errors);
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback nếu có lỗi khác
            // Log lỗi để debug
            \Log::error('Lỗi nhập Excel: ' . $e->getMessage() . ' Dòng: ' . $e->getLine() . ' File: ' . $e->getFile());
            return redirect()->back()->withInput()->with('error', 'Đã xảy ra lỗi không mong muốn trong quá trình nhập liệu: ' . $e->getMessage());
        }
    }
}