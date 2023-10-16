<section class="content">

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <h3 class="text-warning"><?= $pasien['no_rm'] ?> - <?= $pasien['nama'] ?></h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>TGL</th>
                        <th>NAMA PRODUK</th>
                        <th>JUMLAH</th>
                        <th>HARGA</th>
                        <th>LOKASI CABANG</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($riwayats as $riwayat) { ?>
                        <tr>
                            <td><?= $riwayat['tanggal'] ?></td>
                            <td><?= $riwayat['obat'] ?></td>
                            <td><?= $riwayat['jumlah'] ?></td>
                            <td>Rp. <?= number_format($riwayat['obat_harga']) ?></td>
                            <td>KLINIK MALANG</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

</section>
</div>