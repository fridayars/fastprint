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
                    <label for="nama" class="col-sm-2 col-form-label">Nama Promo</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" value="<?= isset($promo) ? $promo['nama'] : '' ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="jenis_id" class="col-sm-2 col-form-label">Jenis</label>
                    <div class="col-sm-10">
                        <select class="form-control select2bs4" name="jenis_id" style="width: 100%;" required>
                            <option value="">Pilih Jabatan</option>
                            <?php foreach ($jenises  as $jenis) { ?>
                                <option value="<?= $jenis['id'] ?>" <?php if (isset($promo)) {
                                                                        if ($promo['jenis_id'] == $jenis['id']) echo 'selected';
                                                                    } ?>><?= $jenis['nama'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="periode" class="col-sm-2 col-form-label">Periode Transaksi</label>
                    <div class="col-sm-2">
                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                            <input type="text" name="start_promo" class="form-control datetimepicker-input" data-target="#reservationdate" required value="<?= isset($promo) ? $promo['start_promo'] : '' ?>" />
                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <label for="periode" class="col-sm-1 col-form-label">s/d</label>
                    <div class="col-sm-2">
                        <div class="input-group date" id="end_promo" data-target-input="nearest">
                            <input type="text" name="end_promo" class="form-control datetimepicker-input" data-target="#end_promo" required value="<?= isset($promo) ? $promo['end_promo'] : '' ?>" />
                            <div class="input-group-append" data-target="#end_promo" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <?php if (isset($promo)) { ?>
                    <button type="submit" class="btn btn-info col-md-2">Edit Promo</button>
                <?php } else { ?>
                    <button type="submit" class="btn btn-info col-md-2">Tambah Promo</button>
                <?php } ?>
            </div>
            <!-- /.card-footer -->
        </form>
    </div>

    <div class="card">
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>KODE</th>
                        <th>NAMA PROMO</th>
                        <th>JANGKA WAKTU</th>
                        <th>JENIS</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($promos as $promo) { ?>
                        <tr>
                            <td><?= $promo['kode'] ?></td>
                            <td><?= $promo['nama'] ?></td>
                            <td><?= $promo['start_promo'] ?> s/d <?= $promo['end_promo'] ?> </td>
                            <td><?= $promo['jenis_promo'] ?></td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-icon" data-toggle="dropdown">Proses
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="<?= base_url() ?>Administrasi/Treatment/edit_promo/<?= $promo['kode'] ?>">Edit promo</a>
                                        <a class="dropdown-item" href="<?= base_url() ?>Administrasi/Treatment/delete_promo/<?= $promo['kode'] ?>">Hapus promo</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

</section>
</div>