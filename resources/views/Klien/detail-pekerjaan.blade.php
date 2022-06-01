@extends('layouts.dashboard-admin')

@section('title','Halaman Detail Pekerjaan Mandor')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Detail Progress Transaksi</h1>
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
                    <h3 class="card-title">Progress {{ $transaksi->portfolio->nama_project }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive">

                    <table id="example1"
                        class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Mandor</th>
                                <th>Jenis Pekerjaan</th>
                                <th>Gambar</th>
                                <th>Progress</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($progress as $val)
                                <tr>
                                    <td>{{ $val->mandor->name }}</td>
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
