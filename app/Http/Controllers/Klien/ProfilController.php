<?php

namespace App\Http\Controllers\Klien;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function index()
    {
        return view('Klien.profil.index');
    }

    public function update(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();
        $user->name = $request->name;
        $user->no_hp = $request->no_hp;
        $user->alamat = $request->alamat;
        $user->save();


        if($user != null) {
            return redirect()->route('klien.profile.index')->with('success','Data Berhasil di Update');
        } else {
            return redirect()->route('klien.profile.index')->with('error','Data Gagal di Update');
        }
    }

}
