@extends('layouts.dashboard-admin')

@section('title','Dashboard Admin')

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
            <div class="col-lg-3 col">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3>{{ $sukses ?? '' }}</h3>

                  <p>Total Klien</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h3>{{ $pending ?? '' }}</h3>

                  <p>Transaksi Sukses</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col">
              <!-- small box -->
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3>{{ $gagal ?? '' }}</h3>

                  <p>Transaksi Pending</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col">
                <!-- small box -->
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h3>{{ $gagal ?? '' }}</h3>

                    <p>Transaksi Batal</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                  </div>
                </div>
              </div>
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
                        <h3 class="card-title">Data Pengajuan Progress</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th>Klien</th>
                                    <th>Mandor</th>
                                    <th>Project</th>
                                    <th>Gambar</th>
                                    <th>Status</th>
                                    <th style="width: 20%">Aksi</th>

                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($mandor as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        @if ($item->no_hp != NULL)
                                        <td>{{ $item->no_hp }}</td>
                                        @else
                                        <td><span class="badge badge-danger">Tidak Ada</span></td>
                                        @endif
                                        <td>
                                            <button type="button" id="edit" data-toggle="modal"
                                                data-target="#modal-edit" data-id="{{ $item->id }}"
                                                data-nama_mandor="{{ $item->name }}"
                                                data-no_hp="{{ $item->no_hp }}"
                                                class="btn btn-sm btn-primary" style='float: left;'>Edit</button>
                                            <form action="{{ route('admin.mandor.delete', $item->id) }}"
                                                method="POST" style='float: left; padding-left: 5px;'>
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Yakin ?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach --}}

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

