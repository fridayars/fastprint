<section class="content">
    <div class="card card-info">
        <div class="card-header">
            <div class="row">
               <h5>Detail Produk</h5>
            </div>
        </div>
        <form action="" method="post" class="form-horizontal">
            <div class="card-body">
                <div class="form-group row">
                    <label for="nama" class="col-sm-2 col-form-label">Nama Produk</label>
                    <div class="col-sm-8">
                        <input type="text" style="text-transform:uppercase" onkeyup="this.value = this.value.toUpperCase()" class="form-control" id="nama" name="nama" placeholder="Nama" value="<?= isset($obat) ? $obat['nama'] : '' ?>" required readonly>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" name="tempat_id" value="<?= $obat['tempat'] ?>" class="form-control" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="supplier_id" class="col-sm-2 col-form-label">Supplier</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="<?= $obat['supplier'] ?>" readonly>
                    </div>
                    <label for="supplier_id" class="col-sm-2 col-form-label">Kategori</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="<?= $obat['kategori'] ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="jumlah" class="col-sm-2 col-form-label">Stok Awal Baru</label>
                    <div class="col-sm-2">
                        <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="jumlah" value="<?= isset($obat) ? $obat['jumlah'] : '' ?>" required readonly>
                    </div>
                    <div class="col-sm-2">
                        <input type="text"class="form-control" value="<?= $obat['unit_nama'] ?>" readonly>
                    </div>
                    <label for="min_stok" class="col-sm-1 col-form-label">Min.Stock</label>
                    <div class="col-sm-2">
                        <input type="number" class="form-control" id="min_stock" name="min_stock" placeholder="min_stock" value="<?= isset($obat) ? $obat['min_stock'] : '0' ?>" readonly>
                    </div>
                    <label for="golongan_id" class="col-sm-1 col-form-label">Golongan</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" value="<?= $obat['golongan'] ?>" readonly>
                    </div>
                </div>                                                   
                <div class="form-group row">
                    <label for="harga_beli" class="col-sm-2 col-form-label">Harga Beli / Satuan Jual</label>
                    <div class="col-sm-3">
                        <div class="input-group ">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="number" class="form-control" id="harga_beli" name="harga_beli" value="<?= isset($obat) ? $obat['harga_beli'] : '0' ?>" readonly>
                        </div>
                    </div>
                    <label for="harga_jual" class="col-sm-2 col-form-label">Harga Jual</label>
                    <div class="col-sm-3">
                        <div class="input-group ">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="number" class="form-control" id="harga_jual" name="harga_jual" value="<?= isset($obat) ? $obat['harga_jual'] : '' ?>" required readonly>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="fee" class="col-sm-2 col-form-label">Fee Penjualan</label>
                    <label for="fee" class="col-sm-1 col-form-label">Dokter</label>
                    <div class="col-sm-2">
                        <div class="input-group ">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="number" class="form-control" id="fee_dokter" name="fee_dokter" value="<?= isset($obat) ? $obat['fee_dokter'] : '' ?>" readonly>
                        </div>
                    </div>
                    <label for="fee" class="col-sm-1 col-form-label">Beutician</label>
                    <div class="col-sm-2">
                        <div class="input-group ">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="number" class="form-control" id="fee_beautician" name="fee_beautician" value="<?= isset($obat) ? $obat['fee_beautician'] : '' ?>" readonly>
                        </div>
                    </div>
                    <label for="fee" class="col-sm-1 col-form-label">Sales</label>
                    <div class="col-sm-2">
                        <div class="input-group ">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="number" class="form-control" id="fee_sales" name="fee_sales" value="<?= isset($obat) ? $obat['fee_sales'] : '' ?>" readonly>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="kode_dokter" class="col-sm-2 col-form-label">Kode Dokter</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="kode_dokter" name="kode_dokter" value="<?= isset($obat) ? $obat['kode_dokter'] : '' ?>" readonly>
                    </div>
                    <label for="diskon_referral" class="col-sm-2 col-form-label">Diskon Referral</label>
                    <div class="col-sm-4">
                        <div class="input-group ">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="number" class="form-control" id="diskon_referral" name="diskon_referral" value="<?= isset($obat) ? $obat['diskon_referral'] : '' ?>" readonly>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="is" class="col-sm-2 col-form-label">Bila dijual, bisa dikeluarkan sbg :</label>
                    <div class="col-sm-2">
                        <div class="form-check">
                            <input class="form-check-input" name="is_obatresep" type="checkbox" value="1" <?= isset($obat) ? ($obat['is_obatresep'] == 0 ? '' : 'checked') : '' ?>>
                            <label class="form-check-label">Obat Resep</label>
                        </div>
                    </div>
                    <div class="col-sm-2">

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
                <a class="btn btn-info col-md-2" href="<?= base_url() ?>Administrasi/Stok_apotek/list_apotek">Kembali</a>
            </div>
            <!-- /.card-footer -->
        </form>
    </div>

</section>
</div>