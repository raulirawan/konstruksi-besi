<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class KlienController extends Controller
{
    public function index()
    {
        $klien = User::where('roles', 'KLIEN')->get();
        return view('Admin.klien.index', compact('klien'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'email' => 'unique:users,email'
            ],
            [
                'email.unique' => 'Email Sudah Terdaftar'
            ]
        );
        $data = new User();
        $data->name = $request->nama_klien;
        $data->email = $request->email;
        $data->password = bcrypt($request->password);
        $data->no_hp = $request->no_hp;
        $data->roles = 'KLIEN';
        $data->save();

        if ($data != null) {
            return redirect()->route('admin.klien.index')->with('success', 'Data Berhasil di Tambah');
        } else {
            return redirect()->route('admin.klien.index')->with('error', 'Data Gagal di Tambah');
        }
    }

    public function update(Request $request, $id)
    {
        $data = User::findOrFail($id);

        $data->name = $request->nama_klien;
        $data->no_hp = $request->no_hp;

        $data->save();

        if ($data != null) {
            return redirect()->route('admin.klien.index')->with('success', 'Data Berhasil di Update');
        } else {
            return redirect()->route('admin.klien.index')->with('error', 'Data Gagal di Update');
        }
    }

    public function delete($id)
    {
        $data = User::findOrFail($id);

        if ($data != null) {
            $data->delete();
            return redirect()->route('admin.klien.index')->with('success', 'Data Berhasil di Hapus');
        } else {
            return redirect()->route('admin.klien.index')->with('error', 'Data Gagal di Hapus');
        }
    }
}
