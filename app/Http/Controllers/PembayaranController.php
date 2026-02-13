<?php

namespace App\Http\Controllers;

use App\Models\BiayaSetting;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    // =========================
    // INDEX (ADMIN & USER)
    // =========================
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $search = $request->get('search');
        $status = $request->get('status');

        if (auth()->guard('admin')->check()) {
            $query = Pembayaran::with('user');

            if ($search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('no_rumah', 'like', "%{$search}%");
                });
            }

            if ($status) {
                $query->where('status', $status);
            }
        } else {
            $query = Pembayaran::with('user')
                ->where('id_user', auth()->id());

            if ($search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('no_rumah', 'like', "%{$search}%");
                });
            }
        }

        $data = $query->latest()->paginate($perPage)->appends($request->all());

        return view('admin.pembayaran.index', compact('data'));
    }

    // =========================
    // CREATE TAGIHAN (ADMIN)
    // =========================
    public function create()
    {
        return view('admin.pembayaran.create');
    }

    // =========================
    // STORE TAGIHAN
    // =========================
    public function store(Request $request)
    {
        $today = now();
        $biaya = BiayaSetting::latest()->first();

        if (! $biaya) {
            return back()->with('error', 'Silakan atur biaya setting terlebih dahulu.');
        }

        // USER TERTENTU
        if ($request->filled('id_user')) {
            $this->createIfNotExists($request->id_user, $biaya, $today);
        }
        // MASSAL
        else {
            foreach (\App\Models\User::all() as $user) {
                $this->createIfNotExists($user->id, $biaya, $today);
            }
        }

        return redirect()
            ->route('admin.pembayaran.index')
            ->with('success', 'Tagihan berhasil dibuat.');
    }

    // =========================
    // EDIT (ADMIN)
    // =========================
    public function edit($id)
    {
        $pembayaran = Pembayaran::with('user')->findOrFail($id);

        if (! auth()->guard('admin')->check()) {
            abort(403);
        }

        return view('admin.pembayaran.edit', compact('pembayaran'));
    }

    // =========================
    // UPDATE STATUS (OPSIONAL)
    // =========================
    public function update(Request $request, $id)
    {
        $pembayaran = Pembayaran::findOrFail($id);

        if (! auth()->guard('admin')->check()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:belum terbayar,menunggu pembayaran,berhasil dibayar,gagal',
        ]);

        $pembayaran->update([
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.pembayaran.index')
            ->with('success', 'Status pembayaran diperbarui.');
    }

    // =========================
    // DELETE TAGIHAN
    // =========================
    public function destroyPembayaran($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);

        if (! auth()->guard('admin')->check()) {
            abort(403);
        }

        DB::transaction(fn () => $pembayaran->delete());

        return redirect()
            ->route('admin.pembayaran.index')
            ->with('success', 'Tagihan berhasil dihapus.');
    }

    // =========================
    // GENERATE BULANAN
    // =========================
    public function generate()
    {
        $today = now();
        $biaya = BiayaSetting::latest()->first();

        if (! $biaya) {
            return back()->with('error', 'Silakan atur biaya setting terlebih dahulu.');
        }

        foreach (\App\Models\User::all() as $user) {
            $this->createIfNotExists($user->id, $biaya, $today);
        }

        return redirect()
            ->route('admin.pembayaran.index')
            ->with('success', 'Tagihan bulanan berhasil dibuat.');
    }

    // =========================
    // HELPER
    // =========================
    private function createIfNotExists($userId, $biaya, $today)
    {
        Pembayaran::create([
            'id_user' => $userId,
            'keamanan' => $biaya->keamanan,
            'kebersihan' => $biaya->kebersihan,
            'tanggal' => $today,
            'tanggal_jatuh_tempo' => $biaya->tanggal_jatuh_tempo,
            'status' => 'belum terbayar',
            'total' => $biaya->keamanan + $biaya->kebersihan,
        ]);
    }
}
