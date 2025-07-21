document.addEventListener('DOMContentLoaded', function () {
    // Chart 1: Distribusi Barang per Kategori
    const chartKategoriOptions = {
        series: [65, 55],
        chart: {
            type: 'donut',
            height: 300,
            fontFamily: 'Inter, sans-serif',
        },
        labels: ['Peralatan Kantor', 'Perlengkapan Kantor'],
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
        }
    };

    // Chart 2: Status Kelengkapan Barang
    const chartKelengkapanOptions = {
        series: [85, 35],
        chart: {
            height: 300,
            type: 'pie',
            fontFamily: 'Inter, sans-serif',
        },
        labels: ['Lengkap (71%)', 'Tidak Lengkap (29%)'],
        colors: ['#10B981', '#EF4444'],
        legend: {
            position: 'bottom',
            formatter: function (seriesName, opts) {
                return [seriesName, ' - ', opts.w.globals.series[opts.seriesIndex], ' barang']
            }
        },
        tooltip: {
            y: {
                formatter: function (value) {
                    return value + " barang"
                }
            }
        },
        dataLabels: {
            formatter: function (val, opts) {
                return opts.w.globals.series[opts.seriesIndex] + " barang"
            }
        }
    };

    // Chart 3: Distribusi Barang per Lokasi
    const chartLokasiOptions = {
        series: [{
            name: 'Jumlah Barang',
            data: [42, 35, 43]
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
                return val;
            },
            offsetX: 0,
            dropShadow: {
                enabled: true
            }
        },
        xaxis: {
            categories: ['Ruang Depan', 'Ruang Tengah', 'Ruang Belakang']
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