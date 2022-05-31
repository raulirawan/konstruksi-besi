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
        $data = new Portfolio();
        $data->nama_project = $request->nama_project;
        $data->harga_jual = $request->harga_jual;
        $data->harga_jual_pasang = $request->harga_jual_pasang;

        if($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $tujuan_upload = 'image/portfolio/';
            $nama_file = time()."_".$file->getClientOriginalName();
            $nama_file = str_replace(' ', '', $nama_file);
            $file->move($tujuan_upload,$nama_file);

            $data->gambar = $tujuan_upload.$nama_file;
        }

        $data->save();

        if($data != null) {
            return redirect()->route('admin.portfolio.index')->with('success','Data Berhasil di Tambah');
        } else {
            return redirect()->route('admin.portfolio.index')->with('error','Data Gagal di Tambah');
        }
    }

    public function update(Request $request, $id)
    {
        $data = Portfolio::findOrFail($id);

        $data->nama_project = $request->nama_project;
        $data->harga_jual = $request->harga_jual;
        $data->harga_jual_pasang = $request->harga_jual_pasang;

        if($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $tujuan_upload = 'image/portfolio/';
            $nama_file = time()."_".$file->getClientOriginalName();
            $nama_file = str_replace(' ', '', $nama_file);
            $file->move($tujuan_upload,$nama_file);
            if(file_exists($data->gambar)) {
                unlink($data->gambar);
            }
            $data->gambar = $tujuan_upload.$nama_file;
        }

        $data->save();

        if($data != null) {
            return redirect()->route('admin.portfolio.index')->with('success','Data Berhasil di Update');
        } else {
            return redirect()->route('admin.portfolio.index')->with('error','Data Gagal di Update');
        }
    }

    public function delete($id)
    {
        $data = Portfolio::findOrFail($id);

        if($data != null) {
            if(file_exists($data->gambar)) {
                unlink($data->gambar);
            }
            $data->delete();
            return redirect()->route('admin.portfolio.index')->with('success','Data Berhasil di Hapus');
        } else {
            return redirect()->route('admin.portfolio.index')->with('error','Data Gagal di Hapus');
        }
    }
}
