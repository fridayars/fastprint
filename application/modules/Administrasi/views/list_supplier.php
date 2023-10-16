<section class="content">

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-3">
                    <a type="button" href="<?= base_url() ?>Administrasi/Supplier/add" class="btn btn-block btn-success btn-sm">Entry Data</a>
                </div>
                <div class="col-md-3">
                    <a type="button" href="#" class="btn btn-block btn-danger btn-sm">Export Full Data</a>
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="kt_table_1" class="table table-striped- table-bordered table-hover table-checkable">
                <thead>
                    <tr>
                        <th>KODE</th>
                        <th>NAMA PERUSAHAAN</th>
                        <th>ALAMAT</th>
                        <th>TELP</th>
                        <th>KONTAK</th>
                        <th>PROSES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($suppliers as $supplier) { ?>
                        <tr>
                            <td><?= $supplier['kode'] ?></td>
                            <td><?= $supplier['nama'] ?></td>
                            <td><?= $supplier['alamat'] ?></td>
                            <td><?= $supplier['no_telp'] ?></td>
                            <td><?= $supplier['kontak'] ?></td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-icon" data-toggle="dropdown">Proses
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="<?= base_url() ?>Administrasi/Supplier/edit/<?= $supplier['kode'] ?>">Edit Supplier</a>
                                        <a class="dropdown-item" href="<?= base_url() ?>Administrasi/Supplier/delete/<?= $supplier['kode'] ?>">Hapus Supplier</a>
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