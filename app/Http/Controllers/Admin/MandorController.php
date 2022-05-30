<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class MandorController extends Controller
{
    public function index()
    {
        $mandor = User::where('roles', 'MANDOR')->get();
        return view('Admin.mandor.index', compact('mandor'));
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
        $data->name = $request->nama_mandor;
        $data->email = $request->email;
        $data->password = bcrypt($request->password);
        $data->no_hp = $request->no_hp;
        $data->roles = 'MANDOR';
        $data->save();

        if ($data != null) {
            return redirect()->route('admin.mandor.index')->with('success', 'Data Berhasil di Tambah');
        } else {
            return redirect()->route('admin.mandor.index')->with('error', 'Data Gagal di Tambah');
        }
    }

    public function update(Request $request, $id)
    {
        $data = User::findOrFail($id);

        $data->name = $request->nama_mandor;
        $data->no_hp = $request->no_hp;

        $data->save();

        if ($data != null) {
            return redirect()->route('admin.mandor.index')->with('success', 'Data Berhasil di Update');
        } else {
            return redirect()->route('admin.mandor.index')->with('error', 'Data Gagal di Update');
        }
    }

    public function delete($id)
    {
        $data = User::findOrFail($id);

        if ($data != null) {
            $data->delete();
            return redirect()->route('admin.mandor.index')->with('success', 'Data Berhasil di Hapus');
        } else {
            return redirect()->route('admin.mandor.index')->with('error', 'Data Gagal di Hapus');
        }
    }
}
