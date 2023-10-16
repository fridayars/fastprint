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
                    <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" value="<?= isset($supplier) ? $supplier['nama'] : '' ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="kontak" class="col-sm-2 col-form-label">Kontak</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="kontak" name="kontak" placeholder="kontak" value="<?= isset($supplier) ? $supplier['kontak'] : '' ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="alamat" name="alamat" placeholder="alamat" value="<?= isset($supplier) ? $supplier['alamat'] : '' ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="no_telp" class="col-sm-2 col-form-label">No. Telp</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="no_telp" name="no_telp" placeholder="No. Telp" value="<?= isset($supplier) ? $supplier['no_telp'] : '' ?>" required>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <?php if (isset($supplier)) { ?>
                    <button type="submit" class="btn btn-info col-md-2">Edit Supplier</button>
                <?php } else { ?>
                    <button type="submit" class="btn btn-info col-md-2">Tambah Supplier</button>
                <?php } ?>
            </div>
            <!-- /.card-footer -->
        </form>
    </div>

</section>
</div>