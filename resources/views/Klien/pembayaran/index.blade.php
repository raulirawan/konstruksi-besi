@extends('layouts.dashboard-admin')

@section('title','Halaman Pembayaran')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Pembayaran</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Pembayaran</li>
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
                    <h3 class="card-title">Data Pembayaran</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive">

                    <table id="example1"
                        class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10%">Tanggal Transaksi</th>
                                <th>Kode</th>
                                <th>Nama Project</th>
                                <th>Gambar</th>
                                <th>Tipe Transaksi</th>
                                <th>Status</th>
                                <th style="width: 5%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksi as $val)
                                <tr>
                                    <td>{{ $val->created_at }}</td>
                                    <td>{{ $val->kode_transaksi }}</td>
                                    <td>{{ $val->portfolio->nama_project }}</td>
                                    <td>
                                        <img src="{{ url($val->portfolio->gambar) }}" alt="" style="width: 100px">
                                    </td>
                                    <td>{{ $val->tipe_transaksi }}</td>
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
                                    <td>
                                        <a href="{{ route('pembayaran.detail', $val->id) }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
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

@push('down-script')

    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": false,
                "lengthChange": false,
                "autoWidth": false,
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": false,
                "info": false,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@endpush
@endsection
