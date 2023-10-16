<section class="content">

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <?php if ($_SESSION['toko_id'] != 99) { ?>
            <div class="row">
                <div class="col-md-3">
                    <a type="button" href="<?= base_url() ?>Administrasi/Karyawan/add" class="btn btn-block btn-success btn-sm">Entry Data</a>
                </div>
                <div class="col-md-3">
                    <a type="button" href="#" class="btn btn-block btn-danger btn-sm">Export Full Data</a>
                </div>
                <!-- <div class="col-md-3">
                    <a type="button" href="#" class="btn btn-block btn-warning btn-sm ">Lihat Jadwal</a>
                </div> -->
            </div>
            <?php }?>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="kt_table_1" class="table table-striped- table-bordered table-hover table-checkable">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Lengkap</th>
                        <th>Alamat</th>
                        <th>Telp</th>
                        <th>Jabatan</th>
                        <?php if ($_SESSION['toko_id'] != 99) { ?>
                            <th>ACTION</th>
                        <?php }?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($karyawans as $karyawan) { ?>
                        <tr>
                            <td><?= $karyawan['kode'] ?></td>
                            <td><?= $karyawan['nama'] ?></td>
                            <td><?= $karyawan['alamat'] ?></td>
                            <td><?= $karyawan['no_telp'] ?></td>
                            <td><?= $karyawan['jabatan'] ?></td>
                            <?php if ($_SESSION['toko_id'] != 99) { ?>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-icon" data-toggle="dropdown">Proses
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="<?= base_url() ?>Administrasi/Karyawan/edit/<?= $karyawan['kode'] ?>">Edit Karyawan</a>
                                        <a class="dropdown-item" href="<?= base_url() ?>Administrasi/Karyawan/delete/<?= $karyawan['kode'] ?>">Hapus Karyawan</a>
                                    </div>
                                </div>
                            </td>
                            <?php }?>
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