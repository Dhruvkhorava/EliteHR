document.addEventListener("DOMContentLoaded", function() {
    if (!window.dashboardData) return;

    // Attendance Bar Chart
    var barOptions = {
        chart: {
            type: 'bar',
            height: 350,
            toolbar: { show: false }
        },
        colors: ['#4361ee'],
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '50%',
                borderRadius: 4
            },
        },
        dataLabels: { enabled: false },
        stroke: { show: true, width: 2, colors: ['transparent'] },
        series: [{
            name: 'Attendance',
            data: window.dashboardData.attendanceSeries
        }],
        xaxis: {
            categories: window.dashboardData.attendanceLabels,
        },
        yaxis: { title: { text: 'Employees' } },
        fill: { opacity: 1 },
        tooltip: {
            y: { formatter: function (val) { return val + " present" } }
        }
    };
    var barChart = new ApexCharts(document.querySelector("#attendanceBarChart"), barOptions);
    if(document.querySelector("#attendanceBarChart")) barChart.render();

    // Leave Types Donut Chart
    var donutOptions = {
        chart: {
            type: 'donut',
            width: 380
        },
        labels: window.dashboardData.leaveTypeLabels,
        series: (window.dashboardData.leaveTypeData || []).map(Number),
        colors: ['#4361ee', '#e95f2b', '#00ab55', '#e2a03f', '#e7515a'],
        responsive: [{
            breakpoint: 480,
            options: {
                chart: { width: 200 },
                legend: { position: 'bottom' }
            }
        }],
        legend: { position: 'bottom' }
    };
    var donutChart = new ApexCharts(document.querySelector("#leaveTypeChart"), donutOptions);
    if(document.querySelector("#leaveTypeChart") && window.dashboardData.leaveTypeData && window.dashboardData.leaveTypeData.length > 0) donutChart.render();
});
