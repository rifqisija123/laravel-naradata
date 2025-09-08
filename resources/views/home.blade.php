@extends('layouts.apps')

@section('title', 'Home')

@section('content-card-home')
    <style>
        .funfact-carousel {
            height: 60px;
            display: flex;
            align-items: center;
            overflow: hidden;
            background: #f9f9f9;
        }

        #funFactSlider p {
            font-size: 1rem;
            color: #333;
        }

        #bot-response {
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.3s ease;
        }

        #bot-response.show {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
    <div class="icon-decoration">
        <i class="fas fa-box icon-hero" style="top: 15%; left: 5%;"></i>
        <i class="fas fa-couch icon-hero" style="top: 40%; left: 30%;"></i>
        <i class="fas fa-desktop icon-navbheroar" style="top: 10%; left: 70%;"></i>
        <i class="fas fa-keyboard icon-hero" style="top: 60%; left: 90%;"></i>
        <i class="fas fa-chair icon-hero" style="top: 20%; left: 15%;"></i>
        <i class="fas fa-table icon-hero" style="top: 35%; left: 50%;"></i>
        <i class="fas fa-tv icon-hero" style="top: 5%; left: 80%;"></i>
        <i class="fas fa-mouse icon-hero" style="top: 50%; left: 10%;"></i>
        <i class="fas fa-server icon-hero" style="top: 65%; left: 25%;"></i>
        <i class="fas fa-boxes-stacked icon-hero" style="top: 30%; left: 75%;"></i>
        <i class="fas fa-tools icon-hero" style="top: 45%; left: 60%;"></i>
        <i class="fas fa-hdd icon-hero" style="top: 12%; left: 40%;"></i>
        <i class="fas fa-plug icon-hero" style="top: 70%; left: 85%;"></i>
        <i class="fas fa-warehouse icon-hero" style="top: 22%; left: 92%;"></i>
        <i class="fas fa-screwdriver-wrench icon-hero" style="top: 55%; left: 35%;"></i>
        <i class="fas fa-key icon-hero" style="top: 10%; left: 20%;"></i>
        <i class="fas fa-laptop-code icon-hero" style="top: 38%; left: 65%;"></i>
        <i class="fas fa-pallet icon-hero" style="top: 66%; left: 45%;"></i>
    </div>

    <div class="container mt-4">
        <div class="hero-card shadow-sm rounded-4 text-white mb-4">
            <div class="row align-items-center">
                <div class="col-12">
                    <h2 class="fw-bold mb-2">Selamat Datang, {{ Auth::user()->name ?? 'Pengguna' }} 👋</h2>
                    <p class="mb-0">Ini adalah Halaman Utama Aplikasi.</p>
                </div>
            </div>
        </div>

        <div class="container mb-4">
            <div id="fun-fact-box" style="overflow: hidden; width: 100%; position: relative;">
                <div id="fun-fact-slider" style="white-space: nowrap; transition: transform 0.5s ease;">
                    {{-- Fun facts akan dimuat lewat JavaScript --}}
                </div>
            </div>
        </div>

        <!-- GudangBot Card -->
        <div class="container mb-5 d-flex justify-content-end">
            <div class="card shadow-sm border-0 rounded-4 p-4 bg-light-subtle" style="max-width: 500px; width: 100%;">
                <div class="d-flex align-items-center mb-3">
                    <img src="https://cdn-icons-png.flaticon.com/512/4712/4712102.png" alt="GudangBot"
                        style="width: 48px; height: 48px;">
                    <div class="ms-3">
                        <h5 class="fw-bold mb-0">GudangBot 🤖</h5> 
                        <small class="text-muted">Halo {{ Auth::user()->name ?? 'Pengguna' }}! Ada yang bisa
                            dibantu?</small>
                    </div>
                </div>

                <div class="row g-2 mb-3" id="faq-buttons">
                    @php
                        $faqs = [
                            ['id' => 'tambahBarang', 'label' => '➕ Tambah Barang'],
                            ['id' => 'tambahUser', 'label' => '👤 Tambah Karyawan'],
                            ['id' => 'logAktivitas', 'label' => '📜 Aktivitas'],
                            ['id' => 'hapusBarang', 'label' => '🗑️ Hapus Barang'],
                            ['id' => 'barangHilang', 'label' => '🔍 Barang Tidak Muncul'],
                            ['id' => 'ubahBarang', 'label' => '✏️ Ubah Data Barang'],
                        ];
                    @endphp

                    @foreach ($faqs as $faq)
                        <div class="col-6">
                            <button class="btn btn-outline-dark w-100 btn-sm bot-button" data-faq="{{ $faq['id'] }}">
                                {{ $faq['label'] }}
                            </button>
                        </div>
                    @endforeach
                </div>

                <div id="bot-response" class="bg-white border rounded-3 p-3 d-none">
                    <p id="response-text" class="mb-2 text-dark"></p>
                    <a href="#" id="redirect-button" class="btn btn-sm btn-primary">🔗 Buka Halamannya</a>
                </div>
            </div>
        </div>

        @push('scripts')
            <script>
                fetch('{{ route('api.funfacts') }}')
                    .then(res => res.json())
                    .then(data => {
                        const slider = document.getElementById('fun-fact-slider');
                        const allFacts = [...data, data[0]];

                        allFacts.forEach(fact => {
                            const div = document.createElement('div');
                            div.innerHTML = fact;
                            div.style.display = 'inline-block';
                            div.style.width = '100%';
                            slider.appendChild(div);
                        });

                        let index = 0;
                        setInterval(() => {
                            index++;
                            slider.style.transition = 'transform 0.5s ease';
                            slider.style.transform = `translateX(-${index * 100}%)`;

                            if (index === allFacts.length - 1) {
                                setTimeout(() => {
                                    slider.style.transition = 'none';
                                    slider.style.transform = 'translateX(0)';
                                    index = 0;
                                }, 500);
                            }
                        }, 5000);
                    });

                // Bot FAQ Logic
                const faqData = {
                    tambahBarang: {
                        text: "Untuk menambahkan barang baru, klik tombol ➕ di halaman barang.",
                        link: "{{ url('/barang') }}"
                    },
                    tambahUser: {
                        text: "Untuk menambah user atau karyawan, masuk ke menu Karyawan lalu klik tombol Tambah.",
                        link: "{{ url('/karyawan') }}"
                    },
                    logAktivitas: {
                        text: "Semua aktivitas bisa dilihat di menu Riwayat.",
                        link: "{{ url('/riwayat') }}"
                    },
                    hapusBarang: {
                        text: "Masuk ke halaman barang, lalu klik ikon 🗑️ di samping barang yang ingin dihapus.",
                        link: "{{ url('/barang') }}"
                    },
                    barangHilang: {
                        text: "Coba cek filter pencarian dan reset filter di kanan atas agar semua data muncul.",
                        link: "{{ url('/barang') }}"
                    },
                    ubahBarang: {
                        text: "Klik tombol ✏️ di samping barang, lalu ubah datanya dan simpan.",
                        link: "{{ url('/barang') }}"
                    }
                };

                const buttons = document.querySelectorAll('#faq-buttons button');
                const responseBox = document.getElementById('bot-response');
                const responseText = document.getElementById('response-text');
                const redirectButton = document.getElementById('redirect-button');

                buttons.forEach(button => {
                    button.addEventListener('click', () => {
                        const key = button.getAttribute('data-faq');
                        const faq = faqData[key];
                        if (faq) {
                            responseText.innerText = faq.text;
                            redirectButton.setAttribute('href', faq.link);
                            responseBox.classList.remove('d-none');
                            responseBox.classList.remove('show');

                            setTimeout(() => {
                                responseBox.classList.add('show');
                            }, 10);
                        }
                    });
                });
            </script>
        @endpush
    @endsection
