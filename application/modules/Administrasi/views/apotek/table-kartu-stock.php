
<table cellspacing="0" id="advanced-table" class="table dt-responsive nowrap table-small-font table-bordered table-striped">
  <thead>
    <tr>
      <th>No</th>
      <th>Kode Produk</th>
      <th>Nama Produk</th>
      <th>Stock Hari Ini</th>
      <th>Status</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $no = 0;
    foreach ($row as $key => $vaData) {
    ?>
      <tr>
        <td><?= ++$no ?></td>
        <td><?= $vaData['kode'] ?></td>
        <td><?= $vaData['nama'] ?></td>
        <?php
          if($vaData['jumlah'] <= '500'){
        ?>
        <td style="color:red"><b><?=number_format($vaData['jumlah'])?></b></td>
        <?php }else{?>
          <td><b><?=number_format($vaData['jumlah'])?></b></td>
        <?php } ?>
        <td>
          <?php
          if ($vaData['jumlah'] <= '0') {
                  $kemasan  = 'STOCK HABIS';
                  $label    = 'btn btn-danger';
                } elseif ($vaData['jumlah'] <= $vaData['min_jumlah']) {
                  $kemasan  = 'AKAN HABIS';
                  $label    = 'btn btn-warning';
                } elseif ($vaData['jumlah'] >= $vaData['min_jumlah']) {
                  $kemasan  = 'STOCK TERSEDIA';
                  $label    = 'btn btn-primary';
                }

          ?>
          <strong class="label <?= $label ?>"><?= $kemasan ?></strong>
        </td>
        <td>
          <button type="button" class="btn btn-success waves-effect waves-light " data-toggle="tooltip" data-placement="top" title="Tampilkan Stock" onclick="showKartuStokA('<?= $vaData['id_barang'] ?>','<?= $bulan ?>','<?= $tahun ?>')">
            <i class="fa fa-book-open"></i>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>

<div class="modal fade" id="modal-paket" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">KARTU STOCK</h4>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  function showKartuStokA($idbarang, $bulan, $tahun) {
    $("#modal-paket").modal('show');
    $.ajax({
      type: "POST",

      url: "<?php echo base_url() ?>Administrasi/Stok_apotek/tampil_stock_produk_real/" + $idbarang + "/" + $bulan + "/" + $tahun,
      cache: false,
      success: function(msg) {
        $(".modal-body").html(msg);

      }
    });
  }
</script>