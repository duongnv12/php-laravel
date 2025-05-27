<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth; // Import Auth facade
use Illuminate\Http\Request; // Import Request class

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'old_data',
        'new_data',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'old_data' => 'array',
        'new_data' => 'array',
    ];

    /**
     * Định nghĩa mối quan hệ với User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Phương thức tĩnh để ghi log hoạt động.
     *
     * @param string $action Hành động được thực hiện (e.g., 'created', 'updated', 'deleted')
     * @param \Illuminate\Database\Eloquent\Model|null $model Bản ghi bị ảnh hưởng (User, TaxBracket, etc.)
     * @param array $oldData Dữ liệu cũ (chỉ cho updated)
     * @param array $newData Dữ liệu mới (cho created/updated)
     * @return void
     */
    public static function logActivity(string $action, ?Model $model = null, array $oldData = [], array $newData = [])
    {
        $request = request(); // Lấy instance của Request hiện tại

        static::create([
            'user_id' => Auth::id(), // ID của người dùng đang đăng nhập
            'action' => $action,
            'model_type' => $model ? get_class($model) : null,
            'model_id' => $model ? $model->id : null,
            'old_data' => !empty($oldData) ? $oldData : null,
            'new_data' => !empty($newData) ? $newData : null,
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
        ]);
    }
}