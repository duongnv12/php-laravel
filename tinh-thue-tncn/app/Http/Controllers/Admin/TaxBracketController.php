<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TaxBracket; // Import Model
use Illuminate\Validation\Rule;

class TaxBracketController extends Controller
{
    /**
     * Hiển thị danh sách các bậc thuế.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $taxBrackets = TaxBracket::orderBy('order')->get();
        return view('admin.tax_brackets.index', compact('taxBrackets'));
    }

    /**
     * Hiển thị form để tạo bậc thuế mới.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.tax_brackets.create');
    }

    /**
     * Lưu bậc thuế mới vào database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'min_income' => 'required|numeric|min:0',
            'max_income' => 'nullable|numeric|gt:min_income', // max_income phải lớn hơn min_income
            'tax_rate' => 'required|numeric|min:0.01|max:100', // Thuế suất từ 0.01% đến 100%
            'order' => 'required|integer|min:1|unique:tax_brackets,order', // Order phải duy nhất
        ], [
            'min_income.required' => 'Mức thu nhập tối thiểu không được để trống.',
            'min_income.numeric' => 'Mức thu nhập tối thiểu phải là số.',
            'min_income.min' => 'Mức thu nhập tối thiểu không được nhỏ hơn 0.',
            'max_income.numeric' => 'Mức thu nhập tối đa phải là số.',
            'max_income.gt' => 'Mức thu nhập tối đa phải lớn hơn mức tối thiểu.',
            'tax_rate.required' => 'Thuế suất không được để trống.',
            'tax_rate.numeric' => 'Thuế suất phải là số.',
            'tax_rate.min' => 'Thuế suất phải lớn hơn 0.',
            'tax_rate.max' => 'Thuế suất không được lớn hơn 100.',
            'order.required' => 'Thứ tự không được để trống.',
            'order.integer' => 'Thứ tự phải là số nguyên.',
            'order.min' => 'Thứ tự phải lớn hơn hoặc bằng 1.',
            'order.unique' => 'Thứ tự này đã tồn tại. Vui lòng chọn thứ tự khác.',
        ]);

        TaxBracket::create($request->all());

        return redirect()->route('admin.tax_brackets.index')->with('success', 'Bậc thuế đã được thêm thành công.');
    }

    /**
     * Hiển thị form để chỉnh sửa bậc thuế.
     *
     * @param  \App\Models\TaxBracket  $taxBracket
     * @return \Illuminate\View\View
     */
    public function edit(TaxBracket $taxBracket)
    {
        return view('admin.tax_brackets.edit', compact('taxBracket'));
    }

    /**
     * Cập nhật bậc thuế trong database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TaxBracket  $taxBracket
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, TaxBracket $taxBracket)
    {
        $request->validate([
            'min_income' => 'required|numeric|min:0',
            'max_income' => [
                'nullable',
                'numeric',
                'gt:min_income',
                // Tùy chỉnh validation cho bậc cuối cùng (max_income = null)
                Rule::when(is_null($request->max_income), [
                    function ($attribute, $value, $fail) use ($taxBracket) {
                        // Đảm bảo chỉ có một bậc cuối cùng (max_income = null)
                        $existingNullMax = TaxBracket::whereNull('max_income')
                                                     ->where('id', '!=', $taxBracket->id)
                                                     ->exists();
                        if ($existingNullMax) {
                            $fail('Chỉ có thể có một bậc thuế không có giới hạn tối đa.');
                        }
                    }
                ]),
            ],
            'tax_rate' => 'required|numeric|min:0.01|max:100',
            'order' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('tax_brackets', 'order')->ignore($taxBracket->id),
            ],
        ], [
            // Các thông báo lỗi tương tự như trên
            'min_income.required' => 'Mức thu nhập tối thiểu không được để trống.',
            'min_income.numeric' => 'Mức thu nhập tối thiểu phải là số.',
            'min_income.min' => 'Mức thu nhập tối thiểu không được nhỏ hơn 0.',
            'max_income.numeric' => 'Mức thu nhập tối đa phải là số.',
            'max_income.gt' => 'Mức thu nhập tối đa phải lớn hơn mức tối thiểu.',
            'tax_rate.required' => 'Thuế suất không được để trống.',
            'tax_rate.numeric' => 'Thuế suất phải là số.',
            'tax_rate.min' => 'Thuế suất phải lớn hơn 0.',
            'tax_rate.max' => 'Thuế suất không được lớn hơn 100.',
            'order.required' => 'Thứ tự không được để trống.',
            'order.integer' => 'Thứ tự phải là số nguyên.',
            'order.min' => 'Thứ tự phải lớn hơn hoặc bằng 1.',
            'order.unique' => 'Thứ tự này đã tồn tại. Vui lòng chọn thứ tự khác.',
        ]);

        $taxBracket->update($request->all());

        return redirect()->route('admin.tax_brackets.index')->with('success', 'Bậc thuế đã được cập nhật thành công.');
    }

    /**
     * Xóa bậc thuế khỏi database.
     *
     * @param  \App\Models\TaxBracket  $taxBracket
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(TaxBracket $taxBracket)
    {
        $taxBracket->delete();
        return redirect()->route('admin.tax_brackets.index')->with('success', 'Bậc thuế đã được xóa thành công.');
    }
}