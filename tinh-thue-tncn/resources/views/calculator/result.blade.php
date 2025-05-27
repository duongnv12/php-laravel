<x-app-layout>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6 text-center text-green-700">Kết quả tính toán Thuế Thu Nhập Cá Nhân của bạn</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8 p-4 bg-gray-50 rounded-lg shadow-inner">
                        <div>
                            <p class="text-gray-700 mb-1"><strong>Tổng thu nhập:</strong></p>
                            <p class="text-xl font-semibold text-blue-600">{{ number_format($totalIncome, 0, ',', '.') }} VNĐ</p>
                        </div>
                        <div>
                            <p class="text-gray-700 mb-1"><strong>Khoản đóng BHXH/BHYT/BHTN:</strong></p>
                            <p class="text-xl font-semibold text-blue-600">{{ number_format($socialInsurance, 0, ',', '.') }} VNĐ</p>
                        </div>
                        <div>
                            <p class="text-gray-700 mb-1"><strong>Số người phụ thuộc:</strong></p>
                            <p class="text-xl font-semibold text-blue-600">{{ $numberOfDependents }} người</p>
                        </div>
                        {{-- Thêm các khoản giảm trừ mới --}}
                        <div>
                            <p class="text-gray-700 mb-1"><strong>Giảm trừ bản thân:</strong></p>
                            <p class="text-xl font-semibold text-red-600">{{ number_format($personalDeductionAmount, 0, ',', '.') }} VNĐ</p>
                        </div>
                        <div>
                            <p class="text-gray-700 mb-1"><strong>Giảm trừ người phụ thuộc:</strong></p>
                            <p class="text-xl font-semibold text-red-600">{{ number_format($dependentDeductionAmount, 0, ',', '.') }} VNĐ</p>
                        </div>
                        @if ($charitableContributions > 0)
                        <div>
                            <p class="text-gray-700 mb-1"><strong>Đóng góp từ thiện, nhân đạo:</strong></p>
                            <p class="text-xl font-semibold text-red-600">{{ number_format($charitableContributions, 0, ',', '.') }} VNĐ</p>
                        </div>
                        @endif
                        @if ($retirementFundContributions > 0)
                        <div>
                            <p class="text-gray-700 mb-1"><strong>Đóng quỹ hưu trí tự nguyện (được trừ):</strong></p>
                            <p class="text-xl font-semibold text-red-600">{{ number_format(min($retirementFundContributions, \App\Http\Controllers\TaxCalculatorController::MAX_RETIREMENT_FUND_DEDUCTION), 0, ',', '.') }} VNĐ</p>
                        </div>
                        @endif
                        {{-- Kết thúc các khoản giảm trừ mới --}}
                        <div class="col-span-1 md:col-span-2 border-t pt-4 mt-4 border-gray-300">
                            <p class="text-gray-700 mb-1"><strong>Tổng các khoản giảm trừ:</strong></p>
                            <p class="text-2xl font-bold text-red-700">{{ number_format($totalDeductions, 0, ',', '.') }} VNĐ</p>
                        </div>
                    </div>

                    <div class="text-center mb-8 p-6 bg-blue-100 rounded-lg shadow-md">
                        <p class="text-gray-800 mb-2 text-lg">Thu nhập tính thuế của bạn là:</p>
                        <p class="text-4xl font-extrabold text-blue-800">{{ number_format($taxableIncome, 0, ',', '.') }} VNĐ</p>
                    </div>

                    <div class="text-center p-6 bg-green-100 rounded-lg shadow-md border-2 border-green-500">
                        <p class="text-gray-800 mb-3 text-2xl font-semibold">Tổng số thuế TNCN phải nộp:</p>
                        <p class="text-5xl font-extrabold text-green-800">{{ number_format($finalTaxAmount, 0, ',', '.') }} VNĐ</p>
                        <p class="text-base text-gray-600 mt-2">*(Số thuế này được tính theo biểu thuế lũy tiến từng phần hiện hành)*</p>
                    </div>

                    <div class="text-center mt-8">
                        <a href="{{ route('tax.form') }}" class="inline-flex items-center px-6 py-3 bg-gray-800 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Tính lại') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>