<section class="content">

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Input Obat / Bahan Masuk</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fas fa-times"></i></button>
            </div>
        </div>
        <div class="card-body">
            
            <form method="post" action="#">
                <div class="form-group row">
                    <div class="form-group col-md-12">
                        <div class="form-group row">
                            <label for="tanggal" class="col-sm-3 col-form-label">Tanggal</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="tanggal" id="tanggal" value="<?= date('Y-m-d') ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">SUPPLIER</label>
                            <div class="col-sm-8">
                                <select class="form-control PilihPasien" style="width: 100%;" name="supplier">
                                <option>PILIH PASIEN</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Dokter</label>
                            <div class="col-sm-8">
                                <select class="form-control select2bs4" style="width: 100%;" name="input[dokter_id]">
                                    <?= $arrdokter; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Perawat</label>
                            <div class="col-sm-8">
                                <select class="form-control select2bs4" style="width: 100%;" name="input[perawat_id]">
                                    <?= $arrperawat; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-danger btn-lg" id="btn_submit">SIMPAN</button>
            </form>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            Footer
        </div>
        <!-- /.card-footer-->
    </div>
    <!-- /.card -->

</section>
</div>