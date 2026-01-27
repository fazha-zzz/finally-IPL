@extends('layouts.user')

@section('content')
<div class="mobile-container">
    <!-- Header Section -->
    <div class="header-section mt-5 mb-3">
        <div class="profile-avatar">
            <i class="fas fa-user"></i>
        </div>
        <div class="greeting-text">Selamat datang</div>
        <h1 class="user-name">{{ Auth::user()->name ?? 'User' }}</h1>

        <!-- Balance Card -->
        <div class="balance-card">
    <div class="balance-info">
        <div>
            <p class="balance-label">Tagihan</p>
            <h2 class="balance-amount">
                Rp {{ number_format($tagihan->total ?? 0, 0, ',', '.') }}
            </h2>
            <a href="{{ route('user.pembayaran.index') }}" class="balance-detail">
                klik & cek riwayat
            </a>
        </div>

        @if($tagihan)
            @if($tagihan->dibayar && $tagihan->dibayar->foto)
                <button class="topup-btn" disabled style="background-color: #ffc107; color: #000;">
                    <i class="fas fa-clock me-1"></i> Menunggu Konfirmasi
                </button>
                <!-- <div class="alert alert-warning mt-2 p-2" style="font-size: 12px; margin: 5px 0;">
                    <i class="fas fa-info-circle me-1"></i>
                    Bukti pembayaran Anda sedang diverifikasi oleh admin
                </div> -->
            @elseif($tagihan->status == 'berhasil dibayar')
                <button class="topup-btn" disabled style="background-color: #28a745;">
                    <i class="fas fa-check me-1"></i> Lunas
                </button>
            @else
                <button type="button" 
                    class="topup-btn bayar-midtrans-btn"
                    data-id="{{ $tagihan->id }}">
                    Bayar
               </button>
            @endif
        @else
            <button class="topup-btn" disabled>
                Tidak ada tagihan
            </button>
        @endif
    </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">

        @if($tagihan)
            <a href="{{ route('user.pembayaran.detail', $tagihan->id) }}" class="check-bill-btn">
                <i class="fas fa-file-invoice"></i>
                Cek Tagihan Anda
            </a>
        @endif

        
        <!-- Iklan Carousel Section -->
       @if($iklans->count() > 0)
<div id="iklanCarousel" class="carousel slide my-4" data-bs-ride="carousel">
    <div class="carousel-inner rounded shadow">

        @foreach($iklans as $key => $iklan)
        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
            {{-- Gambar --}}
            <img src="{{ $iklan->gambar ? asset('storage/'.$iklan->gambar) : asset('images/default.jpg') }}"
     class="d-block w-100"
     alt="{{ $iklan->judul ?? 'Iklan' }}"
     style="max-height:200px; object-fit:cover; border-radius:8px;">

            {{-- Caption --}}
            <div class="carousel-caption bg-dark bg-opacity-50 rounded p-2 text-start" 
                 style="bottom: 10px; left: 10px; right: 10px;">
                <h6 class="mb-1">{{ $iklan->judul ?? 'Tidak ada judul' }}</h6>
                <small>{{ $iklan->deskripsi ? Str::limit($iklan->deskripsi, 50) : 'Tidak ada deskripsi' }}</small>
            </div>
        </div>
        @endforeach

    </div>

    {{-- Kontrol carousel --}}
    <button class="carousel-control-prev" type="button" data-bs-target="#iklanCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#iklanCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
        <span class="visually-hidden">Next</span>
    </button>

    {{-- Indicators --}}
    <div class="carousel-indicators mt-2">
        @foreach($iklans as $key => $iklan)
        <button type="button" data-bs-target="#iklanCarousel" data-bs-slide-to="{{ $key }}" 
                class="{{ $key == 0 ? 'active' : '' }}" aria-current="{{ $key == 0 ? 'true' : 'false' }}" 
                aria-label="Slide {{ $key + 1 }}"></button>
        @endforeach
    </div>
</div>
@endif

        <!-- Services Section -->
        <h3 class="section-title">Info dan Layanan</h3>
        <div class="service-grid">
            <!-- <a href="#" class="service-item">
                <div class="service-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="service-label">Surat</div>
            </a> -->
            <a href="{{ route('user.pengumuman.index') }}" class="service-item">
                <div class="service-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="service-label">Pengumuman</div>
            </a>
            <a href="{{ route('user.saran.index') }}" class="service-item">
                <div class="service-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="service-label">Saran & Kritik</div>
            </a>
            <a href="javascript:;" class="service-item" data-bs-toggle="modal" data-bs-target="#tataTertibModal">
                <div class="service-icon">
                    <i class="fas fa-info-circle"></i>
                </div>
                <div class="service-label">Tata Tertib</div>
            </a>

            <a href="#" class="service-item">
                <div class="service-icon">
                    <i class="fas fa-question-circle"></i>
                </div>
                <div class="service-label">Keluhan</div>
            </a>
            <a href="{{ route('user.kegiatan.index') }}" class="service-item">
                <div class="service-icon">
                    <i class="fas fa-exchange-alt"></i>
                </div>
                <div class="service-label">Kegiatan</div>
            </a>
            <!-- <a href="#" class="service-item" style="grid-column: 2;">
                <div class="service-icon">
                    <i class="fas fa-store"></i>
                </div>
                <div class="service-label">Bazaar</div>
            </a> -->
        </div>

        

        



@push('styles')
<style>
.alert {
    border-radius: 8px;
    border: none;
    font-size: 12px;
}

.alert-warning {
    background-color: #fff3cd;
    color: #856404;
    border-left: 4px solid #ffc107;
}

.alert-info {
    background-color: #d1ecf1;
    color: #0c5460;
    border-left: 4px solid #17a2b8;
}

/* Carousel Animation */
@keyframes scroll {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-50%);
    }
}

/* Pause animation on hover */
.carousel-track:hover {
    animation-play-state: paused;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .carousel-item {
        min-width: 250px;
        margin-right: 12px;
    }
    
    .member-card {
        padding: 12px;
    }
    
    .member-text h6 {
        font-size: 13px;
    }
    
    .member-text p {
        font-size: 10px;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.bayar-midtrans-btn').forEach(button => {
        button.addEventListener('click', function () {

            const tagihanId = this.dataset.id;

            fetch("{{ route('user.midtrans.token') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    tagihan_id: tagihanId
                })
            })
            .then(res => res.json())
            .then(data => {

                if (!data.snap_token) {
                    alert('Gagal membuat pembayaran');
                    return;
                }

                snap.pay(data.snap_token, {
                    onSuccess: function () {
                        alert('Pembayaran berhasil');
                        location.reload();
                    },
                    onPending: function () {
                        alert('Menunggu pembayaran');
                        location.reload();
                    },
                    onError: function () {
                        alert('Pembayaran gagal');
                    }
                });

            })
            .catch(() => {
                alert('Terjadi kesalahan sistem');
            });

        });
    });

});
</script>
@endpush