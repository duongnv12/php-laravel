<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6 text-center text-blue-700">Nhập liệu Thuế TNCN hàng loạt</h3>

                    <p class="mb-6 text-center text-gray-600">Sử dụng chức năng này để tải lên một file Excel chứa dữ liệu thu nhập và giảm trừ của bạn để tính thuế hàng loạt.</p>

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
                            @if (session('errors_import'))
                                <ul class="mt-3 list-disc list-inside text-sm">
                                    @foreach (session('errors_import') as $error)
                                        <li>Dòng {{ $error['row'] }}: {{ $error['message'] }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Lỗi xác thực!</strong>
                            <ul class="mt-3 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="max-w-xl mx-auto bg-gray-50 p-8 rounded-lg shadow-md">
                        <form action="{{ route('tax.import.process') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-6">
                                <label for="excel_file" class="block text-sm font-medium text-gray-700 mb-2">Chọn file Excel (.xlsx):</label>
                                <input type="file" name="excel_file" id="excel_file" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-white focus:outline-none focus:border-indigo-500 focus:ring-indigo-500" required>
                                <p class="mt-2 text-sm text-gray-500">Chỉ chấp nhận file Excel có định dạng `.xlsx`.</p>
                            </div>

                            <div class="mb-6">
                                <h4 class="text-md font-semibold text-gray-700 mb-2">Định dạng file Excel mẫu:</h4>
                                <p class="text-sm text-gray-600 mb-2">File Excel của bạn cần có các cột sau (theo đúng thứ tự):</p>
                                <ul class="list-disc list-inside text-sm text-gray-600">
                                    <li>total_income (Tổng thu nhập chịu thuế)</li>
                                    <li>social_insurance_contribution (Bảo hiểm bắt buộc)</li>
                                    <li>number_of_dependents (Số người phụ thuộc)</li>
                                    <li>charitable_contributions (Đóng góp từ thiện)</li>
                                    <li>retirement_fund_contributions (Quỹ hưu trí tự nguyện)</li>
                                </ul>
                                <p class="mt-2 text-sm text-gray-600">Bạn có thể tải về file mẫu để tham khảo:</p>
                                <a href="{{ asset('excel_templates/tax_import_template.xlsx') }}" download class="inline-flex items-center px-4 py-2 bg-gray-200 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition ease-in-out duration-150 mt-2">
                                    Tải file Excel mẫu
                                </a>
                                {{-- Tạo thư mục public/excel_templates và đặt file tax_import_template.xlsx vào đó --}}
                            </div>

                            <div class="flex items-center justify-center">
                                <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Tải lên và Tính thuế
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>