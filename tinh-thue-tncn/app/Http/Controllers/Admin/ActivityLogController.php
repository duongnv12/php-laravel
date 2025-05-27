<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        // Hiển thị trang nhật ký hoạt động (có thể trả về view trống hoặc dữ liệu mẫu)
        return view('admin.activity_logs.index');
    }
}