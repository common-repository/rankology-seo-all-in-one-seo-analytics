// chart js
jQuery(document).ready(function($) {
    // Check if hourlyUsageData is defined
    if (typeof hourlyUsageData !== 'undefined') {
        var ctx = document.getElementById('hourly-usage-chart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: hourlyUsageData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    }
});
