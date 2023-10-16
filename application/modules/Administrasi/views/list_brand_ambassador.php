<section class="content">

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-3">
                    <button type="button" class="btn btn-block btn-success btn-sm" data-toggle="modal" data-target="#modal-default">Entry Data</button>
                </div>
                <div class="col-md-3">
                    <a type="button" href="<?= base_url() ?>Administrasi/BrandAmbassador/excel_ba" class="btn btn-block btn-warning btn-sm">Export Full Data</a>
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="kt_table_1" class="table table-striped-table-bordered table-hover table-checkable">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>NAMA BA</th>
                        <th>CABANG BA</th>
                        <th>STATUS BA</th>
                        <th>PROSES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($brand_ambassador as $ba) { ?>
                        <tr>
                            <td><?= $no; ?></td>
                            <td><?= $ba['nama'] ?></td>
                            <td><?= ($ba['toko_id'] == 99) ? 'NASIONAL' : $ba['cabang'] ?></td>
                            <td><?= ($ba['is_delete'] == 0) ? 'Aktif' : 'Tidak Aktif' ?></td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-edit<?= $ba['id'] ?>">Edit</button>
                                <?php if ($ba['is_delete'] == 0){ ?>
                                    <a class="btn btn-danger btn-sm" href="<?= base_url() ?>Administrasi/BrandAmbassador/delete/<?= $ba['id'] ?>/1">Nonaktifkan</a>
                                <?php } else{ ?>
                                    <a class="btn btn-success btn-sm" href="<?= base_url() ?>Administrasi/BrandAmbassador/delete/<?= $ba['id'] ?>/0">Aktifkan</a>
                                <?php } ?>
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
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Brand Ambassador</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
                <?= form_open('Administrasi/BrandAmbassador/add');?>
                <div class="form-group">
                    <label for="kategori">Nama</label>
                    <input type="text" name="input[nama]" style="text-transform:uppercase" onkeyup="this.value = this.value.toUpperCase()" required class="form-control">
                </div>
                <div class="form-group">
                    <label for="kategori">Cabang</label>
                    <select class="form-control select2bs4" style="width: 100%;" name="input[toko_id]">
                        <?= $arrcabang; ?>
                    </select>
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
      <?php $no = 1; foreach ($brand_ambassador as $ba) { ?>
        <div class="modal fade" id="modal-edit<?= $ba['id'] ?>">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Brand Ambassador</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
                <?= form_open('Administrasi/BrandAmbassador/edit/'. $ba['id']);?>
                <div class="form-group">
                    <label for="kategori">Nama</label>
                    <input type="text" name="input[nama]" style="text-transform:uppercase" onkeyup="this.value = this.value.toUpperCase()" required class="form-control" value="<?= $ba['nama'] ?>">
                </div>
                <div class="form-group">
                    <label for="kategori">Cabang</label>
                    <select class="form-control select2bs4" style="width: 100%;" name="input[toko_id]">
                        <?php echo '<option value="99"'. ((@$ba['toko_id'] == 99) ? "selected" : "") .'>NASIONAL</option>';
                        foreach ($cabang as $index => $value) {
                            echo '<option value="' . $value['id'] . '" ' . ((@$ba['toko_id'] == $value['id']) ? "selected" : "") . '>' . $value['nama'] . '</option>';
                        } ?>
                    </select>
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
        $('#kt_table_1').DataTable({
            "responsive": true,
            "autoWidth": false,
        });
    });
</script>
</div>