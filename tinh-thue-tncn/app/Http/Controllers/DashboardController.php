<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TaxCalculation; // Đảm bảo import model TaxCalculation
use Carbon\Carbon; // Thêm thư viện Carbon để xử lý ngày tháng

class DashboardController extends Controller
{
    /**
     * Hiển thị trang tổng quan (Dashboard) với các số liệu thống kê.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để xem trang tổng quan.');
        }

        $user = Auth::user();

        // 1. Thống kê chung
        $totalCalculations = $user->taxCalculations()->count();
        $totalIncome = $user->taxCalculations()->sum('total_income');
        $totalTaxPaid = $user->taxCalculations()->sum('final_tax_amount');

        // 2. Dữ liệu cho biểu đồ xu hướng (ví dụ: theo tháng trong 12 tháng gần nhất)
        // Lấy dữ liệu 12 tháng gần nhất (bao gồm cả tháng hiện tại)
        $monthlyData = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $year = $month->year;
            $monthNum = $month->month;
            $monthName = $month->isoFormat('MM/YYYY'); // Định dạng tháng/năm cho label

            $data = $user->taxCalculations()
                         ->whereYear('created_at', $year)
                         ->whereMonth('created_at', $monthNum)
                         ->selectRaw('SUM(total_income) as total_income, SUM(final_tax_amount) as total_tax')
                         ->first();

            $monthlyData[] = [
                'label' => $monthName,
                'total_income' => (float)($data->total_income ?? 0),
                'total_tax' => (float)($data->total_tax ?? 0)
            ];
        }

        return view('dashboard', compact('totalCalculations', 'totalIncome', 'totalTaxPaid', 'monthlyData'));
    }
}