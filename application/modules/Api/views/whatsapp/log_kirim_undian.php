<section class="content">

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
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
            <table id="kt_table_1" class="table table-striped- table-bordered table-hover table-checkable">
                <thead>
                    <tr>
                        <th width="5%">NO</th>
                        <th>TANGGAL</th>
                        <th>NAMA PASIEN</th>
                        <th>FAKTUR</th>
                        <th>STATUS</th>
                        <th>LOG</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

    <!-- Modal -->
    <div class="modal fade" id="modal-log" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title fs-5" id="exampleModalLabel">Log Status</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
        </div>
        <div class="modal-body">
            <div class="row mb-2">
                <div class="col-2">
                    <label for="input" class="col-form-label">Nama Px</label>
                </div>
                <div class="col-md-10">
                    <input type="text" id="nama_px" class="form-control" value="" readonly>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-2">
                    <label for="input" class="col-form-label">No. Hp</label>
                </div>
                <div class="col-md-10">
                    <input type="text" id="no_hp" class="form-control" value="" readonly>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-2">
                    <label for="input" class="col-form-label">Status</label>
                </div>
                <div class="col-md-10">
                    <input type="text" id="status_log" class="form-control" value="" readonly>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>

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
            'processing': true,
            'serverSide': true,
            "ordering": false,
            'stateSave' : true,
            'serverMethod': 'post',
            'ajax': {
                'url': '<?= base_url() ?>Api/Whatsapp/get_log_kirim_undian'
            },
            'columns': [{
                    data: 'no'
                },
                {
                    data: 'tanggal'
                },
                {
                    data: 'nama'
                },
                {
                    data: 'faktur'
                },
                {
                    data: 'status'
                },
                {
                    data: 'log'
                },
                {
                    data: 'button'
                },
            ]
        });
    });

    function modalLog(id)
    {
        $uuid = $('#'+id).attr('value')
        $.ajax({
            url: '<?= base_url() ?>Api/Whatsapp/get_log_wa/'+$uuid,
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            success: function(json) {
                $('#nama_px').val(json.data[0].contact_full_name)
                $('#no_hp').val(json.data[0].contact_phone_number)
                $('#status_log').val(json.data[0].status)
                
                $('#modal-log').modal('show');
            }

        });
    }
</script>
</div>