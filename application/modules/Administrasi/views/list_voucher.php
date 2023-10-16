<section class="content">

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-3">
                    <a type="button" href="<?= base_url() ?>Administrasi/Voucher/add" class="btn btn-block btn-success btn-sm">Entry Data</a>
                </div>
                <!-- <div class="col-md-3">
                    <a type="button" href="#" class="btn btn-block btn-danger btn-sm">Export Full Data</a>
                </div> -->
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="kt_table_1" class="table table-striped- table-bordered table-hover table-checkable">
                <thead>
                    <tr>
                        <!-- <th>ID</th> -->
                        <th>NAMA VOUCHER</th>
                        <th>DISKON</th>
                        <th>HARGA POIN</th>
                        <th>STOK</th>
                        <!-- <th>KODE VOUCHER</th> -->
                        <!-- <th>TGL MULAI BERLAKU</th> -->
                        <th>PROSES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($vouchers as $v) { ?>
                        <tr>
                            <!-- <td><?= $v['id'] ?></td> -->
                            <td><?= $v['nama_voucher'] ?></td>
                            <td>
                                <?php if ($v['diskon_tipe'] == "pr"){
                                    echo $v['diskon'] . '%';
                                } elseif ($v['diskon_tipe'] == "rp") {
                                    echo 'Rp '. number_format($v['diskon'],2,',','.');
                                } else{
                                    echo 'Souvenir';
                                }?>
                            </td>
                            <td><?= $v['harga_poin'] ?></td>
                            <td><?= $v['stok_merchant'] ?></td>
                            <!-- <td><?= $v['kode_voucher'] ?></td> -->
                            <!-- <td><?= $v['tgl_mulai'] ?></td> -->
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-icon" data-toggle="dropdown">Proses
                                    </button>
                                    <div class="dropdown-menu">
                                        <!-- <a class="dropdown-item" href="<?= base_url() ?>Administrasi/Voucher/print/<?= $v['id'] ?>">Print Voucher</a> -->
                                        <a class="dropdown-item" href="<?= base_url() ?>Administrasi/Voucher/edit/<?= $v['id'] ?>">Edit Voucher</a>
                                        <a class="dropdown-item" href="<?= base_url() ?>Administrasi/Voucher/delete/<?= $v['id'] ?>">Hapus Voucher</a>
                                    </div>
                                </div>
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
    $("#kt_table_1").DataTable({
        "responsive": true,
        "autoWidth": false,
    });
</script>
</div>