<?php
function String2Date($dTgl)
{
  //return 22-11-2012  
  list($cYear, $cMount, $cDate) = explode("-", $dTgl);
  if (strlen($cYear) == 4) {
    $dTgl = $cDate . "-" . $cMount . "-" . $cYear;
  }
  return $dTgl;
}
$stockawal = $this->model->code("SELECT * FROM tb_stock_produk_history WHERE LEFT(tanggal, 7) = '" . $tahun . '-' . $bulan . "' AND id_barang = '" . $idbarang . "' AND toko_id = ".$_SESSION['toko_id']." ORDER BY tanggal DESC LIMIT 1");
$stockawal = $stockawal[0];
?>
<table cellspacing="0" id="advanced-table" class="table dt-responsive nowrap table-small-font table-bordered table-striped">
  <thead>
    <tr>
      <th>Tanggal</th>
      <th>Jumlah Awal</th>
      <th>Pemasukan</th>
      <th>Pengeluaran</th>
      <th>Jumlah Akhir</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $queryout = $this->model->code("SELECT SUM(B.jumlah) as jumlah, A.tanggal, B.obat_id FROM penjualan A LEFT JOIN penjualan_detail B ON B.penjualan_id = A.id AND B.toko_id = A.toko_id WHERE LEFT(A.tanggal, 7) = '" . $tahun . '-' . $bulan . "' AND B.obat_id = '" . $idbarang . "' AND A.status = 3 AND A.toko_id = ".$_SESSION['toko_id']." GROUP BY A.tanggal");
    foreach ($queryout as $index => $value) {
      $arrqueryout[$value['tanggal']] = $value['jumlah'];
    }
    $nJumlahHari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
    for ($i = 1; $i <= $nJumlahHari; $i++) {
      if ($i > 9) {
        $cNol = "";
      } else {
        $cNol = "0";
      }
      $date = $tahun . "-" . $bulan . "-" . $cNol . $i;
      $no = 0;

    ?>
      <tr>
        <td><?= String2Date($date) ?></td>
        <td>
          <?php
          /*$queryStock = $this->model->code("SELECT sum(jumlah) as total FROM v_terima_produk WHERE tgl_terima < '".String2Date($date)."' AND id_barang = '".$idbarang."'");
                foreach ($queryStock as $key => $vaAwal) {
                  $pembelian = $vaAwal['total'];
                }

              $queryKluar = $this->model->code("SELECT sum(jumlah) as total FROM detail_pengeluaran_kemasan WHERE tanggal < '".String2Date($date)."' AND id_barang = '".$idbarang."'");
              foreach ($queryKluar as $key => $vaAkhir) {
                  $pengeluaran = $vaAkhir['total'];
              }

              
              $total =  $pembelian-$pengeluaran;*/

          ?>
          <?php
          $besok = mktime(0, 0, 0, date("m"), date("d") + 1, date("Y"));
          if ($date <  date('Y-m-d', $besok)) { ?>
            <b><?php echo ($stockawal['jumlah'] == 0) ? "" : number_format($stockawal['jumlah']); ?></b>
          <?php } ?>
        </td>
        <td>
          <?php
          //echo $date; 
          $queryAwal = $this->model->code("SELECT * FROM terima_produk WHERE tgl_terima = '" . $date . "' AND id_barang = '" . $idbarang . "' AND toko_id = ".$_SESSION['toko_id']."");
          $ix = 0;
          foreach ($queryAwal as $key => $vaAwal) {
            $stockawal['jumlah'] += $vaAwal['jumlah'];
            echo "Stock Masuk : " . number_format($vaAwal['jumlah']) . "<br>";
            $ix++;
          }
          $queryAwal = array();
          ?>
          <?php
          $besok = mktime(0, 0, 0, date("m"), date("d") + 1, date("Y"));
          if ($date <  date('Y-m-d', $besok)) {
          ?>
            <?php if ($ix == 0) echo 0; ?>
          <?php } ?>
        </td>
        <td>
          <?php
          if (@$arrqueryout[$date] != "") {
            echo 'Penjualan : ' . $arrqueryout[$date];
            $stockawal['jumlah'] -= $arrqueryout[$date];
          }
          $besok = mktime(0, 0, 0, date("m"), date("d") + 1, date("Y"));
          if ($date <  date('Y-m-d', $besok)) {
          ?>
            <?php if (@$arrqueryout[$date] == "") echo 0; ?>
          <?php } ?>
          
          <!-- penyesuaian stok -->
          <?php
          $queryAkhir = $this->model->code("SELECT * FROM penyesuaian_stok_akhir WHERE tanggal = '" . $date . "' AND id_barang = '" . $idbarang . "' AND toko_id = ".$_SESSION['toko_id']."");
          $ix = 0;
          foreach ($queryAkhir as $key => $vaAkhir) {
            $stockawal['jumlah'] -= $vaAkhir['stok_edit'];
            echo "<br>" . "Penyesuaian Stok : " . number_format($vaAkhir['stok_edit']);
            $ix++;
          }
          $queryAkhir = array();
          ?>
          <?php
          $besok = mktime(0, 0, 0, date("m"), date("d") + 1, date("Y"));
          if ($date <  date('Y-m-d', $besok)) {
          ?>
            <?php if ($ix == 0) echo ''; ?>
          <?php } ?>
        </td>
        <td> <b>
            <?php
            $besok = mktime(0, 0, 0, date("m"), date("d") + 1, date("Y"));
            if ($date <  date('Y-m-d', $besok)) {
            ?>
              <?= ($stockawal['jumlah'] == 0) ? "" : number_format($stockawal['jumlah']); ?>
            <?php } ?>
          </b></td>
      </tr>
    <?php } ?>
  </tbody>
</table>
<!--<a href="<?= base_url() ?>Administrator/Stock/laporan_stock_satuan_produk/<?= $bulan ?>/<?= $tahun ?>/<?= $idbarang ?>" target="_blank" class="btn btn-warning waves-effect waves-light"> <i class="fa fa-print"></i> Print Laporan</a>-->