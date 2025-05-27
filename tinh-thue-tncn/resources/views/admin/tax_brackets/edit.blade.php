<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6 text-center text-gray-800">Chỉnh sửa Bậc thuế</h3>

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

                    <form action="{{ route('admin.tax_brackets.update', $taxBracket->id) }}" method="POST" class="max-w-lg mx-auto p-6 bg-gray-50 rounded-lg shadow-md">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="order" class="block text-sm font-medium text-gray-700">Thứ tự <span class="text-red-500">*</span></label>
                            <input type="number" name="order" id="order" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('order', $taxBracket->order) }}" required>
                        </div>
                        <div class="mb-4">
                            <label for="min_income" class="block text-sm font-medium text-gray-700">Mức tối thiểu (VNĐ) <span class="text-red-500">*</span></label>
                            <input type="number" name="min_income" id="min_income" step="any" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('min_income', $taxBracket->min_income) }}" required>
                        </div>
                        <div class="mb-4">
                            <label for="max_income" class="block text-sm font-medium text-gray-700">Mức tối đa (VNĐ) <span class="text-gray-500">(Để trống cho bậc cuối cùng)</span></label>
                            <input type="number" name="max_income" id="max_income" step="any" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('max_income', $taxBracket->max_income) }}">
                        </div>
                        <div class="mb-4">
                            <label for="tax_rate" class="block text-sm font-medium text-gray-700">Thuế suất (%) <span class="text-red-500">*</span></label>
                            <input type="number" name="tax_rate" id="tax_rate" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('tax_rate', $taxBracket->tax_rate * 100) }}" required>
                            <p class="mt-1 text-sm text-gray-500">Nhập phần trăm (ví dụ: 5 cho 5%, 10.5 cho 10.5%).</p>
                        </div>
                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.tax_brackets.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Hủy</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Cập nhật
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>