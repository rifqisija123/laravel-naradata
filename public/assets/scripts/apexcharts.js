document.addEventListener('DOMContentLoaded', function () {
    // Chart 1: Distribusi Barang per Kategori
    const chartKategoriOptions = {
        series: kategoriValues,
        chart: {
            type: 'donut',
            height: 300,
            fontFamily: 'Inter, sans-serif',
        },
        labels: kategoriLabels,
        colors: ['#3B82F6', '#10B981'],
        legend: {
            position: 'bottom'
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 300
                },
                legend: {
                    position: 'bottom'
                }
            }
        }],
        plotOptions: {
            pie: {
                donut: {
                    size: '55%'
                }
            }
        },
        dataLabels: {
            enabled: true,
            formatter: function (val, opts) {
                let total = kategoriValues.reduce((a, b) => a + b, 0);
                let count = kategoriValues[opts.seriesIndex];
                let percent = total > 0 ? (count / total * 100).toFixed(1) : 0;
                return `${count} barang (${percent}%)`;
            }
        },
        tooltip: {
            y: {
                formatter: function (value) {
                    let total = kategoriValues.reduce((a, b) => a + b, 0);
                    let percent = total > 0 ? (value / total * 100).toFixed(1) : 0;
                    return `${value} barang (${percent}%)`;
                }
            }
        }
    };

    // Chart 2: Status Kelengkapan Barang
    const chartKelengkapanOptions = {
        series: [lengkap, tidakLengkap],
        chart: {
            height: 300,
            type: 'pie',
            fontFamily: 'Inter, sans-serif',
        },
        labels: [
            `Lengkap (${(lengkap / (lengkap + tidakLengkap) * 100).toFixed(1)}%)`,
            `Tidak Lengkap (${(tidakLengkap / (lengkap + tidakLengkap) * 100).toFixed(1)}%)`
        ],
        colors: ['#10B981', '#EF4444'],
        legend: {
            position: 'bottom',
            formatter: function (seriesName, opts) {
                return `${seriesName} - ${opts.w.globals.series[opts.seriesIndex]} barang`;
            }
        },
        tooltip: {
            y: {
                formatter: function (value) {
                    return `${value} barang`;
                }
            }
        },
        dataLabels: {
            formatter: function (val, opts) {
                return `${opts.w.globals.series[opts.seriesIndex]} barang`;
            }
        }
    };

    // Chart 3: Distribusi Barang per Lokasi
    const chartLokasiOptions = {
        series: [{
            name: 'Jumlah Barang',
            data: lokasiValues
        }],
        chart: {
            type: 'bar',
            height: 300,
            fontFamily: 'Inter, sans-serif',
            toolbar: {
                show: false
            }
        },
        colors: ['#3B82F6'],
        plotOptions: {
            bar: {
                horizontal: true,
                barHeight: '60%',
                distributed: true,
                dataLabels: {
                    position: 'bottom'
                }
            }
        },
        dataLabels: {
            enabled: true,
            textAnchor: 'start',
            style: {
                colors: ['#fff']
            },
            formatter: function (val) {
                return `${val} barang`;
            },
            offsetX: 0,
            dropShadow: {
                enabled: true
            }
        },
        xaxis: {
            categories: lokasiLabels
        },
        yaxis: {
            labels: {
                show: false
            }
        },
        legend: {
            show: false
        }
    };

    //rendering
    new ApexCharts(document.querySelector("#chartKategori"), chartKategoriOptions).render();
    new ApexCharts(document.querySelector("#chartKelengkapan"), chartKelengkapanOptions).render();
    new ApexCharts(document.querySelector("#chartLokasi"), chartLokasiOptions).render();
});