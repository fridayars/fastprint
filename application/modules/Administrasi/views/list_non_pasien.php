<section class="content">

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <div class="row">
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
                        <th>No.RM</th>
                        <th>NAMA PASIEN</th>
                        <th>ALAMAT</th>
                        <th>EMAIL</th>
                        <th>L/P</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pasiens as $pasien) { ?>
                        <tr>
                            <td><?= $pasien['no_rm'] ?></td>
                            <td><?= $pasien['nama'] ?></td>
                            <td><?= $pasien['alamat'] ?></td>
                            <td><?= $pasien['email'] ?></td>
                            <td><?= $pasien['jenis_kelamin'] ?></td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-icon" data-toggle="dropdown">Proses
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="<?= base_url() ?>Administrasi/Pasien/pindah/<?= $pasien['no_rm'] ?>">Pindah Ke Data Pasien</a>
                                        <a class="dropdown-item" href="<?= base_url() ?>Administrasi/Pasien/delete/<?= $pasien['no_rm'] ?>">Hapus Pasien</a>
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
    $(document).ready(function() {
        $('#kt_table_1').DataTable({
            "responsive": true,
            "autoWidth": false,
        });
    });
</script>
</div>