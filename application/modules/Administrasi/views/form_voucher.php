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
                    <label for="nama_voucher" class="col-sm-2 col-form-label">Nama Voucher</label>
                    <div class="col-sm-10">
                        <input type="text" style="text-transform:uppercase" onkeyup="this.value = this.value.toUpperCase()" class="form-control" id="nama_voucher" name="nama_voucher" placeholder="Nama Voucher" value="<?= isset($voucher) ? $voucher['nama_voucher'] : '' ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="diskon" class="col-sm-2 col-form-label">Diskon</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="diskon" name="diskon" placeholder="Diskon" value="<?= isset($voucher) ? $voucher['diskon'] : '' ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="harga_poin" class="col-sm-2 col-form-label">Harga Poin</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="harga_poin" name="harga_poin" placeholder="Harga Poin" value="<?= isset($voucher) ? $voucher['harga_poin'] : '' ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="kode" class="col-sm-2 col-form-label">Kode Voucher</label>
                    <div class="col-sm-10">
                        <?php 
                        if (isset($voucher['kode_voucher'])) {
                            echo "<input type='text' class='form-control' id='kode' disabled name='kode_voucher' placeholder='" . $voucher['kode_voucher'] . "' value='" . $voucher['kode_voucher'] . "' required>";
                        } else {
                            echo "<input type='text' class='form-control' id='kode' disabled name='kode_voucher' placeholder='Kode Voucher' value='' required>";
                        }
                        ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="stok" class="col-sm-2 col-form-label">Stok</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="stok" name="stok" placeholder="Stok" value="<?= isset($voucher) ? $voucher['stok_merchant'] : '' ?>">
                    </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <?php if (isset($voucher)) { ?>
                    <button type="submit" class="btn btn-info col-md-2">Edit Voucher</button>
                <?php } else { ?>
                    <button type="submit" class="btn btn-info col-md-2">Tambah Voucher</button>
                <?php } ?>
            </div>
            <!-- /.card-footer -->
        </form>
    </div>

</section>
</div>