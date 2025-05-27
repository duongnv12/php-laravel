<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6 text-center text-gray-800">Chào mừng đến với Bảng điều khiển Quản trị!</h3>
                    <p class="mb-8 text-center text-gray-600">Tại đây, bạn có thể quản lý các cài đặt quan trọng của hệ thống tính thuế.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg shadow-md p-6 flex flex-col justify-between">
                            <div>
                                <h4 class="text-xl font-semibold text-blue-800 mb-2">Cài đặt Giảm trừ</h4>
                                <p class="text-gray-700 text-sm">Quản lý các mức giảm trừ cơ bản như giảm trừ bản thân, người phụ thuộc và quỹ hưu trí.</p>
                            </div>
                            <div class="mt-4 text-right">
                                <a href="{{ route('admin.tax_settings') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 text-sm">
                                    Đi tới cài đặt
                                </a>
                            </div>
                        </div>

                        <div class="bg-green-50 border border-green-200 rounded-lg shadow-md p-6 flex flex-col justify-between">
                            <div>
                                <h4 class="text-xl font-semibold text-green-800 mb-2">Quản lý Bậc thuế</h4>
                                <p class="text-gray-700 text-sm">Cấu hình và cập nhật các bậc thuế lũy tiến theo quy định hiện hành.</p>
                            </div>
                            <div class="mt-4 text-right">
                                <a href="{{ route('admin.tax_brackets.index') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 text-sm">
                                    Quản lý bậc thuế
                                </a>
                            </div>
                        </div>

                        <div class="bg-purple-50 border border-purple-200 rounded-lg shadow-md p-6 flex flex-col justify-between">
                            <div>
                                <h4 class="text-xl font-semibold text-purple-800 mb-2">Báo cáo & Thống kê</h4>
                                <p class="text-gray-700 text-sm">Xem các báo cáo tổng hợp về lịch sử tính thuế của người dùng.</p>
                            </div>
                            <div class="mt-4 text-right">
                                <a href="{{ route('tax.history') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150 text-sm">
                                    Xem báo cáo
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>