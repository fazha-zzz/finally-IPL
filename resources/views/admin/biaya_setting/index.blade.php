@extends('layouts.admin')

@section('content')
<div class="container-fluid d-flex flex-column align-items-center min-vh-100 p-3 mt-5">
    <h1 class="mb-4 text-center">Atur Biaya Pembayaran</h1>
    <div class="card w-100 mt-2" style="max-width:800px;">
        <div class="card-body">

            {{-- Notifikasi sukses --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('admin.biaya_setting.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold">Biaya Keamanan</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="keamanan" class="form-control" 
                               value="{{ old('keamanan', $setting->keamanan ?? 0) }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Biaya Kebersihan</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="kebersihan" class="form-control" 
                               value="{{ old('kebersihan', $setting->kebersihan ?? 0) }}" required>
                    </div>
                </div>


                <div class="mb-3">
                    <label class="form-label fw-bold">Denda Keterlambatan</label>
                     <div class="input-group">
                        <span class="input-group-text">Rp</span>
                    <input type="number" name="denda" class="form-control"
                        value="{{ old('denda', $setting->denda ?? 0) }}" required>
                        </div>
                 </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tanggal Jatuh Tempo</label>
                        <input type="date" name="tanggal_jatuh_tempo" class="form-control" 
                               value="{{ old('tanggal_jatuh_tempo', $setting->tanggal_jatuh_tempo ?? '') }}" required>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="bi bi-save me-1"></i> Simpan
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection