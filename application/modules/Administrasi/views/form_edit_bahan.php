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
                    <a type="button" href="<?= base_url() ?>Administrasi/Treatment/list_treatment" class="btn btn-block btn-success btn-sm ">Selesai</a>
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>KODE PRODUK</th>
                        <th>NAMA BAHAN</th>
                        <th>JUMLAH</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bahans as $bahan) { ?>
                        <tr>
                            <td><?= $bahan['kode_produk'] ?></td>
                            <td><?= $bahan['nama_produk'] ?></td>
                            <td><?= $bahan['jumlah'] ?></td>
                            <td>
                                <a type="button" href="<?= base_url() ?>Administrasi/Treatment/delete_bahan/<?= $bahan['id'] ?>" class="btn btn-block btn-danger btn-sm">Hapus</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->

        <!-- form start -->
        <form action="" method="post" class="form-horizontal">
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-sm-7">
                        <select class="form-control select2bs4" name="obat_id" style="width: 100%;" required>
                            <option value="">Pilih Bahan</option>
                            <?php foreach ($obats  as $obat) { ?>
                                <option value="<?= $obat['id'] ?>"><?= $obat['nama'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="jumlah pemakaian kabin" required>
                    </div>
                    <button type="submit" class="btn btn-info col-sm-2">Tambahkan</button>
                </div>
            </div>
        </form>
    </div>

</section>
</div>