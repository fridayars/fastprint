<section class="content">

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-3">
                    <button type="button" class="btn btn-block btn-success btn-sm" data-toggle="modal" data-target="#modal-default">Entry Data</button>
                </div>
                <div class="col-md-3">
                    <a type="button" href="<?= base_url() ?>Administrasi/MasterProduct/excel_products" class="btn btn-block btn-warning btn-sm">Export Full Data</a>
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <?php if ($this->session->flashdata('success')) : ?>
				<div class="alert alert-success" role="alert" id="success-alert" style="margin-bottom: 30px">
					<button type="button" class="close" data-dismiss="alert">
						<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
					</button>
					<span class="glyphicon glyphicon-exclamation-sign"></span>
					<strong>Sukses! </strong> <?= $this->session->flashdata('success'); ?>
				</div>
			<?php endif; ?>

			<?php if ($this->session->flashdata('error')) : ?>
				<div class="alert alert-danger" role="alert" id="error-alert" style="margin-bottom: 30px">
					<button type="button" class="close" data-dismiss="alert">
						<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
					</button>
					<span class="glyphicon glyphicon-exclamation-sign"></span>
					<strong>Failed! </strong> <?= $this->session->flashdata('error'); ?>
				</div>
			<?php endif; ?>
            <table id="kt_table_1" class="table table-striped-table-bordered table-hover table-checkable">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>NAMA PRODUCT</th>
                        <th>HARGA JUAL</th>
                        <th>KATEGORI</th>
                        <th style="text-align: center;">REFERRAL STATUS</th>
                        <th>PROSES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($master_product as $product) { ?>
                        <tr>
                            <td><?= $no; ?></td>
                            <td><?= $product['nama'] ?></td>
                            <td>Rp <?= number_format($product['harga_jual']) ?></td>
                            <td><?= $product['kategori'] ?></td>
                            <td style="text-align: center;"><?= ($product['is_referral'] == 0) ? '<i style="color:grey" class="fa fa-ban"></i>' : '<i style="color:green" class="fa fa-check"></i>'; ?></td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-edit<?= $product['id'] ?>">Edit</button>
                                <a class="btn btn-danger btn-sm" href="<?= base_url() ?>Administrasi/MasterProduct/delete/<?= $product['id'] ?>">Hapus</a>
                            </td>
                        </tr>
                    <?php $no++; } ?>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
    <!-- modal tambah -->
    <div class="modal fade bd-example-modal-lg" id="modal-default">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Master Product</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
                <?= form_open('Administrasi/MasterProduct/add');?>
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group">
                            <label for="kategori">Nama Product</label>
                            <input type="text" style="text-transform:uppercase" onkeyup="this.value = this.value.toUpperCase()" name="input[nama]" required class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="kategori">Tempat</label>
                            <select class="form-control select2bs4" name="input[tempat_id]" style="width: 100%;" required>
                                <?php foreach ($tempats as $tempat) { ?>
                                    <option value="<?= $tempat['id'] ?>"><?= $tempat['nama'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="kategori">Supplier</label>
                            <select class="form-control select2bs4" name="input[supplier_id]" style="width: 100%;" required>
                                <?php foreach ($suppliers as $supplier) { ?>
                                    <option value="<?= $supplier['id'] ?>"><?= $supplier['nama'] ?></option>
                                <?php } ?>
                            </select>                    
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="kategori">Golongan</label>
                            <select class="form-control select2bs4" name="input[golongan_id]" style="width: 100%;" required>
                                <?php foreach ($golongans as $golongan) { ?>
                                    <option value="<?= $golongan['id'] ?>"><?= $golongan['nama'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="kategori">Kategori</label>
                            <select class="form-control select2bs4" name="input[kategori_id]" style="width: 100%;" required>
                                <option value="">Pilih Kategori</option>
                                <?php foreach ($kategoris as $kategori) { ?>
                                    <option value="<?= $kategori['id'] ?>"><?= $kategori['nama'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kategori">Harga Jual</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" name="input[harga_jual]" required class="form-control" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kategori">Harga Beli</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" name="input[harga_beli]" required class="form-control" value="0">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="kategori">Stok Awal Baru</label>
                            <input type="number" class="form-control" name="input[stok_awal_baru]" value="0" required>                    
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="kategori">Tipe Jumlah</label>
                            <select class="form-control select2bs4" name="input[tipe_jumlah_id]" style="width: 100%;" required>
                                <?php foreach ($tipe_jumlahs as $tipe_jumlah) { ?>
                                    <option value="<?= $tipe_jumlah['id'] ?>"><?= $tipe_jumlah['nama'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="kategori">Minimal Stock</label>
                            <input type="number" class="form-control" name="input[min_stock]" value="0" required>                    
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="kategori">Fee Dokter</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" name="input[fee_dokter]" required class="form-control" value='0'>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="kategori">Fee Beautician</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" name="input[fee_beautician]" required class="form-control" value='0'>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="kategori">Fee Sales</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" name="input[fee_sales]" required class="form-control" value='0'>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kategori">Kode Dokter</label>
                            <input type="text" style="text-transform:uppercase" onkeyup="this.value = this.value.toUpperCase()" name="input[kode_dokter]" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kategori">Diskon Referral</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" name="input[diskon_referral]" class="form-control" value='0'>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <div class="form-check">
                            <input class="form-check-input" name="input[is_obatresep]" type="checkbox" value="1">
                            <label class="form-check-label"><b>Obat Resep</b></label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-check">
                            <input class="form-check-input" name="input[is_referral]" type="checkbox" value="1">
                            <label class="form-check-label"><b>Status Referral</b></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-primary">Simpan</button>
              <?= form_close(); ?>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

      <!-- modal edit -->
      <?php $no = 1; foreach ($master_product as $product) { ?>
        <div class="modal fade bd-example-modal-lg" id="modal-edit<?= $product['id'] ?>">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Master Product</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
                <?= form_open('Administrasi/MasterProduct/edit/'. $product['id']);?>
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group">
                            <label for="kategori">Nama Product</label>
                            <input type="text" style="text-transform:uppercase" onkeyup="this.value = this.value.toUpperCase()" name="input[nama]" required class="form-control" value="<?= $product['nama'] ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="kategori">Tempat</label>
                            <select class="form-control select2bs4" name="input[tempat_id]" style="width: 100%;" required>
                                <?php foreach ($tempats as $tempat) { ?>
                                    <option value="<?= $tempat['id'] ?>" <?= ($product['tempat_id'] == $tempat['id']) ? 'selected' : '' ?>><?= $tempat['nama'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="kategori">Supplier</label>
                            <select class="form-control select2bs4" name="input[supplier_id]" style="width: 100%;" required>
                                <?php foreach ($suppliers as $supplier) { ?>
                                    <option value="<?= $supplier['id'] ?>" <?= ($product['supplier_id'] == $supplier['id']) ? 'selected' : '' ?>><?= $supplier['nama'] ?></option>
                                <?php } ?>
                            </select>                    
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="kategori">Golongan</label>
                            <select class="form-control select2bs4" name="input[golongan_id]" style="width: 100%;" required>
                                <?php foreach ($golongans as $golongan) { ?>
                                    <option value="<?= $golongan['id'] ?>" <?= ($product['golongan_id'] == $golongan['id']) ? 'selected' : '' ?>><?= $golongan['nama'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="kategori">Kategori</label>
                            <select class="form-control select2bs4" name="input[kategori_id]" style="width: 100%;" required>
                                <option value="">Pilih Kategori</option>
                                <?php foreach ($kategoris as $kategori) { ?>
                                    <option value="<?= $kategori['id'] ?>" <?= ($product['kategori_id'] == $kategori['id']) ? 'selected' : '' ?>><?= $kategori['nama'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kategori">Harga Jual</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" name="input[harga_jual]" required class="form-control" value="<?= $product['harga_jual'] ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kategori">Harga Beli</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" name="input[harga_beli]" required class="form-control" value="<?= $product['harga_beli'] ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="kategori">Stok Awal Baru</label>
                            <input type="number" class="form-control" name="input[stok_awal_baru]" value="<?= $product['stok_awal_baru'] ?>" required>                    
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="kategori">Tipe Jumlah</label>
                            <select class="form-control select2bs4" name="input[tipe_jumlah_id]" style="width: 100%;" required>
                                <?php foreach ($tipe_jumlahs as $tipe_jumlah) { ?>
                                    <option value="<?= $tipe_jumlah['id'] ?>" <?= ($product['tipe_jumlah_id'] == $tipe_jumlah['id']) ? 'selected' : '' ?>><?= $tipe_jumlah['nama'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="kategori">Minimal Stock</label>
                            <input type="number" class="form-control" name="input[min_stock]" value="<?= $product['min_stock'] ?>" required>                    
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="kategori">Fee Dokter</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" name="input[fee_dokter]" required class="form-control" value='<?= $product['fee_dokter'] ?>'>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="kategori">Fee Beautician</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" name="input[fee_beautician]" required class="form-control" value='<?= $product['fee_beautician'] ?>'>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="kategori">Fee Sales</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" name="input[fee_sales]" required class="form-control" value='<?= $product['fee_sales'] ?>'>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kategori">Kode Dokter</label>
                            <input type="text" style="text-transform:uppercase" onkeyup="this.value = this.value.toUpperCase()" name="input[kode_dokter]" class="form-control" value="<?= $product['kode_dokter'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kategori">Diskon Referral</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" name="input[diskon_referral]" class="form-control" value='<?= $product['diskon_referral'] ?>'>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <div class="form-check">
                            <input class="form-check-input" name="input[is_obatresep]" type="checkbox" value="1" <?= ($product['is_obatresep'] == 1) ? 'checked' : ''?>>
                            <label class="form-check-label"><b>Obat Resep</b></label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-check">
                            <input class="form-check-input" name="input[is_referral]" type="checkbox" value="1" <?= ($product['is_referral'] == 1) ? 'checked' : '' ?>>
                            <label class="form-check-label"><b>Status Referral</b></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-primary">Simpan</button>
              <?= form_close(); ?>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
        </div>
      <?php } ?>

</section>
<script type="text/javascript">
    $(document).ready(function() {
        $("#success-alert").fadeTo(3000, 500).slideUp(500, function(){
            $("#success-alert").slideUp(500);
            <?php unset($_SESSION['success']) ?>
        });

		$("#error-alert").fadeTo(5000, 500).slideUp(500, function(){
            $("#error-alert").slideUp(500);
            <?php unset($_SESSION['error']) ?>
        });
        $('#kt_table_1').DataTable({
            "responsive": true,
            "autoWidth": false,
            "stateSave": true,
        });
    });
</script>
</div>