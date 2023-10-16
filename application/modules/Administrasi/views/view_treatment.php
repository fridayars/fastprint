<section class="content">
    <div class="card card-info">
        <div class="card-header">
            <div class="row">
               <h5>Detail Treatment</h5>
            </div>
        </div>
        <form action="" method="post" class="form-horizontal">
            <div class="card-body">
                <div class="form-group row">
                <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= isset($treatment) ? $treatment['nama'] : '' ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                <label for="unit_id" class="col-sm-2 col-form-label">Unit/Tipe</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" value="<?= $treatment['nama_unit'] ?>" readonly>
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" value="<?= $treatment['nama_tipe'] ?>" readonly>
                    </div>
                    <div class="col-sm-2">
                        <input type="number" class="form-control" id="waktu" name="waktu" placeholder="waktu" value="<?= isset($treatment) ? $treatment['waktu'] : '' ?>" required readonly>
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
                            <input type="number" class="form-control" placeholder="Tarif Member" id="tarif_member" name="tarif_member" value="<?= isset($treatment) ? $treatment['tarif_member'] : '0' ?>" required readonly>
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
                            <input type="number" class="form-control" placeholder="Tarif Dokter" id="tarif_dokter" name="tarif_dokter" value="<?= isset($treatment) ? $treatment['tarif_dokter'] : '0' ?>" readonly>
                        </div>
                    </div>
                    <label for="tarif_beautician" class="col-sm-1 col-form-label">Beutician</label>
                    <div class="col-sm-2">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="number" class="form-control" placeholder="Tarif Beautician" id="tarif_beautician" name="tarif_beautician" value="<?= isset($treatment) ? $treatment['tarif_beautician'] : '0' ?>" readonly>
                        </div>
                    </div>
                    <label for="tarif_sales" class="col-sm-1 col-form-label">Sales</label>
                    <div class="col-sm-2">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="number" class="form-control" placeholder="Tarif Sales" id="tarif_sales" name="tarif_sales" value="<?= isset($treatment) ? $treatment['tarif_sales'] : '0' ?>" readonly>
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
                            <input type="number" class="form-control" placeholder="Biaya Modal" id="biaya_modal" name="biaya_modal" value="<?= isset($treatment) ? $treatment['biaya_modal'] : '0' ?>" required readonly>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                    <a class="btn btn-info col-md-2" href="<?= base_url() ?>Administrasi/Treatment/list_treatment">Kembali</a>
            </div>
            <!-- /.card-footer -->
        </form>
    </div>

</section>
</div>