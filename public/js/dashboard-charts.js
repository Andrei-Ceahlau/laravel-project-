// Funcția pentru inițializarea graficelor dashboard
function initializeDashboardCharts(chartData) {
    // Verificăm dacă Chart.js este încărcat
    if (typeof Chart === 'undefined') {
        console.error('Chart.js nu este disponibil. Te rugăm să verifici încărcarea bibliotecii.');
        return;
    }

    // Verificăm dacă avem elementul canvas pentru grafic
    const salesChartElement = document.getElementById('salesChart');
    if (!salesChartElement) {
        console.error('Elementul canvas cu id-ul "salesChart" nu a fost găsit în pagină.');
        return;
    }

    // Obținem contextul pentru grafic
    const ctx = salesChartElement.getContext('2d');

    // Setări implicite pentru Chart.js
    Chart.defaults.font.family = "'Poppins', sans-serif";
    Chart.defaults.color = '#555555';

    try {
        // Inițializăm graficul de vânzări
        const salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartData.labels,
                datasets: [{
                    label: 'Vânzări estimate (RON)',
                    data: chartData.sales,
                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                    borderColor: '#4f46e5',
                    pointRadius: 4,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#4f46e5',
                    pointHoverRadius: 6,
                    pointHoverBackgroundColor: '#4f46e5',
                    pointHoverBorderColor: '#ffffff',
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 10,
                        top: 10,
                        bottom: 0
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            borderDash: [3, 3],
                            drawBorder: false
                        },
                        ticks: {
                            beginAtZero: true,
                            callback: function(value) {
                                return value.toLocaleString() + ' RON';
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.9)',
                        titleColor: '#333',
                        bodyColor: '#666',
                        borderColor: '#ddd',
                        borderWidth: 1,
                        cornerRadius: 6,
                        padding: 10,
                        callbacks: {
                            label: function(context) {
                                return 'Vânzări estimate: ' + context.parsed.y.toLocaleString() + ' RON';
                            },
                            footer: function(tooltipItems) {
                                return 'Bazat pe stocul produselor și prețuri';
                            }
                        }
                    }
                }
            }
        });
        console.log('Graficul a fost inițializat cu succes!');
    } catch (error) {
        console.error('Eroare la inițializarea graficului:', error);
    }
}

// Funcție pentru a se asigura că Chart.js este încărcat
function ensureChartJsLoaded(callback, chartData) {
    if (typeof Chart === 'undefined') {
        // Dacă Chart.js nu este încărcat, încărcăm manual
        console.log('Chart.js nu a fost detectat. Încercăm să îl încărcăm manual...');
        const script = document.createElement('script');
        script.src = 'https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js';
        script.onload = function() {
            console.log('Chart.js a fost încărcat manual cu succes.');
            callback(chartData);
        };
        document.body.appendChild(script);
    } else {
        // Chart.js este deja încărcat
        console.log('Chart.js este deja încărcat.');
        callback(chartData);
    }
} 