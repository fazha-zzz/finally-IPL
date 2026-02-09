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

            @if($kritik->attachments->count())
            <hr>
            <h5>Lampiran File</h5>

            <div class="row mt-2">
                @foreach($kritik->attachments as $file)
                    @php
                        $ext = strtolower(pathinfo($file->file_name, PATHINFO_EXTENSION));
                        $isImage = in_array($ext, ['jpg','jpeg','png','gif','webp']);
                    @endphp

                    <div class="col-md-3 mb-3">
                        @if($isImage)
                            <a href="{{ asset('storage/'.$file->file_path) }}" target="_blank">
                                <img src="{{ asset('storage/'.$file->file_path) }}" class="img-fluid rounded border" alt="{{ $file->file_name }}">
                            </a>
                            <div class="mt-1 small text-truncate">{{ $file->file_name }}</div>
                        @else
                            <div class="d-flex justify-content-between align-items-center border rounded p-2">
                                <div class="small text-truncate me-2">{{ $file->file_name }}</div>
                                <a href="{{ asset('storage/'.$file->file_path) }}" target="_blank" class="btn btn-sm btn-primary">Download</a>
                            </div>
                        @endif
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
    <form action="{{ route('admin.saran.balas', $kritik->id) }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Balasan Admin</label>
            <textarea name="balasan"
                      rows="4"
                      class="form-control @error('balasan') is-invalid @enderror"
                      placeholder="Tulis balasan admin...">{{ old('balasan') }}</textarea>
            @error('balasan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Lampiran Admin (opsional)</label>
            <input type="file" name="attachments[]" multiple class="form-control">
            <small class="text-muted">Gambar / dokumen (max 2MB)</small>

            @error('attachment.*')
                <div class="text-danger small">{{ $message }}</div>
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
