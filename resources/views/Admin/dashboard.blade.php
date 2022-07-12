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
                  <h3>{{ App\User::where('roles','KLIEN')->count() }}</h3>

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
                    <h3>{{ App\Transaksi::where('status','LUNAS')->count() }}</h3>

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
                <h3>{{ App\Transaksi::where('status','PENDING')->count() }}</h3>


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
                    <h3>{{ App\Transaksi::where('status','BATAL')->count() }}</h3>

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
                        <h3 class="card-title">Data Transaksi Masuk</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10%">Tanggal Transaksi</th>
                                    <th>Klien</th>
                                    <th>Project</th>
                                    <th style="width: 10%">Status Transaksi</th>
                                    <th style="width: 10%">Status Pengajuan</th>
                                    <th>Total Harga</th>
                                    <th style="width: 10%">Aksi</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaksi as $item)
                                    <tr>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->klien->name }}</td>
                                        <td>{{ $item->portfolio->nama_project }}</td>
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
                                        @if ($item->is_approve == 'Y')
                                        <td>
                                            <span class="badge badge-success">DI SETUJUI</span>
                                        </td>
                                        @elseif ($item->is_approve == 'P')
                                        <td>
                                            <span class="badge badge-warning">PENDING</span>
                                        </td>
                                        @else
                                        <td>
                                            <span class="badge badge-danger">DI TOLAK</span>
                                        </td>
                                        @endif
                                        <td>{{ number_format($item->total_harga) }}</td>
                                        <td>
                                            <button class="btn btn-success btn-sm" id="accept" data-toggle="modal"
                                            data-target="#exampleModal" data-transaksi_id="{{ $item->id }}"><i class="fa fa-check"></i></button>
                                            <a href="{{ route('admin.reject.transaksi', $item->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ?')"><i class="fa fa-times"></i></a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>

                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Pengajuan Progress</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Jenis Pekerjaan</th>
                                    <th>Mandor</th>
                                    <th>Klien</th>
                                    <th>Project</th>
                                    <th>Gambar</th>
                                    <th>Status</th>
                                    <th style="width: 10%">Aksi</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($progress as $item)
                                    <tr>
                                        <td>{{ $item->jenis_pekerjaan }}</td>
                                        <td>{{ $item->mandor->name }}</td>
                                        <td>{{ $item->transaksi->klien->name }}</td>
                                        <td>{{ $item->portfolio->nama_project }}</td>
                                        <td>
                                            <img src="{{ url($item->gambar) }}" style="width: 100px">
                                        </td>
                                        <td>
                                            <span class="badge badge-warning">PENDING</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.accept.progress', $item->id) }}" class="btn btn-success btn-sm" onclick="return confirm('Yakin ?')"><i class="fa fa-check"></i></a>
                                            <a href="{{ route('admin.reject.progress', $item->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ?')"><i class="fa fa-times"></i></a>
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
              <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Transaksi</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <form method="POST" action="{{ route('admin.accept.transaksi') }}" enctype="multipart/form-data">
                  @csrf
                  <div class="card-body">
                      <div class="form-group">
                          <input type="hidden" name="transaksi_id" value="" id="transaksi_id">
                          <label for="exampleInputEmail1">Nama Mandor</label>
                            <select name="mandor_id" id="mandor_id" class="form-control" required>
                                <option value="">Pilih Mandor</option>
                                @foreach (App\User::where('roles','mandor')->get() as $mandor)
                                    <option value="{{ $mandor->id }}">{{ $mandor->name }}</option>
                                @endforeach
                            </select>
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

  @push('down-script')
  <script>
        $(document).on('click', '#accept', function() {
            var transaksi_id = $(this).data('transaksi_id');

            $('#transaksi_id').val(transaksi_id);
        });
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

