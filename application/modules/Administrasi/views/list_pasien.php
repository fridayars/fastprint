<section class="content">

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <h5>List Semua Pasien Klinik</h3>
            <!-- <form action="<?= site_url() . 'Administrasi/Pasien/excel_pasien' ?>" method="post">
            <div class="row">
                <div class="col-md-3 form-group">
                    <label for="">Cabang</label>
                    <select name="input[cabang]" class="form-control" id="">
                        <option value="0">Semua Cabang</option>
                        <?php foreach($cabang as $index => $value) { ?>
                            <option value="<?=$value['id']?>"><?=$value['nama']?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-3 form-group">
                    <label for=""><select name="tipe_tanggal" id="" style="border:0px;outline:0px;font-weight:bold;">
                        <option value="reg">Tanggal Registrasi</option>
                        <option value="lhr">Tanggal Lahir</option>
                    </select></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control float-right" id="reservation" name="input[tanggal]">
                    </div>
                </div>
                <div class="col-md-3 form-group">
                    <label for="">Status</label>
                    <select name="input[status]" class="form-control" id="">
                        <option value="0">Semua Pasien</option>
                        <option value="1">Pasien Member</option>
                    </select>
                </div>
                <div class="col-md-3 form-group">
                    <a href="<?= base_url() ?>Administrasi/Pasien/export_full" class="btn btn-warning btn-sm btn-block">Export Full Data</a>
                    <button type="submit" class="btn btn-warning btn-sm btn-block">Export Data by Filter</button>
                </div>
            </div>
            </form>
            <code><i>
            note : <br>
            - filter "tanggal pendaftaran" berlaku mulai masing-masing klinik telah menerapkan sistem ini.
            </i></code> -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="kt_table_1" class="table table-striped- table-bordered table-hover table-checkable">
                <thead>
                    <tr>
                        <th>No.RM</th>
                        <th>NO.MEMBER</th>
                        <th>NAMA PASIEN</th>
                        <th>ALAMAT</th>
                        <th>TTL</th>
                        <th>JENIS KELAMIN</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

</section>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
    function deletePasien(id)
    {
        Swal.fire({
            title: 'Apakah Anda Yakin Ingin Menghapus Data Pasien Tersebut?',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#808080',
            confirmButtonText: 'Ya, Hapus!',
            reverseButtons: true,
            width: 600,
            padding: '3em',
            color: '#fff',
            background: 'rgba(255, 193, 7,0.9) url(../assets/fire2.gif)',
            backdrop: `
                rgba(255, 0, 0,0.4)
                url("../assets/nyan-cat.gif")
                left top
                no-repeat
            `
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "<?=site_url('Administrasi/Pasien/deleteAjax')?>",
                    data: { new_id : id }
                }).done(function(data) {
                    data = jQuery.parseJSON(data)
                    if (data == 200){   
                        Swal.fire(
                            'Deleted!',
                            'Data Pasien Berhasil Terhapus.',
                            'success'
                        )
                        $('#kt_table_1').DataTable().ajax.reload();
                    }
                    else{
                        Swal.fire(
                            'Failed!',
                            'Data Pasien Gagal Terhapus.',
                            'error'
                        )
                    }
                });
            }
        })
    }
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#kt_table_1').DataTable({
            'processing': true,
            'serverSide': true,
            stateSave: true,
            'serverMethod': 'post',
            'ajax': {
                'url': '<?= base_url() ?>Administrasi/Pasien/get_pasien'
            },
            'columns': [{
                    data: 'no_rm'
                },
                {
                    data: 'no_member'
                },
                {
                    data: 'nama'
                },
                {
                    data: 'alamat'
                },
                {
                    data: 'tgl_lahir'
                },
                {
                    data: 'jenis_kelamin'
                },
                {
                    data: 'button'
                },
            ]
        });
    });
</script>
</div>