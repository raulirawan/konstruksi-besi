@extends('layouts.dashboard-admin')

@section('title','Dashboard Klien')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              {{-- <div class="text-muted">Data Statistik di Bawah Ini Merupakan Data Pada Tanggal</div> --}}
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
            <!-- ./col -->
            <div class="col-lg-6 col">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3>{{ App\Transaksi::where('user_id', Auth::user()->id)->count() }}</h3>

                  <p>Data Transaksi</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-6 col">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $countProgress }}</h3>

                  <p>Data Progress</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
              </div>
            </div>
            <!-- ./col -->

            <!-- ./col -->
          </div>


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
                        <h3 class="card-title">Data Transaksi</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10%">Tanggal Transaksi</th>
                                    <th>Project</th>
                                    <th>Mandor</th>
                                    <th>Tipe Transaksi</th>
                                    <th>Total Harga</th>
                                    <th>Status</th>
                                    <th style="width: 10%">Aksi</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaksi as $item)
                                    <tr>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->portfolio->nama_project }}</td>
                                        <td>{{ $item->mandor->name ?? 'Tidak Ada' }}</td>
                                        <td>{{ $item->tipe_transaksi }}</td>
                                        <td>{{ number_format($item->total_harga) }}</td>
                                        @if ($item->status == 'SUDAH DP')
                                        <td>
                                            <span class="badge badge-success">SUDAH DP</span>
                                        </td>
                                        @elseif ($item->status == 'PENDING')
                                        <td>
                                            <span class="badge badge-warning">PENDING</span>
                                        </td>
                                        @elseif ($item->status == 'LUNAS')
                                        <td>
                                            <span class="badge badge-success">LUNAS</span>
                                        </td>
                                        @else
                                        <td>
                                            <span class="badge badge-danger">BATAL</span>
                                        </td>
                                        @endif
                                        <td>
                                            <a href="{{ route('klien.pekerjaan.detail.index', $item->id) }}"  class="btn btn-info btn-sm"><i class="fas fa-eye"></i>Detail</a>
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

