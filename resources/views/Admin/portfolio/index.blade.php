@extends('layouts.dashboard-admin')

@section('title', 'Halaman Portfolio')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Portfolio</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Portfolio</li>
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
                                <h3 class="card-title">Data Portfolio</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#exampleModal">
                                    (+) Tambah Portfolio
                                </button>

                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">No</th>
                                            <th>Nama Project</th>
                                            <th>Gambar</th>
                                            <th>Tipe Bangunan</th>
                                            <th>Model Bangunan</th>
                                            <th>Luas</th>
                                            <th>Harga</th>
                                            <th style="width: 20%">Aksi</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($portfolio as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->nama_project }}</td>
                                                <td>
                                                    <img src="{{ url($item->gambar) }}" style="width: 100px">
                                                </td>
                                                <td>{{ $item->tipe_bangunan }}</td>
                                                <td>{{ $item->model_bangunan }}</td>
                                                <td>{{ $item->luas }}</td>
                                                <td>Rp{{ number_format($item->harga) }}</td>
                                                <td>
                                                    <button type="button" id="edit" data-toggle="modal"
                                                        data-target="#modal-edit"
                                                        data-id="{{ $item->id }}"
                                                        data-nama_project="{{ $item->nama_project }}"
                                                        data-gambar="{{ $item->gambar }}"
                                                        data-tipe_bangunan="{{ $item->tipe_bangunan }}"
                                                        data-model_bangunan="{{ $item->model_bangunan }}"
                                                        data-luas="{{ $item->luas }}"
                                                        data-harga="{{ $item->harga }}"
                                                        class="btn btn-sm btn-primary" style='float: left;'>Edit</button>
                                                    <form action="{{ route('admin.portfolio.delete', $item->id) }}"
                                                        method="POST" style='float: left; padding-left: 5px;'>
                                                        @csrf
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

    <!-- Modal Create -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Portfolio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('admin.portfolio.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nama Portfolio</label>
                                <input type="text" class="form-control"
                                    value="{{ old('nama_portfolio') }}" name="nama_portfolio" placeholder="Masukan Nama Portfolio" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email Portfolio</label>
                                <input type="email" class="form-control"
                                    value="{{ old('email') }}" name="email" placeholder="Masukan Email Portfolio" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Password</label>
                                <input type="password" class="form-control"
                                    value="{{ old('password') }}" name="password" placeholder="Masukan Password" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nomor Handphone</label>
                                <input type="number" class="form-control"
                                    value="{{ old('no_hp') }}" name="no_hp" placeholder="Masukan Nomor Handphone" required>
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


    <!-- Modal Edit -->
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
                                <label for="exampleInputEmail1">Nama Portfolio</label>
                                <input type="text" class="form-control"
                                    value="{{ old('nama_portfolio') }}" name="nama_portfolio" id="nama_portfolio" placeholder="Masukan Nama Portfolio" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nomor Handphone</label>
                                <input type="number" class="form-control"
                                    value="{{ old('no_hp') }}" name="no_hp" id="no_hp" placeholder="Masukan Nomor Handphone" required>
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
                var nama_portfolio = $(this).data('nama_portfolio');
                var no_hp = $(this).data('no_hp');

                $('#nama_portfolio').val(nama_portfolio);
                $('#no_hp').val(no_hp);

                $('#form-edit').attr('action','/admin/portfolio/update/' + id);
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
