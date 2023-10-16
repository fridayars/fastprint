<section class="content">
  <div class="kt-portlet kt-portlet--mobile">


    <!--<div class="card-header"><h5 class="card-header-text">STOCK REAL KEMASAN</h5></div>-->
    <div class="kt-portlet__head kt-portlet__head--lg">
      <div class="kt-portlet__head-label">
        <h3 class="kt-portlet__head-title">
        </h3>
      </div>
      <div class="kt-portlet__head-toolbar">
        <div class="kt-portlet__head-wrapper">
          <div class="kt-portlet__head-actions">

          </div>
        </div>
      </div>
    </div>
    <div class="kt-portlet__body">

      <div dir id="dir" content="table">
        <table id="kt_table_1" class="table table-striped table-bordered nowrap">
          <thead>
            <tr>
              <th>No</th>
              <th>Kode Produk</th>
              <th>Nama Produk</th>
              <th>Stock Produk</th>
              <th>Stock Masuk</th>
              <th>Stock Keluar</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($row as $key => $vaData) { ?>
              <tr>
                <td><?= $no ?></td>
                <td><?= $vaData['kode']?></td>
                <td><?= $vaData['nama'] ?></td>
                <td><?= $vaData['jumlah'] ?></td>
                <td><?= $vaData['stok_awal'] ?></td>
                <td><?= $vaData['stok_akhir'] ?></td>
              </tr>
              <?php $no++; 
            } ?>
          </tbody>
        </table>
      </div>

      <!--end: Datatable -->
    </div>

  </section>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#kt_table_1').DataTable({
        "responsive": true,
        "autoWidth": false,
        "order": [
        [5, "asc"]
        ]
      });
    });
  </script>
</div>
<section class="content">
<div class="kt-portlet kt-portlet--mobile">


  <!--<div class="card-header"><h5 class="card-header-text">STOCK REAL KEMASAN</h5></div>-->
  <div class="kt-portlet__head kt-portlet__head--lg">
    <div class="kt-portlet__head-label">
      <!--<span class="kt-portlet__head-icon">
                      <i class="kt-font-brand flaticon2-line-chart"></i>
                    </span>-->
      <h3 class="kt-portlet__head-title">
        <!-- STOCK HARI INI CLINIC - MALANG -->
      </h3>
    </div>
    <div class="kt-portlet__head-toolbar">
      <div class="kt-portlet__head-wrapper">
        <div class="kt-portlet__head-actions">
         
        </div>
      </div>
    </div>
  </div>
  <div class="kt-portlet__body">

    <!--begin: Datatable -->
    <div dir id="dir" content="table">
      <table id="kt_table_1" class="table table-striped table-bordered nowrap">
        <thead>
          <tr>
            <th>No</th>
            <th>Kode Produk</th>
            <th>Nama Produk</th>
            <th>Stock Produk</th>
            <th>Stock Masuk</th>
            <th>Stock Keluar</th>
            <!-- <th>Total Stock</th> -->
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 0;
          
          foreach ($row as $key => $vaData) {
          ?>
            <tr>
              <td><?= ++$no ?></td>
              <td><?= $vaData['kode']?></td>
              <td><?= $vaData['nama'] ?></td>
              <td><?= $vaData['jumlah'] ?></td>
              <td>
                <?php
                   $stockAwal = 0;
                   $queryAwal = $this->model->code("SELECT *, sum(jumlah) AS total FROM terima_produk WHERE tgl_terima = '".date("Y-m-d")."' AND id_barang = '".$vaData['id_barang']."' AND toko_id = ".$_SESSION['toko_id']." GROUP BY tgl_terima");
                   foreach ($queryAwal as $key => $vaStockD) {
                    $stockAwal = $vaStockD['total'];
                   }
                ?>
                <?=$stockAwal?>
              </td>
              <td>
                <?php
                   $stockAkhir = 0;
                  
                   $queryAkhir = $this->model->code("SELECT SUM( B.jumlah ) AS jumlah, A.tanggal, B.obat_id FROM penjualan A LEFT JOIN penjualan_detail B ON B.penjualan_id = A.id AND B.toko_id = A.toko_id WHERE A.tanggal = '".date("Y-m-d")."'  AND B.obat_id = '".$vaData['id_barang']."' AND A.STATUS = 3 AND A.toko_id = ".$_SESSION['toko_id']." GROUP BY A.tanggal");
                   foreach ($queryAkhir as $key => $vaStockD) {
                    $stockAkhir = $vaStockD['jumlah'];
                   }
                ?>
                <?=$stockAkhir?>
              </td>
              <!-- <td><?= ($vaData['jumlah'] + $stockAwal) - $stockAkhir ?></td> -->
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>

    <!--end: Datatable -->
  </div>

</section>
<script type="text/javascript">
    $(document).ready(function() {
        $('#kt_table_1').DataTable({
            "responsive": true,
            "autoWidth": false,
            "order": [
                [2, "asc"]
            ]
        });
    });
</script>
</div>