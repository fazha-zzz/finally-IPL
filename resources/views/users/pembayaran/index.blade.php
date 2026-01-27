@extends('layouts.user')

@section('content')
<div class="container py-4">

    <div class="text-center mb-4">
        <h2 class="fw-bold text-success">Payment History</h2>
        <p class="text-muted">
            Pertahankan riwayat pembayaran anda demi kemajuan HOM.
        </p>
    </div>
    
@if($pembayarans->where('status','!=','pembayaran berhasil')->count() > 1)
        <div class="text-center mb-4">
            <button class="btn btn-success bayar-semua-btn">
                <i class="fas fa-wallet"></i> Bayar Semua Tunggakan
            </button>
        </div>
    @endif

    @forelse($pembayarans as $item)
        <div class="card shadow-sm border-0 rounded-4 mb-3" style="max-width:1000px; margin:auto;">
            <div class="card-body d-flex align-items-center">

                <div class="me-3">
                    <img src="{{ asset('assets/images/big/pesona1.jpg') }}"
                         width="48" height="48"
                         class="rounded-circle"
                         style="object-fit:cover;">
                </div>

                <div class="flex-grow-1">
                    <small class="text-muted">
                        {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                    </small>

                    <h5 class="mb-1 text-success">
                        Rp {{ number_format($item->total, 0, ',', '.') }}
                    </h5>

                    @if($item->status === 'pembayaran berhasil')
                        <span class="text-success">
                            <i class="fas fa-check-circle"></i>
                            Pembayaran Berhasil
                        </span>

                    @elseif($item->status === 'menunggu pembayaran')
                        <span class="text-warning">
                            <i class="fas fa-clock"></i>
                            Menunggu Pembayaran
                        </span>

                    @else
                        <span class="text-danger">
                            <i class="fas fa-times-circle"></i>
                            Belum Terbayar
                        </span>
                    @endif
                </div>

                <div class="text-end">
                    <small class="text-muted">IDR</small>
                    <h6 class="fw-bold">
                        Rp {{ number_format($item->total, 0, ',', '.') }}
                    </h6>
                </div>

            </div>
        </div>
    @empty
        <div class="text-center text-muted">
            <p>Belum ada riwayat pembayaran.</p>
        </div>
    @endforelse

</div>

<script>
document.querySelector('.bayar-semua-btn')?.addEventListener('click', function () {

    fetch("{{ route('user.midtrans.bayarSemua') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(res => res.json())
    .then(data => {
        snap.pay(data.snap_token, {
            onSuccess: () => location.reload(),
            onPending: () => location.reload(),
            onError: () => alert('Pembayaran gagal')
        });
    });

});
</script>

@endsection
