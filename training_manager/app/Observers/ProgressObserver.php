<?php

namespace App\Observers;

use App\Models\Progress;
use App\Services\ProgressService;

class ProgressObserver
{
    /**
     * Khi model được lưu (saved) – tạo mới hoặc cập nhật.
     */
    public function saved(Progress $progress)
    {
        // Lấy instance của ProgressService và cập nhật trạng thái tiến độ
        app(ProgressService::class)->updateStatus($progress);
    }
    
    // Nếu muốn chỉ kích hoạt khi trường "score" thay đổi, có thể sử dụng method updated:
    // public function updated(Progress $progress)
    // {
    //     if($progress->isDirty('score')) {
    //         app(ProgressService::class)->updateStatus($progress);
    //     }
    // }
}
