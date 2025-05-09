<?php

namespace App\Services;

use App\Models\Progress;

class ProgressService
{
    /**
     * Cập nhật trạng thái tiến độ dựa trên điểm số.
     * Nếu score không null và >= 5, trạng thái là 'completed'; ngược lại là 'pending'.
     * Sử dụng saveQuietly() để tránh vòng lặp lặp lại observer.
     */
    public function updateStatus(Progress $progress)
    {
        $expectedStatus = ($progress->score !== null && $progress->score >= 5) ? 'completed' : 'pending';

        if ($progress->status !== $expectedStatus) {
            $progress->status = $expectedStatus;
            // Sử dụng saveQuietly thay vì save nhằm tránh kích hoạt lại observer
            $progress->saveQuietly();
        }
    }
}
