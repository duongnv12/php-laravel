<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Báo cáo Tổng hợp Thuế TNCN</title>
    <style>
        /* Font và màu sắc cơ bản */
        body {
            font-family: 'DejaVu Sans', sans-serif; /* Hoặc 'Roboto' nếu bạn đã cài đặt */
            font-size: 11px; /* Font nhỏ hơn một chút cho báo cáo tổng hợp */
            line-height: 1.6;
            color: #333;
            margin: 20px;
            background-color: #f9f9f9;
        }

        /* Tiêu đề chung của báo cáo */
        .report-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #34495e;
            color: #2c3e50;
        }
        .report-header h1 {
            font-size: 26px;
            margin-bottom: 5px;
        }
        .report-header p {
            font-size: 14px;
            color: #666;
            margin: 3px 0;
        }

        /* Phần cho mỗi bản ghi tính toán */
        .calculation-item {
            margin-bottom: 30px;
            padding: 15px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            page-break-inside: avoid; /* Ngăn không cho bản ghi bị chia cắt giữa các trang */
        }
        .calculation-item h2 {
            font-size: 16px;
            color: #2980b9;
            margin-top: 0;
            margin-bottom: 10px;
            border-bottom: 1px dashed #c0d9eb;
            padding-bottom: 5px;
        }

        /* Bảng dữ liệu trong mỗi bản ghi */
        .calculation-item table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .calculation-item th, .calculation-item td {
            border: 1px solid #eee;
            padding: 8px 10px;
            text-align: left;
        }
        .calculation-item th {
            background-color: #f5f5f5;
            color: #555;
            font-weight: normal;
            font-size: 10px;
            text-transform: uppercase;
        }
        .calculation-item .value {
            font-weight: bold;
            color: #007bff;
        }
        .calculation-item .total-row td {
            background-color: #eaf6fa;
            font-weight: bold;
            color: #0d47a1;
        }
        .calculation-item .final-tax-row td {
            background-color: #ffebee;
            font-weight: bold;
            color: #c62828;
            font-size: 14px;
            text-align: right;
        }

        /* Chữ ký và thông tin cuối báo cáo */
        .footer {
            text-align: right;
            margin-top: 40px;
            font-style: italic;
            color: #777;
            font-size: 11px;
            border-top: 1px dashed #eee;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="report-header">
        <h1>BÁO CÁO TỔNG HỢP LỊCH SỬ TÍNH THUẾ TNCN</h1>
        <p>Người dùng: <strong>{{ $user->name ?? 'Người dùng không xác định' }}</strong></p>
        <p>Ngày xuất báo cáo: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

    @forelse($calculations as $index => $calculation)
        <div class="calculation-item">
            <h2>Lần tính toán #{{ $index + 1 }} - {{ $calculation->created_at->format('d/m/Y H:i:s') }}</h2>

            <h3>Thông tin đầu vào:</h3>
            <table>
                <tr><th>Mục</th><th>Giá trị</th></tr>
                <tr><td>Tổng thu nhập (trước thuế)</td><td><span class="value">{{ number_format($calculation->total_income, 0, ',', '.') }}</span> VNĐ</td></tr>
                <tr><td>Khoản đóng Bảo hiểm bắt buộc</td><td><span class="value">{{ number_format($calculation->social_insurance_contribution, 0, ',', '.') }}</span> VNĐ</td></tr>
                <tr><td>Số người phụ thuộc</td><td><span class="value">{{ $calculation->number_of_dependents }}</span> người</td></tr>
                <tr><td>Đóng góp từ thiện, nhân đạo, khuyến học</td><td><span class="value">{{ number_format($calculation->charitable_contributions, 0, ',', '.') }}</span> VNĐ</td></tr>
                <tr><td>Đóng quỹ hưu trí tự nguyện (người dùng nhập)</td><td><span class="value">{{ number_format($calculation->retirement_fund_contributions, 0, ',', '.') }}</span> VNĐ</td></tr>
            </table>

            <h3>Các khoản giảm trừ:</h3>
            <table>
                <tr><th>Mục giảm trừ</th><th>Số tiền giảm trừ</th></tr>
                <tr><td>Giảm trừ bản thân</td><td><span class="value">{{ number_format($calculation->personal_deduction_amount, 0, ',', '.') }}</span> VNĐ</td></tr>
                <tr><td>Giảm trừ người phụ thuộc</td><td><span class="value">{{ number_format($calculation->dependent_deduction_amount, 0, ',', '.') }}</span> VNĐ</td></tr>
                <tr><td>Khoản đóng Bảo hiểm bắt buộc</td><td><span class="value">{{ number_format($calculation->social_insurance_contribution, 0, ',', '.') }}</span> VNĐ</td></tr>
                <tr><td>Khoản đóng góp từ thiện, nhân đạo, khuyến học</td><td><span class="value">{{ number_format($calculation->charitable_contributions, 0, ',', '.') }}</span> VNĐ</td></tr>
                <tr><td>Khoản đóng quỹ hưu trí tự nguyện (tối đa được trừ)</td><td><span class="value">{{ number_format($calculation->calculated_retirement_fund_deduction, 0, ',', '.') }}</span> VNĐ</td></tr>
                <tr class="total-row">
                    <td>TỔNG CÁC KHOẢN GIẢM TRỪ</td>
                    <td>{{ number_format($calculation->total_deductions, 0, ',', '.') }} VNĐ</td>
                </tr>
            </table>

            <p style="text-align: center; margin-top: 15px; font-size: 13px;">
                <strong>Thu nhập tính thuế:</strong> <span class="value">{{ number_format($calculation->taxable_income, 0, ',', '.') }} VNĐ</span>
            </p>

            <table class="final-tax-table">
                <tr class="final-tax-row">
                    <td><strong>SỐ THUẾ TNCN PHẢI NỘP</strong></td>
                    <td style="width: 30%;"><span class="total-tax-value">{{ number_format($calculation->final_tax_amount, 0, ',', '.') }}</span> VNĐ</td>
                </tr>
            </table>
        </div>
        @if (!$loop->last)
            <div style="page-break-after: always;"></div> @endif
    @empty
        <p style="text-align: center; font-style: italic; color: #888;">Không có bản ghi lịch sử nào để hiển thị.</p>
    @endforelse

    <div class="footer">
        <p><i>Báo cáo được lập tự động từ Hệ thống Tính Thuế TNCN, ngày {{ now()->format('d/m/Y') }}</i></p>
    </div>
</body>
</html>