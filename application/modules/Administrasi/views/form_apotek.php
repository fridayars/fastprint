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
                    <label for="nama" class="col-sm-2 col-form-label">Nama Barang</label>
                    <div class="col-sm-8">
                        <input type="text" style="text-transform:uppercase" onkeyup="this.value = this.value.toUpperCase()" class="form-control" id="nama" name="nama" placeholder="Nama" value="<?= isset($obat) ? $obat['nama'] : '' ?>" required>
                    </div>
                    <div class="col-sm-2">
                        <select class="form-control select2bs4" name="tempat_id" style="width: 100%;">
                            <?php foreach ($tempats  as $tempat) { ?>
                                <option value="<?= $tempat['id'] ?>" <?php if (isset($obat)) {
                                                                            if ($obat['tempat_id'] == $tempat['id']) echo 'selected';
                                                                        } ?>><?= $tempat['nama'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="supplier_id" class="col-sm-2 col-form-label">Supplier</label>
                    <div class="col-sm-10">
                        <select class="form-control select2bs4" name="supplier_id" style="width: 100%;" required>
                            <!-- <option value="">Pilih Supplier</option> -->
                            <?php foreach ($suppliers  as $supplier) { ?>
                                <option value="<?= $supplier['id'] ?>" <?php if (isset($obat)) {
                                                                            if ($obat['supplier_id'] == $supplier['id']) echo 'selected';
                                                                        } ?>><?= $supplier['nama'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="jumlah" class="col-sm-2 col-form-label">Jumlah (Jadi Stok Awal)</label>
                    <div class="col-sm-2">
                        <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="jumlah" value="<?= isset($obat) ? $obat['jumlah'] : '' ?>" required>
                    </div>
                    <div class="col-sm-2">
                        <select class="form-control select2bs4" name="tipe_jumlah_id" style="width: 100%;" required>
                            <option value="<?= $tipe_jumlahs[15]['id'] ?>"><?= $tipe_jumlahs[15]['nama'] ?></option>
                            <?php foreach ($tipe_jumlahs  as $tipe_jumlah) { ?>
                                <option value="<?= $tipe_jumlah['id'] ?>" <?php if (isset($obat)) {
                                                                                if ($obat['tipe_jumlah_id'] == $tipe_jumlah['id']) echo 'selected';
                                                                            } ?>><?= $tipe_jumlah['nama'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <label for="min_stok" class="col-sm-1 col-form-label">Min.Stock</label>
                    <div class="col-sm-2">
                        <input type="number" class="form-control" id="min_stock" name="min_stock" placeholder="min_stock" value="<?= isset($obat) ? $obat['min_stock'] : '0' ?>" >
                    </div>
                    <label for="golongan_id" class="col-sm-1 col-form-label">Golongan</label>
                    <div class="col-sm-2">
                        <select class="form-control select2bs4" name="golongan_id" style="width: 100%;" required>
                            <!-- <option value="">Pilih Tipe Jumlah</option> -->
                            <?php foreach ($golongans  as $golongan) { ?>
                                <option value="<?= $golongan['id'] ?>" <?php if (isset($obat)) {
                                                                            if ($obat['golongan_id'] == $golongan['id']) echo 'selected';
                                                                        } ?>><?= $golongan['nama'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="expired_date" class="col-sm-2 col-form-label">Expired Date</label>
                    <div class="col-sm-5">
                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                            <input type="text" name="expired_date" class="form-control datetimepicker-input" data-target="#reservationdate" value="<?= isset($obat) ? date("m/d/Y", strtotime($obat['expired_date'])) : '' ?>" />
                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <label for="kategori_id" class="col-sm-1 col-form-label">Kategori</label>
                    <div class="col-sm-4">
                        <select class="form-control select2bs4" name="kategori_id" style="width: 100%;" required>
                            <!-- <option value="">Pilih Tipe Jumlah</option> -->
                            <?php foreach ($kategoris as $kategori) { ?>
                                <option value="<?= $kategori['id'] ?>" <?php if (isset($obat)) {
                                                                            if ($obat['kategori_id'] == $kategori['id']) echo 'selected';
                                                                        } ?>><?= $kategori['nama'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <?php if ($_SESSION['role_id'] == 1 && $_SESSION['toko_id'] == 1) { ?>                                                      
                <div class="form-group row">
                    <label for="harga_beli" class="col-sm-2 col-form-label">Harga Beli / Satuan Jual</label>
                    <div class="col-sm-3">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="number" class="form-control" id="harga_beli" name="harga_beli" value="<?= isset($obat) ? $obat['harga_beli'] : '0' ?>" >
                        </div>
                    </div>
                    <label for="harga_jual" class="col-sm-2 col-form-label">Harga Jual</label>
                    <div class="col-sm-3">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="number" class="form-control" id="harga_jual" name="harga_jual" value="<?= isset($obat) ? $obat['harga_jual'] : '' ?>" required>
                        </div>
                    </div>
                </div>
                <?php }?>  
                <?php if ($_SESSION['toko_id'] != 1) { ?>                                                      
                <div class="form-group row">
                    <label for="harga_beli" class="col-sm-2 col-form-label">Harga Beli / Satuan Jual</label>
                    <div class="col-sm-3">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="number" class="form-control" id="harga_beli" name="harga_beli" value="<?= isset($obat) ? $obat['harga_beli'] : '0' ?>" >
                        </div>
                    </div>
                    <label for="harga_jual" class="col-sm-2 col-form-label">Harga Jual</label>
                    <div class="col-sm-3">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="number" class="form-control" id="harga_jual" name="harga_jual" value="<?= isset($obat) ? $obat['harga_jual'] : '' ?>" required>
                        </div>
                    </div>
                </div>
                <?php }?>  
                <div class="form-group row">
                    <label for="fee" class="col-sm-2 col-form-label">Fee Penjualan (Obat Bebas)</label>
                    <label for="fee" class="col-sm-1 col-form-label">Dokter</label>
                    <div class="col-sm-2">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="number" class="form-control" id="fee_dokter" name="fee_dokter" value="<?= isset($obat) ? $obat['fee_dokter'] : '' ?>">
                        </div>
                    </div>
                    <label for="fee" class="col-sm-1 col-form-label">Beutician</label>
                    <div class="col-sm-2">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="number" class="form-control" id="fee_beautician" name="fee_beautician" value="<?= isset($obat) ? $obat['fee_beautician'] : '' ?>">
                        </div>
                    </div>
                    <label for="fee" class="col-sm-1 col-form-label">Sales</label>
                    <div class="col-sm-2">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="number" class="form-control" id="fee_sales" name="fee_sales" value="<?= isset($obat) ? $obat['fee_sales'] : '' ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="kode_dokter" class="col-sm-2 col-form-label">Kode Dokter</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="kode_dokter" name="kode_dokter" placeholder="Kode Dokter" value="<?= isset($obat) ? $obat['kode_dokter'] : '' ?>">
                    </div>
                    <label for="diskon_referral" class="col-sm-2 col-form-label">Diskon Referral</label>
                    <div class="col-sm-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="number" class="form-control" id="diskon_referral" name="diskon_referral" value="<?= isset($obat) ? $obat['diskon_referral'] : '' ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="is" class="col-sm-2 col-form-label">Bila dijual, bisa dikeluarkan sbg :</label>
                    <div class="col-sm-2">
                        <div class="form-check">
                            <input class="form-check-input" name="is_obatresep" type="checkbox" value="1" checked>
                            <label class="form-check-label">Obat Resep</label>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-check">
                            <input class="form-check-input" name="is_bebas" type="checkbox" value="1" checked>
                            <label class="form-check-label">Bebas / Langsung</label>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-check">
                            <input class="form-check-input" name="is_referral" type="checkbox" value="1" <?= isset($obat) ? ($obat['is_referral'] == 0 ? '' : 'checked') : '' ?>>
                            <label class="form-check-label">Status Referral</label>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <?php if (isset($obat)) { ?>
                    <button type="submit" class="btn btn-info col-md-2">Edit Produk</button>
                <?php } else { ?>
                    <button type="submit" class="btn btn-info col-md-2">Tambah Produk</button>
                <?php } ?>
            </div>
            <!-- /.card-footer -->
        </form>
    </div>

</section>
</div>