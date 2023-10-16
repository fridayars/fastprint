<section class="content">

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-3">
                    <button type="button" class="btn btn-block btn-success btn-sm" data-toggle="modal" data-target="#modal-default">Entry Data</button>
                </div>
                <div class="col-md-3">
                    <a type="button" href="<?= base_url() ?>Administrasi/MasterTreatment/excel_treatments" class="btn btn-block btn-warning btn-sm">Export Full Data</a>
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
                        <th>NAMA TREATMENT</th>
                        <th>TARIF TREATMENT</th>
                        <th>DISKON REFERRAL</th>
                        <th>STAFF FEE</th>
                        <th style="text-align: center;">REFERRAL STATUS</th>
                        <th>PROSES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($master_treatment as $treatment) { ?>
                        <tr>
                            <td><?= $no; ?></td>
                            <td><?= $treatment['nama_treatment'] ?></td>
                            <td>Rp <?= number_format($treatment['tarif']) ?></td>
                            <td>Rp <?= number_format($treatment['diskon_referral']) ?></td>
                            <td>Rp <?= number_format($treatment['diskon_fee']) ?></td>
                            <td style="text-align: center;"><?= ($treatment['is_referral'] == 0) ? '<i style="color:grey" class="fa fa-ban"></i>' : '<i style="color:green" class="fa fa-check"></i>'; ?></td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-edit<?= $treatment['id'] ?>">Edit</button>
                                <a class="btn btn-danger btn-sm" href="<?= base_url() ?>Administrasi/MasterTreatment/delete/<?= $treatment['id'] ?>">Hapus</a>
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
              <h4 class="modal-title">Tambah Master Treatment</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
                <?= form_open('Administrasi/MasterTreatment/add');?>
                <div class="form-group">
                    <label for="kategori">Nama Treatment</label>
                    <input type="text" style="text-transform:uppercase" onkeyup="this.value = this.value.toUpperCase()" name="input[nama_treatment]" required class="form-control">
                </div>
                <div class="form-group">
                    <label for="kategori">Tarif Treatment</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <input type="number" name="input[tarif]" required class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="kategori">Harga Terendah</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <input type="number" name="input[harga_terendah]" value="0" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kategori">Unit</label>
                            <select class="form-control select2bs4" name="input[unit_id]" style="width: 100%;" required>
                                <option value="">Pilih Unit</option>
                                <?php foreach ($units as $unit) { ?>
                                    <option value="<?= $unit['id'] ?>"><?= $unit['nama'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kategori">Tipe</label>
                            <select class="form-control select2bs4" name="input[tipe_id]" style="width: 100%;" required>
                                <option value="">Pilih Tipe</option>
                                <?php foreach ($tipes as $tipe) { ?>
                                    <option value="<?= $tipe['id'] ?>"><?= $tipe['nama'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kategori">Waktu</label>
                            <div class="input-group">
                                <input type="number" name="input[waktu]" required class="form-control" value='60'>
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Menit</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kategori">Biaya Modal</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" name="input[biaya_modal]" required class="form-control" value='0'>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kategori">Tarif Dokter</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" name="input[tarif_dokter]" required class="form-control" value='0'>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kategori">Tarif Beautician</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" name="input[tarif_beautician]" required class="form-control" value='0'>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="kategori">Diskon Referral</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <input type="number" name="input[diskon_referral]" class="form-control" value='0'>
                    </div>
                </div>
                <div class="form-group">
                    <label for="kategori">Staff Fee Referral</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <input type="number" name="input[diskon_fee]" class="form-control" value='0'>
                    </div>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="input[is_referral]" type="checkbox" value="1">
                    <label class="form-check-label"><b>Status Referral</b></label>
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
      <?php $no = 1; foreach ($master_treatment as $treatment) { ?>
        <div class="modal fade bd-example-modal-lg" id="modal-edit<?= $treatment['id'] ?>">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Master Treatment</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
                <?= form_open('Administrasi/MasterTreatment/edit/'. $treatment['id']);?>
                <div class="form-group">
                    <label for="kategori">Nama Treatment</label>
                    <input type="text" style="text-transform:uppercase" onkeyup="this.value = this.value.toUpperCase()" name="input[nama_treatment]" required class="form-control" value="<?= $treatment['nama_treatment'] ?>">
                </div>
                <div class="form-group">
                    <label for="kategori">Tarif Treatment</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <input type="number" name="input[tarif]" required class="form-control" value="<?= $treatment['tarif'] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="kategori">Harga Terendah</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <input type="number" name="input[harga_terendah]" class="form-control" value="<?= $treatment['harga_terendah'] ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kategori">Unit</label>
                            <select class="form-control select2bs4" name="input[unit_id]" style="width: 100%;" required>
                                <option value="">Pilih Unit</option>
                                <?php foreach ($units as $unit) { ?>
                                    <option value="<?= $unit['id'] ?>" <?= ($treatment['unit_id'] == $unit['id']) ? 'selected' : '' ?>><?= $unit['nama'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kategori">Tipe</label>
                            <select class="form-control select2bs4" name="input[tipe_id]" style="width: 100%;" required>
                                <option value="">Pilih Tipe</option>
                                <?php foreach ($tipes as $tipe) { ?>
                                    <option value="<?= $tipe['id'] ?>" <?= ($treatment['tipe_id'] == $tipe['id']) ? 'selected' : '' ?>><?= $tipe['nama'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kategori">Waktu</label>
                            <div class="input-group">
                                <input type="number" name="input[waktu]" required class="form-control" value='<?= $treatment['waktu'] ?>'>
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Menit</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kategori">Biaya Modal</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" name="input[biaya_modal]" required class="form-control" value='<?= $treatment['biaya_modal'] ?>'>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kategori">Tarif Dokter</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" name="input[tarif_dokter]" required class="form-control" value='<?= $treatment['tarif_dokter'] ?>'>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kategori">Tarif Beautician</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" name="input[tarif_beautician]" required class="form-control" value='<?= $treatment['tarif_beautician'] ?>'>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="kategori">Diskon Referral</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <input type="number" name="input[diskon_referral]" class="form-control" value="<?= $treatment['diskon_referral'] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="kategori">Staff Fee Referral</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <input type="number" name="input[diskon_fee]" class="form-control" value="<?= $treatment['diskon_fee'] ?>">
                    </div>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="input[is_referral]" type="checkbox" value="1" <?= ($treatment['is_referral'] == 0) ? '' : 'checked' ; ?>>
                    <label class="form-check-label"><b>Status Referral</b></label>
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