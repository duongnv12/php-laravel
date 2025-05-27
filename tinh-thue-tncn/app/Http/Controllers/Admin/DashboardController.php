<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TaxBracket;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    /**
     * Hiển thị trang dashboard cho admin.
     */
    public function index()
    {
        // Tổng số người dùng
        $totalUsers = User::count();

        // Số người dùng thường (giả sử có cột 'role' hoặc 'is_admin')
        $regularUsers = User::where(function ($q) {
            if (Schema::hasColumn('users', 'role')) {
                $q->where('role', 'user');
            } elseif (Schema::hasColumn('users', 'is_admin')) {
                $q->where('is_admin', false);
            }
        })->count();

        // Tổng số bậc thuế
        $totalTaxBrackets = TaxBracket::count();

        // Tổng số lần tính thuế (nếu có bảng tax_histories)
        $totalCalculations = 0;
        $latestTaxCalculations = [];
        if (class_exists(\App\Models\TaxHistory::class)) {
            $totalCalculations = \App\Models\TaxHistory::count();
            $latestTaxCalculations = \App\Models\TaxHistory::with('user')
                ->orderByDesc('created_at')
                ->limit(5)
                ->get();
        }

        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'regularUsers' => $regularUsers,
            'totalTaxBrackets' => $totalTaxBrackets,
            'totalCalculations' => $totalCalculations,
            'latestTaxCalculations' => $latestTaxCalculations,
        ]);
    }
}