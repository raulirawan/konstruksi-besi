@extends('layouts.dashboard-admin')

@section('title','Order Klien')

@section('content')
<style>
    .card-img-top {
    max-height: 50vh; /*not want to take all vertical space*/
    object-fit: cover;/*show all image, autosized, no cut, in available space*/
}
.card-title {
    text-align: center !important;
    float: none;
}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Order</h1>
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
                <h3>Halaman Order Konstruksi Besi</h3>
                <div class="row mt-2">
                   @foreach ($portfolio as $item)
                   <div class="col-md-4">
                    <div class="card" style="width: 18rem;">
                        <img src="{{ asset($item->gambar) }}" class="card-img-top img-fluid">
                        <div class="card-body">
                          <h5 class="card-title mb-3">{{ $item->nama_project }}</h5>
                          <table cellspacing="0" cellpadding="0">
                            <tbody>
                            <tr>
                            <td>Harga</td>
                            <td style="width: 5%;">:</td>
                            <td style="width: 10%;" class="text-warning">Rp{{ number_format($item->harga_jual) }}</td>
                            </tr>
                            <tr>
                            <td>Harga + Jasa</td>
                            <td style="width: 5%;">:</td>
                            <td style="width: 10%;" class="text-success">Rp{{ number_format($item->harga_jual_pasang) }}</td>
                            </tr>
                            </tbody>
                            </table>
                            <a href="{{ route('klien.order.form', $item->id) }}" class="btn btn-sm btn-success mt-4 text-center btn-block">Order</a>
                        </div>
                      </div>
                </div>
                   @endforeach

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

