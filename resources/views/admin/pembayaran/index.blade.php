@extends('layouts.admin')

@section('content')

<style>
    .table td, .table th {
        white-space: nowrap;
        vertical-align: middle;
    }
</style>

<div class="container-fluid d-flex flex-column align-items-center min-vh-100 p-3 mt-5">
    <h1 class="mb-4 text-center">Data Pembayaran</h1>

    <div class="card w-100 mt-2" style="max-width:1200px;">
        <div class="card-body">

            {{-- Create pembayaran semua user --}}
            <div class="d-flex justify-content-end mb-3">
                <form action="{{ route('admin.pembayaran.generate') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        + Generate Pembayaran
                    </button>
                </form>
            </div>

            {{-- Filter --}}
            <form action="{{ route('admin.pembayaran.index') }}" method="GET" class="d-flex gap-2 mb-3">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="form-control" placeholder="Cari nama / no rumah">

                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
                    <option value="settlement" {{ request('status')=='settlement'?'selected':'' }}>Settlement</option>
                    <option value="expire" {{ request('status')=='expire'?'selected':'' }}>Expire</option>
                    <option value="cancel" {{ request('status')=='cancel'?'selected':'' }}>Cancel</option>
                </select>

                <button class="btn btn-primary">Cari</button>
                <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-secondary">Reset</a>
            </form>

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle text-center">
                    <thead class="bg-success text-white">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>No Rumah</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Order ID</th>
                            <th>Metode</th>
                            <th>Status Midtrans</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($data as $item)
                            <tr>
                                <td>{{ ($data->currentPage()-1)*$data->perPage() + $loop->iteration }}</td>
                                <td>{{ $item->user->name ?? '-' }}</td>
                                <td>{{ $item->user->no_rumah ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                                <td>Rp {{ number_format($item->total,0,',','.') }}</td>

                                {{-- Order ID --}}
                                <td>
                                    {{ $item->order_id ?? '-' }}
                                </td>

                                {{-- Metode --}}
                                <td>
                                    @if($item->payment_type)
                                        <span class="badge bg-info text-dark">
                                            {{ strtoupper($item->payment_type) }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">-</span>
                                    @endif
                                </td>

                                {{-- Status --}}
                                <td>
                                    @switch($item->transaction_status)
                                        @case('settlement')
                                            <span class="badge bg-success">Settlement</span>
                                            @break
                                        @case('pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                            @break
                                        @case('expire')
                                            <span class="badge bg-dark">Expire</span>
                                            @break
                                        @case('cancel')
                                            <span class="badge bg-danger">Cancel</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">-</span>
                                    @endswitch
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">Belum ada data pembayaran</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            {{ $data->appends(request()->query())->links('pagination::bootstrap-5') }}

        </div>
    </div>
</div>

@endsection
