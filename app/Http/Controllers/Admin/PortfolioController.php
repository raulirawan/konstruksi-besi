<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Portfolio;
use App\User;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolio = Portfolio::all();
        return view('Admin.portfolio.index', compact('portfolio'));
    }

    public function store(Request $request)
    {
        $data = new User();
        $data->name = $request->nama_portfolio;
        $data->email = $request->email;
        $data->password = bcrypt($request->password);
        $data->no_hp = $request->no_hp;
        $data->roles = 'PORTFOLIO';
        $data->save();

        if($data != null) {
            return redirect()->route('admin.portfolio.index')->with('success','Data Berhasil di Tambah');
        } else {
            return redirect()->route('admin.portfolio.index')->with('error','Data Gagal di Tambah');
        }
    }

    public function update(Request $request, $id)
    {
        $data = User::findOrFail($id);

        $data->name = $request->nama_portfolio;
        $data->no_hp = $request->no_hp;

        $data->save();

        if($data != null) {
            return redirect()->route('admin.portfolio.index')->with('success','Data Berhasil di Update');
        } else {
            return redirect()->route('admin.portfolio.index')->with('error','Data Gagal di Update');
        }
    }

    public function delete($id)
    {
        $data = User::findOrFail($id);

        if($data != null) {
            $data->delete();
            return redirect()->route('admin.portfolio.index')->with('success','Data Berhasil di Hapus');
        } else {
            return redirect()->route('admin.portfolio.index')->with('error','Data Gagal di Hapus');
        }
    }
}
