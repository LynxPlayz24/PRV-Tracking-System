/**
 * Dashboard Scripts
 * Initializes Chart.js graphs for the dashboard.
 */
document.addEventListener('DOMContentLoaded', function() {
    
    // Fetch chart data from API
    const fetchChartData = async () => {
        try {
            // Get base URL from current location (assumes standard routing)
            const basePath = window.location.pathname.includes('/public/') 
                ? window.location.pathname.substring(0, window.location.pathname.indexOf('/public/') + 7) 
                : '/';
            
            // Adjust API URL if deployed differently
            const apiUrl = basePath.endsWith('/') ? `${basePath}dashboard/chart-data` : `${basePath}/dashboard/chart-data`;

            const response = await fetch(apiUrl);
            if (!response.ok) throw new Error('Network response was not ok');
            
            const data = await response.json();
            initCharts(data);
        } catch (error) {
            console.error('Error fetching chart data:', error);
        }
    };

    // Initialize Charts
    const initCharts = (data) => {
        // Common Colors
        const uumBlue = '#003399';
        const uumYellow = '#FFCC00';
        const colors = [uumBlue, uumYellow, '#28A745', '#DC3545', '#17A2B8', '#6C757D', '#6610f2'];

        // 1. Students by School (Bar Chart)
        const ctxSchool = document.getElementById('schoolChart');
        if (ctxSchool) {
            new Chart(ctxSchool, {
                type: 'bar',
                data: {
                    labels: data.school_distribution.labels,
                    datasets: [{
                        label: 'Number of Students',
                        data: data.school_distribution.data,
                        backgroundColor: uumBlue,
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { stepSize: 1 } },
                        x: { grid: { display: false } }
                    }
                }
            });
        }

        // 2. Degree Level (Doughnut Chart)
        const ctxDegree = document.getElementById('degreeChart');
        if (ctxDegree) {
            new Chart(ctxDegree, {
                type: 'doughnut',
                data: {
                    labels: data.degree_distribution.labels,
                    datasets: [{
                        data: data.degree_distribution.data,
                        backgroundColor: [uumBlue, uumYellow, '#28A745'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' }
                    },
                    cutout: '70%'
                }
            });
        }

        // 3. Status Distribution (Bar Chart - Horizontal or Line, let's use Bar)
        const ctxStatus = document.getElementById('statusChart');
        if (ctxStatus) {
            new Chart(ctxStatus, {
                type: 'bar',
                data: {
                    labels: data.status_distribution.labels,
                    datasets: [{
                        label: 'Students Count',
                        data: data.status_distribution.data,
                        backgroundColor: function(context) {
                            return colors[context.dataIndex % colors.length];
                        },
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { stepSize: 1 } },
                        x: { grid: { display: false } }
                    }
                }
            });
        }
    };

    // Initialize
    fetchChartData();
});
