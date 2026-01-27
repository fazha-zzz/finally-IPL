<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserBaruController extends Controller
{
    public function index()
    {
        // Ambil user dengan urutan berdasarkan no_rumah
        $users = User::orderBy('no_rumah', 'asc')
            ->paginate(5); // tampilkan 10 per halaman

        return view('admin.users.index', compact('users'));

    }

    public function create()
    {
        return view('admin.users.create');
    }

    // Simpan user baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'no_rumah' => 'required|string|unique:users,no_rumah',
            'no_tlp' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'no_rumah' => $request->no_rumah,
            'no_tlp' => $request->no_tlp,
            'alamat' => $request->alamat,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User baru berhasil ditambahkan.');
    }

    // Tampilkan form edit
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // Update data user
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'no_rumah' => 'required|string|unique:users,no_rumah,'.$user->id,
            'no_tlp' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
            'password' => 'nullable|string|min:6|confirmed', // password opsional
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->no_rumah = $request->no_rumah;
        $user->no_tlp = $request->no_tlp;
        $user->alamat = $request->alamat;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diupdate.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}
