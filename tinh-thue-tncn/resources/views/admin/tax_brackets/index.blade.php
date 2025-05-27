<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6 text-center text-gray-800">Quản lý Bậc thuế TNCN</h3>

                    {{-- Thông báo thành công/lỗi --}}
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Thành công!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Lỗi!</strong>
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="mb-4 flex justify-end">
                        <a href="{{ route('admin.tax_brackets.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Thêm bậc thuế mới
                        </a>
                    </div>

                    @if ($taxBrackets->isEmpty())
                        <p class="text-center text-gray-600 mt-8">Chưa có bậc thuế nào được cấu hình.</p>
                    @else
                        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3 px-6">Thứ tự</th>
                                        <th scope="col" class="py-3 px-6">Mức tối thiểu (VNĐ)</th>
                                        <th scope="col" class="py-3 px-6">Mức tối đa (VNĐ)</th>
                                        <th scope="col" class="py-3 px-6">Thuế suất (%)</th>
                                        <th scope="col" class="py-3 px-6 text-center">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($taxBrackets as $bracket)
                                        <tr class="bg-white border-b hover:bg-gray-50">
                                            <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                {{ $bracket->order }}
                                            </td>
                                            <td class="py-4 px-6">
                                                {{ number_format($bracket->min_income, 0, ',', '.') }}
                                            </td>
                                            <td class="py-4 px-6">
                                                @if (is_null($bracket->max_income))
                                                    Không giới hạn
                                                @else
                                                    {{ number_format($bracket->max_income, 0, ',', '.') }}
                                                @endif
                                            </td>
                                            <td class="py-4 px-6">
                                                {{ number_format($bracket->tax_rate * 100, 2, ',', '.') }}%
                                            </td>
                                            <td class="py-4 px-6 text-center">
                                                <a href="{{ route('admin.tax_brackets.edit', $bracket->id) }}" class="font-medium text-blue-600 hover:underline mr-3">Sửa</a>
                                                <form action="{{ route('admin.tax_brackets.destroy', $bracket->id) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bậc thuế này?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="font-medium text-red-600 hover:underline">Xóa</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>