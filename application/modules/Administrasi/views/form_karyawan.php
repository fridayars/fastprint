<section class="content">

    <!-- Horizontal Form -->
    <div class="card card-info">
        <?php if (validation_errors()) : ?>
            <div class="alert alert-danger" role="alert">
                <?= validation_errors(); ?>
            </div>
        <?php endif; ?>
        <!-- form start -->
        <form action="" method="post" class="form-horizontal">
            <div class="card-body">
                <div class="form-group row">
                    <label for="jabatan_id" class="col-sm-2 col-form-label">Jabatan</label>
                    <div class="col-sm-10">
                        <select class="form-control select2bs4" name="jabatan_id" style="width: 100%;" required>
                            <option value="">Pilih Jabatan</option>
                            <?php foreach ($jabatans  as $jabatan) { ?>
                                <option value="<?= $jabatan['id'] ?>" <?php if (isset($karyawan)) {
                                                                            if ($karyawan['jabatan_id'] == $jabatan['id']) echo 'selected';
                                                                        } ?>><?= $jabatan['nama'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                        <input type="text" style="text-transform:uppercase" onkeyup="this.value = this.value.toUpperCase()" class="form-control" id="nama" name="nama" placeholder="Nama" value="<?= isset($karyawan) ? $karyawan['nama'] : '' ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="alamat" name="alamat" placeholder="alamat" value="<?= isset($karyawan) ? $karyawan['alamat'] : '' ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="no_telp" class="col-sm-2 col-form-label">No. Telp</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="no_telp" name="no_telp" placeholder="no_telp" value="<?= isset($karyawan) ? $karyawan['no_telp'] : '' ?>" required>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <?php if (isset($karyawan)) { ?>
                    <button type="submit" class="btn btn-info col-md-2">Edit Karyawan</button>
                <?php } else { ?>
                    <button type="submit" class="btn btn-info col-md-2">Tambah Karyawan</button>
                <?php } ?>
            </div>
            <!-- /.card-footer -->
        </form>
    </div>

</section>
</div>