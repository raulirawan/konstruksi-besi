@extends('layouts.dashboard-admin')

@section('title','Halaman Detail Pekerjaan Mandor')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Detail Progress Mandor</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Progress Mandor</li>
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
                    <h3 class="card-title">Data Progress</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive">
                    <button type="button" class="btn btn-primary btn-sm mb-3" data-toggle="modal"
                    data-target="#exampleModal">
                    (+) Tambah Progress
                </button>
                    <table id="example1"
                        class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Jenis Pekerjaan</th>
                                <th>Gambar</th>
                                <th>Progress</th>
                                <th>Status</th>
                                <th style="width: 15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($progress as $val)
                                <tr>
                                    <td>{{ $val->jenis_pekerjaan }}</td>
                                    <td>
                                        <img src="{{ url($val->gambar) }}" alt="" style="width: 100px">
                                    </td>
                                    <td>{{ $val->keterangan }}</td>
                                    @if ($val->is_approve == 'Y')
                                    <td>
                                        <span class="badge badge-success">DI SETUJUI</span>
                                    </td>
                                    @elseif($val->is_approve == 'P')
                                    <td>
                                        <span class="badge badge-warning">PENDING</span>
                                    </td>
                                    @else
                                     <td>
                                        <span class="badge badge-danger">DI TOLAK</span>
                                    </td>
                                    @endif
                                    <td>
                                        <button type="button" id="edit" data-toggle="modal"
                                        data-target="#modal-edit"
                                        data-id="{{ $val->id }}"
                                        data-jenis_pekerjaan="{{ $val->jenis_pekerjaan }}"
                                        data-progress="{{ $val->keterangan }}"
                                        data-gambar="{{ $val->gambar }}"
                                        class="btn btn-sm btn-primary" style='float: left;'>Edit</button>
                                        <form action="{{ route('mandor.delete.progress', $val->id) }}"
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
              <h5 class="modal-title" id="exampleModalLabel">Tambah Data Progress</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <form method="POST" action="{{ route('mandor.add.progress', $transaksi->id) }}" enctype="multipart/form-data">
                  @csrf
                  <div class="card-body">
                      <div class="form-group">
                          <label for="exampleInputEmail1">Jenis Pekerjaan</label>
                          <input type="text" class="form-control"
                              value="{{ old('jenis_pekerjaan') }}" name="jenis_pekerjaan" placeholder="Masukan Jenis Pekerjaan" required>
                      </div>
                      <div class="form-group">
                          <label for="exampleInputEmail1">Progress</label>
                          <input type="text" class="form-control"
                          value="{{ old('progress') }}" name="progress" placeholder="Masukan Progress" required>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Gambar</label>
                        <input type="file" class="form-control"
                        value="{{ old('gambar') }}" name="gambar" required>
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
<div class="modal fade modal-edit" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Data Portfolio</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form method="POST" id="form-edit" action="#" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Jenis Pekerjaan</label>
                        <input type="text" class="form-control"
                            value="{{ old('jenis_pekerjaan') }}" id="jenis_pekerjaan" name="jenis_pekerjaan" placeholder="Masukan Jenis Pekerjaan" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Progress</label>
                        <input type="text" class="form-control"
                        value="{{ old('progress') }}" name="progress" id="progress" placeholder="Masukan Progress" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Gambar</label>
                      <input type="file" class="form-control" name="gambar">
                      <img src="" alt="" id="gambar" class="mt-2" style="width: 100px">
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
    @if (count($errors) > 0)
        <script type="text/javascript">
            $(document).ready(function () {
                $('#exampleModal').modal('show');
            });
        </script>
         <script type="text/javascript">
            $(document).ready(function () {
                $('#modal-edit').modal('show');
            });
        </script>
    @endif
    <script>
        $(document).ready(function() {
            $(document).on('click', '#edit', function() {
                var id = $(this).data('id');
                var jenis_pekerjaan = $(this).data('jenis_pekerjaan');
                var progress = $(this).data('progress');
                var gambar = $(this).data('gambar');
                var url = '{{ url('/') }}';

                $('#jenis_pekerjaan').val(jenis_pekerjaan);
                $('#progress').val(progress);
                $('#gambar').attr('src', url + '/' + gambar);


                $('#form-edit').attr('action','/mandor/update/progress/' + id);
            });
        });
    </script>
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
