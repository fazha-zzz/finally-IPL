@extends('layouts.user')

@section('content')
<div class="container py-4">

    {{-- ================= HEADER ================= --}}
    <div class="text-center mb-4">
        <h2 class="fw-bold text-success">Payment History</h2>
        <p class="text-muted">
            Pertahankan riwayat pembayaran anda demi kemajuan HOM.
        </p>
    </div>

    {{-- ================= TUNGGAKAN ================= --}}
    <h4 class="mb-3">Tunggakan Pembayaran</h4>

    @if ($tunggakan->count())
        <table class="table table-bordered mb-3">
            <thead class="table-light">
                <tr>
                    <th>Bulan</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tunggakan as $p)
                    <tr>
                        <td>
                            {{ \Carbon\Carbon::parse($p->tanggal)->translatedFormat('F Y') }}
                        </td>
                        <td>
                            Rp {{ number_format($p->total, 0, ',', '.') }}
                        </td>
                        <td>
                            <span class="badge bg-danger">
                                Belum Terbayar
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-center mb-4">
            <button class="btn btn-success bayar-semua-btn">
                <i class="fas fa-wallet"></i>
                Bayar Semua ({{ $tunggakan->count() }} Tagihan)
            </button>
        </div>
    @else
        <p class="text-muted mb-4">Tidak ada tunggakan 🎉</p>
    @endif

    <hr>

    {{-- ================= HISTORI ================= --}}
    <h4 class="mb-3">Histori Pembayaran</h4>

    @if ($histori->count())
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Bulan</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                     <th>Denda</th>

                    <th>Tanggal Jatuh Tempo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($histori as $p)
                    <tr>
                        <td>
                            {{ \Carbon\Carbon::parse($p->tanggal)->translatedFormat('F Y') }}
                        </td>
                        <td>
                            Rp {{ number_format($p->total, 0, ',', '.') }}
                        </td>
                        <td>
                            @if ($p->status === 'berhasil dibayar')
                                <span class="badge bg-success">Lunas</span>
                            @else
                                <span class="badge bg-warning text-dark">
                                    {{ $p->status }}
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($p->denda > 0)
                                <span class="text-danger">
                                    Rp {{ number_format($p->denda, 0, ',', '.') }}
                                </span>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                           {{ $p->tanggal_jatuh_tempo 
                            ? \Carbon\Carbon::parse($p->tanggal_jatuh_tempo)->format('d-m-Y') 
                            : '-' }}

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-muted">Belum ada histori pembayaran.</p>
    @endif

</div>

{{-- ================= SCRIPT BAYAR SEMUA ================= --}}
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
