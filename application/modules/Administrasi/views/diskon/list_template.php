<section class="content">

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <a class="btn btn-success" href="<?= base_url() ?>/Administrasi/Diskon/create_template">Tambah Voucher</a>
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
        <?php if ($this->session->flashdata('success')) : ?>
				<div class="alert alert-success" role="alert" id="success-alert" style="margin-bottom: 30px">
					<button type="button" class="close" data-dismiss="alert">
						<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
					</button>
					<span class="glyphicon glyphicon-exclamation-sign"></span>
					<strong>Sukses! </strong> <?= $this->session->flashdata('success'); ?>
				</div>
			<?php endif; ?>
            <div class="row"></div>
                <table id="kt_table_1" class="table table-striped table-bordered table-hover table-checkable">
                    <thead>
                        <tr>
                            <th width="5%">NO</th>
                            <th>NAMA TEMPLATE</th>
                            <th>FILE URL</th>
                            <th width="15%">AKSI</th>
                        </tr>
                    </thead>
                </table>
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
        $("#success-alert").fadeTo(3000, 500).slideUp(500, function(){
            $("#success-alert").slideUp(500);
            <?php unset($_SESSION['success']) ?>
        });

        $('#kt_table_1').DataTable({
            'processing': true,
            'serverSide': true,
            stateSave: true,
            "columnDefs": [ {
                "targets": [0,3],
                "orderable": false
                } ],
            order: [[2, 'asc']],
            'serverMethod': 'post',
            'ajax': {
                'url': '<?= base_url() ?>Administrasi/Diskon/get_template'
            },
            'columns': [
                {
                    data: 'no'
                },
                {
                    data: 'nama_template'
                },
                {
                    data: 'file_url'
                },
                {
                    data: 'button'
                }
            ]
        });
    });
</script>

</div>