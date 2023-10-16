<div class="container mt-4">
        <?php if ($_SESSION['berhasil']) : ?>
            <div class="alert alert-info" role="alert" id="success-alert">
                <button type="button" class="close" data-dismiss="alert">
                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>
                <span class="glyphicon glyphicon-exclamation-sign"></span>
                <strong>Sukses! </strong> <?= $_SESSION['berhasil']; ?>
            </div>
        <?php endif; ?>
        <?php if (validation_errors()) : ?>
            <div class="alert alert-danger" role="alert">
                <?= validation_errors(); ?>
            </div>
        <?php endif; ?>
        <div class="mt-4 mb-4">
            <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#modal-tambah">TAMBAH PRODUK</button>
        </div>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID PRODUK</th>
                <th width="30%">NAMA PRODUK</th>
                <th>KATEGORI</th>
                <th>HARGA</th>
                <th>STATUS</th>
                <th>OPSI</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produk as $key => $value) { ?>
                <tr>
                    <td><?= $value['id_produk'] ?></td>
                    <td><?= $value['nama_produk'] ?></td>
                    <td><?= $value['nama_kategori'] ?></td>
                    <td><?= number_format($value['harga']) ?></td>
                    <td><?= $value['nama_status'] ?></td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm" onclick="editProduk(<?= $value['id_produk'] ?>)"><i class="fa fa-pen"></i></button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="hapusProduk(<?= $value['id_produk'] ?>)"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div class="modal fade bd-example-modal-lg" id="modal-tambah">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Tambah Produk</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            <?= form_open('Produk/create');?>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="nama_produk">Nama Produk</label>
                        <input type="text" name="nama_produk" class="form-control" value="<?= set_value('nama_produk') ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="katgeori">Kategori</label>
                        <select name="kategori_id" class="form-control select2bs4">
                            <option value="">Pilih Kategori</option>
                            <?php foreach($kategori as $value){ ?>
                                <option value="<?= $value['id_kategori'] ?>" <?= set_select('kategori_id', $value['id_kategori']) ?>><?= $value['nama_kategori']?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="text" name="harga" class="form-control" value="<?= set_value('harga')?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status_id" class="form-control select2bs4">
                            <option value="">Pilih Status</option>
                            <?php foreach($status as $value){ ?>
                                <option value="<?= $value['id_status'] ?>" <?= set_select('status_id', $value['id_status']) ?>><?= $value['nama_status']?></option>
                            <?php } ?>
                        </select>
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

<div class="modal fade bd-example-modal-lg" id="modal-edit">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Edit Produk</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="form-edit" action="" method="post">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="nama_produk">Nama Produk</label>
                        <input id="edit_nama_produk" type="text" name="nama_produk" class="form-control" value="<?= set_value('nama_produk') ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="katgeori">Kategori</label>
                        <select id="edit_kategori" name="kategori_id" class="form-control select2bs4">
                            <option value="">Pilih Kategori</option>
                            <?php foreach($kategori as $value){ ?>
                                <option value="<?= $value['id_kategori'] ?>" <?= set_select('kategori_id', $value['id_kategori']) ?>><?= $value['nama_kategori']?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input id="edit_harga" type="text" name="harga" class="form-control" value="<?= set_value('harga')?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="edit_status" name="status_id" class="form-control select2bs4">
                            <option value="">Pilih Status</option>
                            <?php foreach($status as $value){ ?>
                                <option value="<?= $value['id_status'] ?>" <?= set_select('status_id', $value['id_status']) ?>><?= $value['nama_status']?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Edit</button>
        </div>
        </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade bd-example-modal-lg" id="modal-hapus">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Hapus Produk</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="form-hapus" action="" method="post">
            <div class="row">
                <div class="col-md-12">
                   <h6>Apakah anda yakin ingin menghapus produk ini?</h6>
                </div>
            </div>
            
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Hapus</button>
        </div>
        </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script type="text/javascript">
    $(function() {

        $("#success-alert").fadeTo(3000, 500).slideUp(500, function(){
            $("#success-alert").slideUp(500);
        });
    })

    function editProduk(id)
    {
        $.ajax({
            type: "POST",
            url: "<?=site_url('Produk/getDataProduk')?>",
            data: { id_produk : id }
        }).done(function(data) {
            data = jQuery.parseJSON(data)
            $("#modal-edit").modal('show')
            console.log(data)
            $("#edit_nama_produk").val(data.nama_produk)
            $("#edit_kategori").val(data.kategori_id).change()
            $("#edit_harga").val(data.harga)
            $("#edit_status").val(data.status_id).change()
            $('#form-edit').attr('action', '<?= site_url('Produk/edit') ?>/'+id);
        });
    }

    function hapusProduk(id)
    {
        $("#modal-hapus").modal("show")
        $('#form-hapus').attr('action', '<?= site_url('Produk/delete') ?>/'+id);
    }
</script>

