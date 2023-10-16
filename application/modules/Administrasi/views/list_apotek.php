<section class="content">

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <div class="row">
                <!-- <?php if ($_SESSION['role_id'] == 1 && $_SESSION['toko_id'] == 1) { ?>
                <div class="col-md-3">
                    <a type="button" href="<?= base_url() ?>Administrasi/Stok_apotek/add" class="btn btn-block btn-success btn-sm ">Entry Data</a>
                </div>
                <?php }?>
                <?php if ($_SESSION['toko_id'] != 1) { ?>
                <div class="col-md-3">
                    <a type="button" href="<?= base_url() ?>Administrasi/Stok_apotek/add" class="btn btn-block btn-success btn-sm ">Entry Data</a>
                </div>
                <?php }?> -->
                <!-- <div class="col-md-3">
                    <a type="button" href="#" class="btn btn-block btn-warning btn-sm ">Import Data</a>
                </div> -->
                <div class="col-md-3">
                    <a type="button" href="<?= base_url() ?>Administrasi/Stok_apotek/excel_products" class="btn btn-block btn-warning btn-sm">Export Full Data</a>
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="kt_table_1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>KODE</th>
                        <th>NAMA PRODUK/OBAT/BAHAN</th>
                        <th>KATEGORI PRODUK</th>
                        <!-- <th>JUMLAH</th>
                        <th>UNIT</th> -->
                        <th>HARGA</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($obats as $obat) { ?>
                        <tr>
                            <td><?= $obat['kode'] ?></td>
                            <td><?= $obat['nama'] ?></td>
                            <td><?= $obat['kategori'] ?></td>
                            <!-- <td><?= $obat['jumlah'] ?></td>
                            <td><?= $obat['unit_nama'] ?></td> -->
                            <td>Rp. <?=number_format($obat['harga_jual']) ?></td>
                            <td>
                                <a href="<?= base_url() ?>Administrasi/Stok_apotek/read/<?= $obat['kode'] ?>" class="btn btn-sm btn-info">Lihat Detail</a>
                                <!-- <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-icon" data-toggle="dropdown">Proses
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="<?= base_url() ?>Administrasi/Stok_apotek/edit/<?= $obat['kode'] ?>">Edit</a>
                                        <?php if($_SESSION['role_id']==1){?>
                                        <a class="dropdown-item" href="<?= base_url() ?>Administrasi/Stok_apotek/delete/<?= $obat['kode'] ?>">Hapus</a>
                                        <?php } ?>    
                                    </div>
                                </div> -->
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

</section>
<script type="text/javascript">
    $(document).ready(function() {
        $('#kt_table_1').DataTable({
            "responsive": true,
            "autoWidth": false,
            "order": [
                [1, "asc"]
            ]
        });
    });
</script>
</div>