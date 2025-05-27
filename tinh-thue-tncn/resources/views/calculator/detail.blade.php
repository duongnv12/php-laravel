<x-app-layout>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6 text-center text-blue-700">Chi tiết Tính Thuế TNCN</h3>

                    <div class="border border-gray-200 rounded-lg p-6 shadow-md">
                        <h2 class="text-xl font-semibold mb-4 text-gray-700">Thông tin chung</h2>
                        <p class="mb-2"><strong class="text-gray-800">Người tính:</strong> {{ $calculation->user->name ?? 'Người dùng không xác định' }}</p>
                        <p class="mb-4"><strong class="text-gray-800">Thời gian tính:</strong> {{ $calculation->created_at->format('d/m/Y H:i:s') }}</p>

                        <h2 class="text-xl font-semibold mt-6 mb-4 text-gray-700">I. THÔNG TIN ĐẦU VÀO</h2>
                        <div class="overflow-x-auto mb-6">
                            <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mục</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Giá trị</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr><td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700">Tổng thu nhập (trước thuế)</td><td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-blue-600">{{ number_format($calculation->total_income, 0, ',', '.') }} VNĐ</td></tr>
                                    <tr><td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700">Khoản đóng Bảo hiểm bắt buộc</td><td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-blue-600">{{ number_format($calculation->social_insurance_contribution, 0, ',', '.') }} VNĐ</td></tr>
                                    <tr><td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700">Số người phụ thuộc</td><td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-blue-600">{{ $calculation->number_of_dependents }} người</td></tr>
                                    <tr><td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700">Đóng góp từ thiện, nhân đạo, khuyến học</td><td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-blue-600">{{ number_format($calculation->charitable_contributions, 0, ',', '.') }} VNĐ</td></tr>
                                    <tr><td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700">Đóng quỹ hưu trí tự nguyện (người dùng nhập)</td><td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-blue-600">{{ number_format($calculation->retirement_fund_contributions, 0, ',', '.') }} VNĐ</td></tr>
                                </tbody>
                            </table>
                        </div>

                        <h2 class="text-xl font-semibold mt-6 mb-4 text-gray-700">II. CÁC KHOẢN GIẢM TRỪ</h2>
                        <div class="overflow-x-auto mb-6">
                            <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mục giảm trừ</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Số tiền giảm trừ</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr><td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700">Giảm trừ bản thân</td><td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-blue-600">{{ number_format($calculation->personal_deduction_amount, 0, ',', '.') }} VNĐ</td></tr>
                                    <tr><td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700">Giảm trừ người phụ thuộc ({{ $calculation->number_of_dependents }} người x {{ number_format($calculation->dependent_deduction_amount / ($calculation->number_of_dependents ?: 1), 0, ',', '.') }} VNĐ/người)</td><td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-blue-600">{{ number_format($calculation->dependent_deduction_amount, 0, ',', '.') }} VNĐ</td></tr>
                                    <tr><td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700">Khoản đóng Bảo hiểm bắt buộc</td><td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-blue-600">{{ number_format($calculation->social_insurance_contribution, 0, ',', '.') }} VNĐ</td></tr>
                                    <tr><td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700">Khoản đóng góp từ thiện, nhân đạo, khuyến học</td><td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-blue-600">{{ number_format($calculation->charitable_contributions, 0, ',', '.') }} VNĐ</td></tr>
                                    <tr><td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700">Khoản đóng quỹ hưu trí tự nguyện (tối đa được trừ)</td><td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-blue-600">{{ number_format($calculation->calculated_retirement_fund_deduction, 0, ',', '.') }} VNĐ</td></tr>
                                    <tr class="bg-gray-100">
                                        <td class="px-6 py-3 whitespace-nowrap text-sm font-semibold text-gray-800">TỔNG CÁC KHOẢN GIẢM TRỪ</td>
                                        <td class="px-6 py-3 whitespace-nowrap text-sm font-bold text-red-600">{{ number_format($calculation->total_deductions, 0, ',', '.') }} VNĐ</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="bg-blue-50 border-l-4 border-blue-400 text-blue-700 p-4 mb-6 rounded-md" role="alert">
                            <p class="font-bold">III. THU NHẬP TÍNH THUẾ</p>
                            <p class="mt-2 text-lg">Tổng thu nhập chịu thuế sau khi trừ các khoản giảm trừ:</p>
                            <p class="text-2xl font-bold text-blue-800">{{ number_format($calculation->taxable_income, 0, ',', '.') }} VNĐ</p>
                        </div>

                        <div class="bg-green-50 border-l-4 border-green-400 text-green-700 p-4 mb-6 rounded-md" role="alert">
                            <p class="font-bold">IV. SỐ THUẾ TNCN PHẢI NỘP</p>
                            <p class="mt-2 text-lg">Số thuế thu nhập cá nhân phải nộp theo biểu thuế lũy tiến từng phần:</p>
                            <p class="text-3xl font-bold text-green-800">{{ number_format($calculation->final_tax_amount, 0, ',', '.') }} VNĐ</p>
                        </div>

                        <div class="text-right mt-8">
                            <a href="{{ route('tax.history') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 transition ease-in-out duration-150">
                                Quay lại Lịch sử
                            </a>
                            {{-- Bạn có thể thêm nút xuất PDF chi tiết ở đây nếu muốn --}}
                            {{-- <a href="{{ route('tax.export.pdf', $calculation->id) }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Xuất PDF Chi tiết
                            </a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>