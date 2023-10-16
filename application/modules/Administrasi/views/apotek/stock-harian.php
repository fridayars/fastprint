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
                <td><?= $vaData['stok_masuk'] ?></td>
                <td><?= $vaData['stok_keluar'] ?></td>
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