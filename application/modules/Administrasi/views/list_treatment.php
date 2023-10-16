<section class="content">

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <div class="row">
                <!-- <div class="col-md-3">
                    <a type="button" href="<?= base_url() ?>Administrasi/Treatment/add" class="btn btn-block btn-success btn-sm">Entry Data</a>
                </div> -->
                <div class="col-md-3">
                    <a type="button" href="<?= base_url() ?>Administrasi/Treatment/excel_treatments" class="btn btn-block btn-warning btn-sm">Export Full Data</a>
                </div>
                <!-- <div class="col-md-3">
                    <a type="button" href="#" class="btn btn-block btn-warning btn-sm ">Import Data</a>
                </div> -->
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="kt_table_1" class="table table-striped-table-bordered table-hover table-checkable">
                <thead>
                    <tr>
                        <th>KODE</th>
                        <th>NAMA JASA/TINDAKAN</th>
                        <th>BAGIAN</th>
                        <th>JENIS</th>
                        <th>TARIF(RP)</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($treatments as $treatment) { ?>
                        <tr>
                            <td><?= $treatment['kode'] ?></td>
                            <td><?= $treatment['nama'] ?></td>
                            <td><?= $treatment['nama_unit'] ?></td>
                            <td><?= $treatment['nama_tipe'] ?></td>
                            <td>Rp <?= number_format($treatment['tarif_umum']) ?></td>
                            <td>
                                <a href="<?= base_url() ?>Administrasi/Treatment/read/<?= $treatment['kode'] ?>" class="btn btn-sm btn-info">Lihat Detail</a>
                                <!-- <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-icon" data-toggle="dropdown">Proses
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="<?= base_url() ?>Administrasi/Treatment/edit/<?= $treatment['kode'] ?>">Edit treatment</a>
                                        <a class="dropdown-item" href="<?= base_url() ?>Administrasi/Treatment/edit_bahan/<?= $treatment['kode'] ?>">Edit Bahan</a>
                                        <a class="dropdown-item" href="<?= base_url() ?>Administrasi/Treatment/delete/<?= $treatment['kode'] ?>">Hapus Treatment</a>
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
        });
    });
</script>
</div>