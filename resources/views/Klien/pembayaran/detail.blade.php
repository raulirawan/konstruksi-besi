@extends('layouts.dashboard-admin')

@section('title','Halaman Detail Pembayaran')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Detail Pembayaran</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Detail Pembayaran</li>
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
                    <h3 class="card-title">Data Detail Pembayaran</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive">

                    <table id="example1"
                        class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Kode Pembayaran</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th>Total Bayar</th>
                                <th style="width: 5%">Link</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pembayaran as $val)
                            <tr>
                                <td>{{ $val->kode_pembayaran }}</td>
                                <td>{{ $val->keterangan }}</td>
                                @if ($val->status == 'PENDING')
                                <td>
                                    <span class="badge badge-warning">PENDING</span>
                                </td>
                                @elseif ($val->status == 'LUNAS')
                                <td>
                                    <span class="badge badge-success">LUNAS</span>
                                </td>
                                @else
                                <td>
                                    <span class="badge badge-danger">GAGAL</span>
                                </td>
                                @endif
                                <td>{{ number_format($val->total_bayar) }}</td>
                                @if ($val->status == 'GAGAL')
                                <td></td>
                                @else
                                <td>
                                    <form action="{{ route('bayar.klien', $val->id) }}" method="POST" target="_blank">
                                    @csrf
                                    <button type="submit" class="btn btn-info btn-sm" onclick="return confirm('Yakin ?')"><i class="fas fa-eye"></i></button>
                                    </form>
                                </td>
                                @endif
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
