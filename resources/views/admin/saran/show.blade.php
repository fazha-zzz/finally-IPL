@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h3 class="mb-4">Detail Kritik & Saran</h3>

    <div class="card shadow-sm">
        <div class="card-body">
            <p><strong>User:</strong> {{ $kritik->user->name ?? '-' }}</p>
            <p><strong>Tanggal:</strong> {{ $kritik->created_at->format('d-m-Y H:i') }}</p>
            <hr>
            <p><strong>Isi:</strong></p>
            <p>{{ $kritik->isi }}</p>

            @if($kritik->gambars->count())
            <hr>
            <strong>Gambar:</strong>
            <div class="row mt-2">
                @foreach($kritik->gambars as $img)
                    <div class="col-md-3 mb-2">
                        <img src="{{ asset('storage/'.$img->path) }}"
                             class="img-fluid rounded">
                    </div>
                @endforeach
            </div>
            @endif

            <hr>
            

            @if($kritik->balasan)
    {{-- MODE READ ONLY --}}
    <div class="mb-3">
        <h5>Balasan Admin</h5>
        <textarea class="form-control" rows="4" readonly>
{{ $kritik->balasan }}
        </textarea>
        <small class="text-muted">
            Balasan sudah dikirim dan tidak dapat diubah
        </small>
    </div>
@else
    {{-- MODE INPUT --}}
    <form action="{{ route('admin.saran.balas', $kritik->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <h5>Balasan Admin</h5>
            <textarea
                name="balasan"
                rows="4"
                class="form-control @error('balasan') is-invalid @enderror"
                placeholder="Tulis balasan admin...">{{ old('balasan') }}</textarea>

            @error('balasan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button class="btn btn-success">Kirim Balasan</button>
    </form>
@endif

        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('admin.saran.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection
