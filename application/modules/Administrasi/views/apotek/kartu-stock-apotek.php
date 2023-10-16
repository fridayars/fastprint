
<section class="content">

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Input Obat / Bahan Masuk</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fas fa-times"></i></button>
            </div>
        </div>
        <div class="card-body"><div class="row">
  <div class="col-lg-3 col-xl-3">
    <div class="kt-portlet">
      <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
          <h3 class="kt-portlet__head-title">
            PILIH BULAN / TAHUN
          </h3>
        </div>
      </div>
      <div class="kt-portlet__body">
        <div class="form-group">
          <select name="cBulan" id="pilihBulan" ng-model="cBulan" class="form-control">
            <option></option>
            <option value="01">Januari</option>
            <option value="02">Februari</option>
            <option value="03">Maret</option>
            <option value="04">April</option>
            <option value="05">Mei</option>
            <option value="06">Juni</option>
            <option value="07">Juli</option>
            <option value="08">Agustus</option>
            <option value="09">September</option>
            <option value="10">Oktober</option>
            <option value="11">November</option>
            <option value="12">Desember</option>
          </select>
        </div>

        <div class="form-group">
          <select name="cTahun" id="pilihTahun" class="form-control">
            <option></option>
            <option value="2021">2021</option>
            <option value="2022">2022</option>
            <option value="2023">2023</option>
            <option value="2024">2024</option>
            <option value="2025">2025</option>
          </select>
        </div>


      </div>
      <div class="kt-portlet__foot">
        <div class="kt-form__actions">
          <button type="button" class="btn btn-primary waves-effect waves-light " data-toggle="tooltip" data-placement="top" title="Tampilkan Stock" onclick="showKartuStok()">
            <i class="fas fa-book-open"></i><span class="m-l-10">Tampilkan Stock </span>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-9 col-xl-9">

    <!--begin::Portlet-->
    <div class="kt-portlet">
      <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
          <h3 class="kt-portlet__head-title">
            Data Stock
          </h3>
        </div>
      </div>

      <div class="kt-portlet__body">
        <div class="form-group">
          <div class="panel-body">
            <div content="table" id="show_kartu">

            </div>
          </div>
          <div class="panel-footer txt-primary">
            Monitoring
          </div>
        </div>

      </div>


    </div>
  </div>
</div>

</button>
</div>
</div>
</div>
</div>
</div>

<script type="text/javascript">
  function showKartuStok() {
    var cBulan = $('#pilihBulan').val();
    var cTahun = $('#pilihTahun').val();
    $.ajax({
      type: "POST",
      data: "bulan=" + cBulan +
        "&tahun=" + cTahun,
      url: "<?php echo site_url('Administrasi/Stok_apotek/tampil_stock_produk') ?>",
      cache: false,
      success: function(msg) {
        $('#show_kartu').html(msg);
      }
    });
  }
</script>