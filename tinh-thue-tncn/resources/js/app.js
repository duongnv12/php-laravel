// resources/js/app.js

import './bootstrap';
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// Import Chart.js
import Chart from 'chart.js/auto'; // Sử dụng 'chart.js/auto' để tự động đăng ký tất cả các thành phần cần thiết

// Gán Chart vào window để có thể truy cập dễ dàng trong các file Blade
window.Chart = Chart;