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
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Order Form</h3>
                    </div>
                    <!-- /.card-header -->
                    <form method="POST" action="{{ route('klien.order.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <input type="hidden" name="portfolio_id" value="{{ $portfolio->id }}">
                                <input type="hidden" name="harga_jual"  id="harga_jual" value="{{ $portfolio->harga_jual }}">
                                <input type="hidden" name="harga_jual_pasang" id="harga_jual_pasang"  value="{{ $portfolio->harga_jual_pasang }}">
                                <label for="exampleInputEmail1">Nama Project</label>
                                <input class="form-control" readonly value="{{ $portfolio->nama_project }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nama Klien</label>
                                <input class="form-control" readonly value="{{ Auth::user()->name }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tipe Transaksi</label>
                                <select name="tipe_transaksi" id="tipe_transaksi" class="form-control" required>
                                    <option value="">Pilih Jenis Transaksi</option>
                                    <option value="BELI">BELI</option>
                                    <option value="BELI DAN PASANG">BELI + PASANG</option>
                                </select>
                            </div>
                            <div class="form-group" id="form-total" style="display: none">
                                <label for="exampleInputEmail1">Total Harga</label>
                                <input type="number" name="total_harga" value="0" id="total_harga" class="form-control" readonly>
                            </div>

                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" onclick="return confirm('Yakin ?')">Order</button>
                        </div>
                </div>
                <!-- /.card-body -->

                </form>
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
    $('#tipe_transaksi').change(function() {
        var tipe_transaksi = $(this).val();

        var harga_jual = $('#harga_jual').val();
        var harga_jual_pasang = $('#harga_jual_pasang').val();


        if(tipe_transaksi == 'BELI') {
            $("#form-total").css("display", "block");
            $("#total_harga").val(harga_jual);
        } else if(tipe_transaksi == 'BELI DAN PASANG') {
            $("#form-total").css("display", "block");
            $("#total_harga").val(harga_jual_pasang);
        } else {
            $("#form-total").css("display", "none");
            $("#total_harga").val(0);
        }

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

