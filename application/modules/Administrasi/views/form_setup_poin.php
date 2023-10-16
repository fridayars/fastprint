<section class="content">

    <!-- Horizontal Form -->
    <div class="card card">
        <?php if (validation_errors()) : ?>
            <div class="alert alert-danger" role="alert">
                <?= validation_errors(); ?>
            </div>
        <?php endif; ?>
        <div class="card-header">
            <div class="row">
                <div class="col-md-3">
                    <h3 for="nama" class="col-form-label">Setup Point Reward</h3>
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <form action="" method="post" class="form-horizontal">
            <div class="card-body">
                <div class="form-group row">
                    <label for="transaksi_treatment" class="col-sm-3 col-form-label">Transaksi Treatment Senilai</label>
                    <div class="input-group col-sm-3 mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp.</span>
                        </div>
                        <input type="number" class="form-control" name="transaksi_treatment" id="transaksi_treatment" value="<?= $poin['transaksi_treatment'] ?>" required>
                    </div>
                    <label for="reward_treatment" class="col-sm-3 col-form-label">=> 1 Point</label>
                    <div class="input-group col-sm-3 mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp.</span>
                        </div>
                        <input type="number" class="form-control" name="reward_treatment" id="reward_treatment" value="<?= $poin['reward_treatment'] ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="pembelian_produk" class="col-sm-3 col-form-label">Pembelian Produk Senilai:</label>
                    <div class="input-group col-sm-3 mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp.</span>
                        </div>
                        <input type="number" class="form-control" name="pembelian_produk" value="<?= $poin['pembelian_produk'] ?>" id="pembelian_produk">
                    </div>
                    <label for="reward_produk" class="col-sm-3 col-form-label">=> 1 Point</label>
                    <div class="input-group col-sm-3 mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp.</span>
                        </div>
                        <input type="number" class="form-control" name="reward_produk" id="reward_produk" value="<?= $poin['reward_produk'] ?>" required>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-info">Edit</button>
            </div>
            <!-- /.card-footer -->
        </form>
        <!-- /.card-body -->
    </div>
</section>
</div>