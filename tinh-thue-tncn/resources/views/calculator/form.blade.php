<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6 text-center text-blue-700">Nhập thông tin để tính thuế của bạn</h3>

                    @if ($errors->any())
                        <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                            <strong class="font-bold">Có lỗi xảy ra!</strong> Vui lòng kiểm tra lại các thông tin bạn đã nhập:
                            <ul class="mt-1 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('tax.calculate') }}">
                        @csrf

                        <div class="mb-5">
                            <x-input-label for="total_income" :value="__('Tổng thu nhập (trước thuế, VNĐ/tháng):')" />
                            <x-text-input id="total_income" class="block mt-1 w-full" type="number" step="any" name="total_income" :value="old('total_income')" required autofocus autocomplete="total_income" placeholder="Ví dụ: 15,000,000" />
                            <x-input-error :messages="$errors->get('total_income')" class="mt-2" />
                            <p class="text-sm text-gray-500 mt-1">Là tổng số tiền lương, tiền công và các khoản thu nhập chịu thuế khác.</p>
                        </div>

                        <div class="mb-5">
                            <x-input-label for="social_insurance_contribution" :value="__('Khoản đóng Bảo hiểm bắt buộc (VNĐ/tháng):')" />
                            <x-text-input id="social_insurance_contribution" class="block mt-1 w-full" type="number" step="any" name="social_insurance_contribution" :value="old('social_insurance_contribution', 0)" autocomplete="social_insurance_contribution" placeholder="Ví dụ: 1,050,000 (8% BHXH, 1.5% BHYT, 1% BHTN)" />
                            <x-input-error :messages="$errors->get('social_insurance_contribution')" class="mt-2" />
                            <p class="text-sm text-gray-500 mt-1">Bao gồm BHXH, BHYT, BHTN theo quy định (thường là 10.5% của lương đóng BHXH).</p>
                        </div>

                        <div class="mb-5">
                            <x-input-label for="number_of_dependents" :value="__('Số người phụ thuộc:')" />
                            <x-text-input id="number_of_dependents" class="block mt-1 w-full" type="number" name="number_of_dependents" :value="old('number_of_dependents', 0)" min="0" autocomplete="number_of_dependents" placeholder="Ví dụ: 1 người" />
                            <x-input-error :messages="$errors->get('number_of_dependents')" class="mt-2" />
                            <p class="text-sm text-gray-500 mt-1">Là số người bạn đang nuôi dưỡng và được pháp luật công nhận.</p>
                        </div>

                        <hr class="my-8 border-t border-gray-300 opacity-50" />

                        <h4 class="text-xl font-bold mb-4 mt-6 text-gray-700">Các khoản giảm trừ khác (nếu có):</h4>

                        <div class="mb-5">
                            <x-input-label for="charitable_contributions" :value="__('Khoản đóng góp từ thiện, nhân đạo, khuyến học (VNĐ/tháng):')" />
                            <x-text-input id="charitable_contributions" class="block mt-1 w-full" type="number" step="any" name="charitable_contributions" :value="old('charitable_contributions', 0)" min="0" placeholder="Ví dụ: 500,000" />
                            <x-input-error :messages="$errors->get('charitable_contributions')" class="mt-2" />
                            <p class="text-sm text-gray-500 mt-1">Là các khoản đóng góp cho các tổ chức, quỹ từ thiện, nhân đạo, khuyến học được thành lập hợp pháp. Cần có chứng từ xác nhận.</p>
                        </div>

                        <div class="mb-5">
                            <x-input-label for="retirement_fund_contributions" :value="__('Khoản đóng quỹ hưu trí tự nguyện (VNĐ/tháng):')" />
                            <x-text-input id="retirement_fund_contributions" class="block mt-1 w-full" type="number" step="any" name="retirement_fund_contributions" :value="old('retirement_fund_contributions', 0)" min="0" placeholder="Ví dụ: 2,000,000" />
                            <x-input-error :messages="$errors->get('retirement_fund_contributions')" class="mt-2" />
                            <p class="text-sm text-gray-500 mt-1">Tổng mức đóng góp được trừ không quá 1 triệu đồng/tháng/người (áp dụng từ 01/07/2013). Cần có chứng từ.</p>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button class="ms-3">
                                {{ __('Tính Thuế') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>