<section class="content">

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <a class="btn btn-success" href="<?= base_url() ?>/Administrasi/Diskon/create">Tambah Voucher</a>
            </div>
            <div class="card-tools">
                <button type="button" class="btn btn-tool " data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fas fa-times"></i></button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <nav class="w-100">
                    <div class="nav nav-tabs nav-fill" id="product-tab" role="tablist">
                        <a class="nav-item nav-link active" id="product-desc-tab" data-toggle="tab" href="#product-desc" role="tab" aria-controls="product-desc" aria-selected="true">DIRECT VOUCHER</a>
                        <a class="nav-item nav-link" id="product-comments-tab" data-toggle="tab" href="#product-comments" role="tab" aria-controls="product-comments" aria-selected="false">GENERATE VOUCHER</a>
                    </div>
                </nav>
                <div class="tab-content p-3 w-100" id="nav-tabContent">

                    <div class="tab-pane fade show active" id="product-desc" role="tabpanel" aria-labelledby="product-desc-tab">
                        <table id="kt_table_1" class="table table-striped table-bordered table-hover table-checkable">
                            <thead>
                                <tr>
                                    <th width="5%">NO</th>
                                    <th>NAMA</th>
                                    <th>DESKRIPSI</th>
                                    <th>JENIS</th>
                                    <th>KODE</th>
                                    <th>BERLAKU DI</th>
                                    <th width="15%">AKSI</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="tab-pane fade" id="product-comments" role="tabpanel" aria-labelledby="product-comments-tab">
                        <table id="kt_table_2" class="table table-striped table-bordered table-hover table-checkable w-100">
                            <thead>
                                <tr>
                                    <th width="5%">NO</th>
                                    <th>NAMA</th>
                                    <th>DESKRIPSI</th>
                                    <th>JENIS</th>
                                    <th>KODE</th>
                                    <th>BERLAKU DI</th>
                                    <th width="15%">AKSI</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
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
            "columnDefs": [ {
                "targets": [0,5,6],
                "orderable": false
                } ],
            order: [[2, 'asc']],
            'serverMethod': 'post',
            'ajax': {
                'url': '<?= base_url() ?>Administrasi/Diskon/get_vDirect'
            },
            'columns': [
                {
                    data: 'no'
                },
                {
                    data: 'nama'
                },
                {
                    data: 'deskripsi'
                },
                {
                    data: 'opsi'
                },
                {
                    data: 'kode_voucher'
                },
                {
                    data: 'berlaku'
                },
                {
                    data: 'button'
                }
            ]
        });

        $('#kt_table_2').DataTable({
            'processing': true,
            'serverSide': true,
            stateSave: true,
            "autoWidth": false,
            "columnDefs": [ {
                "targets": [0,5,6],
                "orderable": false
                },
            ],
            order: [[2, 'asc']],
            'serverMethod': 'post',
            'ajax': {
                'url': '<?= base_url() ?>Administrasi/Diskon/get_vGenerate'
            },
            'columns': [
                {
                    data: 'no'
                },
                {
                    data: 'nama'
                },
                {
                    data: 'deskripsi'
                },
                {
                    data: 'opsi'
                },
                {
                    data: 'kode_voucher'
                },
                {
                    data: 'berlaku'
                },
                {
                    data: 'button'
                }
            ]
        });
    });
</script>

</div>