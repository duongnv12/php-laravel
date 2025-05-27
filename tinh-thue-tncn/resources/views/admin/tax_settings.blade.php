<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6 text-center text-gray-800">Cấu hình Mức Giảm trừ TNCN</h3>

                    {{-- Thông báo thành công/lỗi --}}
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Thành công!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Lỗi!</strong>
                            <ul class="mt-3 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.tax_settings.save') }}" method="POST" class="max-w-2xl mx-auto p-6 bg-gray-50 rounded-lg shadow-md">
                        @csrf

                        <div class="mb-5">
                            <label for="personal_deduction" class="block text-sm font-medium text-gray-700 mb-1">Mức giảm trừ bản thân (VNĐ):</label>
                            <input type="number" name="personal_deduction" id="personal_deduction"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                   value="{{ old('personal_deduction', $taxSetting->personal_deduction ?? 11000000) }}"
                                   required min="0" step="1000">
                            <p class="mt-1 text-xs text-gray-500">Ví dụ: 11000000 (11 triệu đồng)</p>
                            @error('personal_deduction')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <label for="dependent_deduction_per_person" class="block text-sm font-medium text-gray-700 mb-1">Mức giảm trừ cho mỗi người phụ thuộc (VNĐ):</label>
                            <input type="number" name="dependent_deduction_per_person" id="dependent_deduction_per_person"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                   value="{{ old('dependent_deduction_per_person', $taxSetting->dependent_deduction_per_person ?? 4400000) }}"
                                   required min="0" step="1000">
                            <p class="mt-1 text-xs text-gray-500">Ví dụ: 4400000 (4.4 triệu đồng)</p>
                            @error('dependent_deduction_per_person')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="max_retirement_fund_deduction" class="block text-sm font-medium text-gray-700 mb-1">Mức giảm trừ tối đa quỹ hưu trí tự nguyện (VNĐ/tháng):</label>
                            <input type="number" name="max_retirement_fund_deduction" id="max_retirement_fund_deduction"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                   value="{{ old('max_retirement_fund_deduction', $taxSetting->max_retirement_fund_deduction ?? 1000000) }}"
                                   required min="0" step="1000">
                            <p class="mt-1 text-xs text-gray-500">Ví dụ: 1000000 (1 triệu đồng)</p>
                            @error('max_retirement_fund_deduction')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Lưu Cài đặt
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>