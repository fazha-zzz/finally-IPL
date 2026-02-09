@extends('layouts.admin')

@section('content')
<style>
    .table td, .table th {
        white-space: nowrap;
        vertical-align: middle;
    }
</style>

<div class="container-fluid d-flex flex-column align-items-center min-vh-100 p-3 mt-5">
    <h1 class="mb-4 text-center">Daftar User Melewati Jatuh Tempo</h1>

    <div class="card w-100 mt-2" style="max-width:1200px;">
        <div class="card-body">

            {{-- Table --}}

            <form method="GET" action="{{ route('admin.Tempo.jatuh-tempo') }}" class="mb-3 d-flex gap-2">
                <input type="text" name="search"
                       value="{{ request('search') }}"
                       class="form-control"
                       placeholder="Cari No Rumah">

                <button class="btn btn-primary">Cari</button>

                <a href="{{ route('admin.Tempo.jatuh-tempo') }}"
                   class="btn btn-secondary">
                   Reset
                </a>
            </form>

            <div class="mb-3 text-end d-flex gap-2 justify-content-end">
                <a href="{{ route('admin.Tempo.jatuh-tempo.pdf') }}" 
                   class="btn btn-danger">
                    Export PDF
                </a>
                <a href="{{ route('admin.Tempo.jatuh-tempo.export') }}"
                   class="btn btn-success">
                    Export Excel
                </a>
            </div>

            @if($data->count())
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle text-center">
                    <thead class="bg-danger text-white">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>No Rumah</th>
                            <th>Tanggal Jatuh Tempo</th>
                            <th>Total</th>
                            <th>Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $item)
                        <tr>
                            <td>{{ ($data->currentPage()-1)*$data->perPage() + $loop->iteration }}</td>
                            <td>{{ $item->user->name ?? '-' }}</td>
                            <td>{{ $item->user->no_rumah ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d-m-Y') }}</td>
                            <td>Rp {{ number_format($item->total,0,',','.') }}</td>
                            <td class="text-danger">Rp {{ number_format($item->denda,0,',','.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            {{ $data->appends(request()->query())->links('pagination::bootstrap-5') }}

            @else
            <div class="alert alert-success">
                Tidak ada user yang melewati jatuh tempo 🎉
            </div>
            @endif

        </div>
    </div>
</div>

@endsection
