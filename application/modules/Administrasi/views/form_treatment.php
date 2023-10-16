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
                        <input type="hidden" id="nama" name="nama" value="<?= isset($treatment) ? $treatment['nama'] : '' ?>">
                        <select id="treatment_id" class="form-control select2bs4" name="master_treatment_id" style="width: 100%;" required>
                            <option value="">Pilih Tindakan</option>
                            <?php foreach ($master_treatment as $tr) { ?>
                                <option value="<?= $tr['id'] ?>" data-nama="<?= $tr['nama_treatment'] ?>" data-tarif="<?= $tr['tarif'] ?>" <?php if (isset($treatment)) {
                                                                        if ($treatment['master_treatment_id'] == $tr['id']) echo 'selected';
                                                                    } ?>><?= $tr['nama_treatment'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                <label for="unit_id" class="col-sm-2 col-form-label">Unit</label>
                    <div class="col-sm-3">
                        <select class="form-control select2bs4" name="unit_id" style="width: 100%;" required>
                            <option value="">Pilih Unit</option>
                            <?php foreach ($units  as $unit) { ?>
                                <option value="<?= $unit['id'] ?>" <?php if (isset($treatment)) {
                                                                        if ($treatment['unit_id'] == $unit['id']) echo 'selected';
                                                                    } ?>><?= $unit['nama'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select class="form-control select2bs4" name="tipe_id" style="width: 100%;" required>
                            <option value="">Pilih Tipe</option>
                            <?php foreach ($tipes  as $tipe) { ?>
                                <option value="<?= $tipe['id'] ?>" <?php if (isset($treatment)) {
                                                                        if ($treatment['tipe_id'] == $tipe['id']) echo 'selected';
                                                                    } ?>><?= $tipe['nama'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <input type="number" class="form-control" id="waktu" name="waktu" placeholder="waktu" value="<?= isset($treatment) ? $treatment['waktu'] : '' ?>" required>
                    </div>
                    <label for="waktu" class="col-sm-2 col-form-label">Menit</label>
                </div>
                <div class="form-group row">
                    <label for="tarif" class="col-sm-2 col-form-label">Tarif</label>
                    <label for="tarif_umum" class="col-sm-1 col-form-label">Umum</label>
                    <div class="col-sm-2">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="number" class="form-control" placeholder="Tarif Umum" id="tarif_umum" name="tarif_umum" value="<?= isset($treatment) ? $treatment['tarif_umum'] : '0' ?>" readonly>
                        </div>
                    </div>
                    <label for="tarif_member" class="col-sm-1 col-form-label">Member</label>
                    <div class="col-sm-2">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="number" class="form-control" placeholder="Tarif Member" id="tarif_member" name="tarif_member" value="<?= isset($treatment) ? $treatment['tarif_member'] : '0' ?>" required>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tarif" class="col-sm-2 col-form-label">Fee</label>
                    <label for="tarif_dokter" class="col-sm-1 col-form-label">Dokter</label>
                    <div class="col-sm-2">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="number" class="form-control" placeholder="Tarif Dokter" id="tarif_dokter" name="tarif_dokter" value="<?= isset($treatment) ? $treatment['tarif_dokter'] : '0' ?>">
                        </div>
                    </div>
                    <label for="tarif_beautician" class="col-sm-1 col-form-label">Beutician</label>
                    <div class="col-sm-2">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="number" class="form-control" placeholder="Tarif Beautician" id="tarif_beautician" name="tarif_beautician" value="<?= isset($treatment) ? $treatment['tarif_beautician'] : '0' ?>">
                        </div>
                    </div>
                    <label for="tarif_sales" class="col-sm-1 col-form-label">Sales</label>
                    <div class="col-sm-2">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="number" class="form-control" placeholder="Tarif Sales" id="tarif_sales" name="tarif_sales" value="<?= isset($treatment) ? $treatment['tarif_sales'] : '0' ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tarif" class="col-sm-2 col-form-label">Biaya Modal</label>
                    <div class="col-sm-3">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="number" class="form-control" placeholder="Biaya Modal" id="biaya_modal" name="biaya_modal" value="<?= isset($treatment) ? $treatment['biaya_modal'] : '0' ?>" required>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <?php if (isset($treatment)) { ?>
                    <button type="submit" class="btn btn-info col-md-2">Edit Treatment</button>
                <?php } else { ?>
                    <button type="submit" class="btn btn-info col-md-2">Tambah Treatment</button>
                <?php } ?>
            </div>
            <!-- /.card-footer -->
        </form>
    </div>

</section>
</div>

<script>
    $('#treatment_id').on('change', function(){
    // ambil data dari elemen option yang dipilih
    const nama = $('#treatment_id option:selected').data('nama');
    const tarif = $('#treatment_id option:selected').data('tarif');
    // tampilkan data ke element
    $('[name=nama]').val(nama);
    $('[name=tarif_umum]').val(tarif);    
    });
</script>