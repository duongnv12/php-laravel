<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6 text-center text-blue-800">Chào mừng bạn đến với Trang tổng quan!</h3>

                    <p class="mb-8 text-center text-gray-600">Tại đây, bạn có thể xem lại tổng quan về các hoạt động tính thuế của mình.</p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        {{-- Tổng số lần tính thuế --}}
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-5 text-center shadow-sm">
                            <p class="text-sm font-medium text-blue-700 uppercase">Tổng số lần tính thuế</p>
                            <p class="text-4xl font-bold text-blue-800 mt-2">{{ number_format($totalCalculations, 0, ',', '.') }}</p>
                            <p class="text-sm text-gray-500 mt-2">lần</p>
                        </div>

                        {{-- Tổng thu nhập đã nhập --}}
                        <div class="bg-green-50 border border-green-200 rounded-lg p-5 text-center shadow-sm">
                            <p class="text-sm font-medium text-green-700 uppercase">Tổng thu nhập đã nhập</p>
                            <p class="text-4xl font-bold text-green-800 mt-2">{{ number_format($totalIncome, 0, ',', '.') }}</p>
                            <p class="text-sm text-gray-500 mt-2">VNĐ</p>
                        </div>

                        {{-- Tổng số thuế đã nộp --}}
                        <div class="bg-red-50 border border-red-200 rounded-lg p-5 text-center shadow-sm">
                            <p class="text-sm font-medium text-red-700 uppercase">Tổng thuế TNCN đã nộp</p>
                            <p class="text-4xl font-bold text-red-800 mt-2">{{ number_format($totalTaxPaid, 0, ',', '.') }}</p>
                            <p class="text-sm text-gray-500 mt-2">VNĐ</p>
                        </div>
                    </div>

                    {{-- Khu vực biểu đồ --}}
                    <div class="mt-10">
                        <h2 class="text-xl font-semibold mb-4 text-gray-800 text-center">Xu hướng Thu nhập và Thuế (12 tháng gần nhất)</h2>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-5 shadow-sm">
                            <canvas id="taxChart" class="w-full"></canvas>
                        </div>
                    </div>

                    {{-- Các nút điều hướng nhanh --}}
                    <div class="mt-10 flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                        <a href="{{ route('tax.form') }}" class="inline-flex items-center justify-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Tính Thuế TNCN mới
                        </a>
                        <a href="{{ route('tax.history') }}" class="inline-flex items-center justify-center px-6 py-3 bg-gray-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Xem Lịch sử Tính Thuế
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Lấy dữ liệu từ Laravel Controller
            const monthlyData = @json($monthlyData);

            // Chuẩn bị dữ liệu cho Chart.js
            const labels = monthlyData.map(data => data.label);
            const totalIncomes = monthlyData.map(data => data.total_income);
            const totalTaxes = monthlyData.map(data => data.total_tax);

            const ctx = document.getElementById('taxChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar', // Hoặc 'line' tùy theo sở thích
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Tổng thu nhập (VNĐ)',
                            data: totalIncomes,
                            backgroundColor: 'rgba(75, 192, 192, 0.6)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1,
                            yAxisID: 'y'
                        },
                        {
                            label: 'Tổng thuế TNCN (VNĐ)',
                            data: totalTaxes,
                            backgroundColor: 'rgba(255, 99, 132, 0.6)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1,
                            yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Để biểu đồ tự điều chỉnh kích thước theo container
                    scales: {
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Thu nhập'
                            },
                            beginAtZero: true
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            title: {
                                display: true,
                                text: 'Thuế phải nộp'
                            },
                            grid: {
                                drawOnChartArea: false // Chỉ vẽ grid cho trục y bên trái
                            },
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>