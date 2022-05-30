@extends('layouts.dashboard-admin')

@section('title','Halaman Detail Transaksi')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Detail Transaksi</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Transaksi</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <div class="row">
          <div class="col-12">
            @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Detail Transaksi</h3>
                  <a href="{{ route('admin.transaksi.index') }}" class="btn btn-primary mt-3 btn-xs" style="float: right">Kembali</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table class="table table-bordered">

                    <tbody>
                        <tr>
                            <th style="width: 400px">Tanggal Transaksi</th>
                            <td>{{ $transaksi->created_at }}</td>
                        </tr>
                        <tr>
                            <th style="width: 400px">Kode Transaksi</th>
                            <td>{{ $transaksi->kode_transaksi }}</td>
                        </tr>
                        <tr>
                            <th style="width: 400px">Nama Mandor</th>
                            <td>{{ $transaksi->mandor->name ?? '' }}</td>
                        </tr>
                        <tr>
                            <th style="width: 400px">Nama Klien</th>
                            <td>{{ $transaksi->klien->name }}</td>
                        </tr>
                        <tr>
                            <th style="width: 400px">Nama Project</th>
                            <td>{{ $transaksi->portfolio->nama_project }}</td>
                        </tr>
                        <tr>
                            <th style="width: 400px">Tipe Transaksi</th>
                            <td>{{ $transaksi->tipe_transaksi }}</td>
                        </tr>
                        <tr>
                            <th style="width: 400px">Status</th>
                            @if ($transaksi->status == 'SUDAH DP')
                            <td>
                                <span class="badge badge-success">SUDAH DP</span>
                            </td>
                            @elseif ($transaksi->status == 'PENDING')
                            <td>
                                <span class="badge badge-warning">PENDING</span>
                            </td>
                            @elseif ($transaksi->status == 'LUNAS')
                            <td>
                                <span class="badge badge-success">LUNAS</span>
                            </td>
                            @else
                            <td>
                                <span class="badge badge-danger">BATAL</span>
                            </td>

                            @endif
                        </tr>
                        <tr>
                            <th style="width: 400px">Total Harga</th>
                            <td>Rp{{ number_format($transaksi->total_harga) }}</td>
                        </tr>

                    </tbody>
                  </table>

                </div>

              </div>

              <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Pembayaran</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive">
                    <button type="button" class="btn btn-primary btn-sm mb-3" data-toggle="modal"
                    data-target="#exampleModal">
                    (+) Tambah Pembayaran Transaksi {{ $transaksi->kode_transaksi }}
                </button>
                    <table id="table-data"
                        class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Kode Pembayaran</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th>Total Bayar</th>
                                <th style="width: 5%">Link</th>
                                <th style="width: 5%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pembayaran as $val)
                                <tr>
                                    <td>{{ $val->kode_pembayaran }}</td>
                                    <td>{{ $val->keterangan }}</td>
                                    @if ($val->status == 'SUDAH DP')
                                    <td>
                                        <span class="badge badge-success">SUDAH DP</span>
                                    </td>
                                    @elseif ($val->status == 'PENDING')
                                    <td>
                                        <span class="badge badge-warning">PENDING</span>
                                    </td>
                                    @elseif ($val->status == 'LUNAS')
                                    <td>
                                        <span class="badge badge-success">LUNAS</span>
                                    </td>
                                    @else
                                    <td>
                                        <span class="badge badge-danger">BATAL</span>
                                    </td>
                                    @endif
                                    <td>{{ number_format($val->total_bayar) }}</td>
                                    <td>
                                        <a href="{{ $val->link_pembayaran }}" target="_blank" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.delete.pembayaran', $val->id) }}"
                                            method="POST" style='float: left; padding-left: 5px;'>
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin ?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Tambah Data Pembayaran Transaksi {{ $transaksi->kode_transaksi }}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <form method="POST" action="{{ route('admin.add.pembayaran', $transaksi->id) }}" enctype="multipart/form-data">
                  @csrf
                  <div class="card-body">
                      <div class="form-group">
                          <label for="exampleInputEmail1">Jumlah Pembayaran</label>
                          <input type="number" class="form-control"
                              value="{{ old('total_bayar') }}" name="total_bayar" placeholder="Masukan Jumlah Pembayaran" required>
                      </div>
                      <div class="form-group">
                          <label for="exampleInputEmail1">Keterangan</label>
                         <textarea name="keterangan" id="keterangan" placeholder="Masukan Keterangan" class="form-control" required></textarea>
                      </div>
                  </div>

              </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-primary">Simpan Data</button>
          </div>
          </form>

      </div>
  </div>
</div>
@endsection
