<section class="content">

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="card-title">
                    <?php if($voucher['voucher_jenis_id'] == 1) { ?>
                        <button class="btn btn-success" onclick="formTr()">Tambah Treatment</button>
                    <?php } elseif($voucher['voucher_jenis_id'] == 2) { ?>
                        <button class="btn btn-success" onclick="formPr()">Tambah Product</button>
                    <?php } else { ?>
                        <button class="btn btn-success" onclick="formTr()">Tambah Treatment</button>
                        <button class="btn btn-success" onclick="formPr()">Tambah Product</button>
                    <?php } ?>
                </div>
            </div>
            
            <div class="row mt-2" style="display:none" id="pilihTr">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label for="inputItem" class="col-sm-2 col-form-label">Pilih Treatment</label>
                        <div class="col-sm-8">
                            <select id="treatment_id" class="form-control select2bs4" name="treatment_id" style="width: 100%;" required>
                                <option value="">Nama Treatment - Tarif Umum</option>
                                <option value="0">TAMBAHKAN SEMUA TREATMENT</option>
                                <?php foreach($treatments as $tr) { ?>
                                    <option value="<?= $tr['id'] ?>"><?= $tr['nama_treatment'] .' - Rp. '. number_format($tr['tarif']) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <button type="button" onclick="submitTr()" class="btn btn-primary col-sm-2">Tambah</button>
                    </div>
                </div>
            </div>
            <div class="row mt-2" style="display:none" id="pilihPr">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label for="inputItem" class="col-sm-2 col-form-label">Pilih Product</label>
                        <div class="col-sm-8">
                            <select id="product_id" class="form-control select2bs4" name="product_id" style="width: 100%;" required>
                                <option value="">Nama Product - Harga Jual</option>
                                <option value="0">Tambahkan Semua Product</option>
                                <?php foreach($products as $pr) { ?>
                                    <option value="<?= $pr['id'] ?>"><?= $pr['nama'] .' - Rp. '. number_format($pr['harga_jual']) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <button type="button" onclick="submitPr()" class="btn btn-primary col-sm-2">Tambah</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <nav class="w-100">
                    <div class="nav nav-tabs nav-fill" id="product-tab" role="tablist">
                        <a class="nav-item nav-link active" id="product-desc-tab" data-toggle="tab" href="#product-desc" role="tab" aria-controls="product-desc" aria-selected="true">TREATMENTS</a>
                        <a class="nav-item nav-link" id="product-comments-tab" data-toggle="tab" href="#product-comments" role="tab" aria-controls="product-comments" aria-selected="false">PRODUCTS</a>
                    </div>
                </nav>
                <div class="tab-content p-3 w-100" id="nav-tabContent">

                    <div class="tab-pane fade show active" id="product-desc" role="tabpanel" aria-labelledby="product-desc-tab">
                        <table id="kt_table1" class="table table-striped table-bordered table-hover table-checkable">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>NAMA TREATMENT</th>
                                    <th>TARIF UMUM</th>
                                    <th>DISKON ITEM</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="tab-pane fade" id="product-comments" role="tabpanel" aria-labelledby="product-comments-tab">
                        <table id="kt_table2" class="table table-striped table-bordered table-hover table-checkable w-100">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>NAMA PRODUK</th>
                                    <th>HARGA JUAL</th>
                                    <th>DISKON ITEM</th>
                                    <th>AKSI</th>
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

    <!-- Modal -->
    <div class="modal fade" id="modalDiskon" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Diskon Item</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3">
                        <label for="diskon_item" class="col-form-label">Diskon Item</label>
                    </div>
                    <div class="col-md-9">
                        <input type="number" id="diskon_item" class="form-control">
                        <input type="hidden" id="id_item" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="addDiskonItem()">Simpan</button>
            </div>
            </div>
        </div>
    </div>

</section>
<script type="text/javascript">
    function modalDiskonItem(id, diskon)
    {
        $("#modalDiskon").modal("show")
        $("#diskon_item").val(diskon)
        $("#id_item").val(id)
    }

    function addDiskonItem()
    {
        const diskon = $("#diskon_item").val()
        const id = $("#id_item").val()

        $.ajax({
			type: "POST",
			url: "<?= site_url('Administrasi/Diskon/addDiskonItem') ?>",
			data: { id : id, diskon_item : diskon} 
		}).done(function(data) {
            $("#modalDiskon").modal("hide")
            alert(data)
			reloadDatatable1()
			reloadDatatable2()
		});
    }

    $(document).ready(function() {
        $('#kt_table1').DataTable({
			'processing': true,
            'serverSide': true,
            "columnDefs": [ {
                "targets": [0, 4],
                "orderable": false
                } ],
            order: [[2, 'asc']],
            'serverMethod': 'post',
            'ajax': {
                'url': '<?= base_url() ?>Administrasi/Diskon/jsonListItemTreatment/<?= $voucher['id'] ?>'
            },
            'columns': [
                {
                    data: 'no'
                },
                {
                    data: 'nama_treatment'
                },
                {
                    data: 'tarif'
                },
                {
                    data: 'diskon_item'
                },
                {
                    data: 'button'
                }
            ]
		});

        $('#kt_table2').DataTable({
			'processing': true,
            'serverSide': true,
            "columnDefs": [ {
                "targets": [0, 4],
                "orderable": false
                } ],
            order: [[2, 'asc']],
            'serverMethod': 'post',
            'ajax': {
                'url': '<?= base_url() ?>Administrasi/Diskon/jsonListItemProduct/<?= $voucher['id'] ?>'
            },
            'columns': [
                {
                    data: 'no'
                },
                {
                    data: 'nama'
                },
                {
                    data: 'harga_jual'
                },
                {
                    data: 'diskon_item'
                },
                {
                    data: 'button'
                }
            ]
		});
    });

    function reloadDatatable2()
    {
        $('#kt_table2').DataTable().clear()
        $('#kt_table2').DataTable({
            'destroy' : true,
			'processing': true,
            'serverSide': true,
            "columnDefs": [ {
                "targets": [0, 4],
                "orderable": false
                } ],
            order: [[2, 'asc']],
            'serverMethod': 'post',
            'ajax': {
                'url': '<?= base_url() ?>Administrasi/Diskon/jsonListItemProduct/<?= $voucher['id'] ?>'
            },
            'columns': [
                {
                    data: 'no'
                },
                {
                    data: 'nama'
                },
                {
                    data: 'harga_jual'
                },
                {
                    data: 'diskon_item'
                },
                {
                    data: 'button'
                }
            ]
		}).ajax.reload();
    }

    function reloadDatatable1()
    {
        $('#kt_table1').DataTable().clear()
        $('#kt_table1').DataTable({
            'destroy' : true,
			'processing': true,
            'serverSide': true,
            "columnDefs": [ {
                "targets": [0, 4],
                "orderable": false
                } ],
            order: [[2, 'asc']],
            'serverMethod': 'post',
            'ajax': {
                'url': '<?= base_url() ?>Administrasi/Diskon/jsonListItemTreatment/<?= $voucher['id'] ?>'
            },
            'columns': [
                {
                    data: 'no'
                },
                {
                    data: 'nama_treatment'
                },
                {
                    data: 'tarif'
                },
                {
                    data: 'diskon_item'
                },
                {
                    data: 'button'
                }
            ]
		}).ajax.reload();
    }

    function formTr()
    {
        $("#pilihTr").css({'display' : ''})
    }
    function formPr()
    {
        $("#pilihPr").css({'display' : ''})
    }

    function submitTr()
    {
        var id = $("#treatment_id option:selected").val()
        if(id !== ""){
            $.ajax({
                type: "POST",
                url: "<?=site_url('Administrasi/Diskon/addItemTreatment/'.$voucher['id'])?>",
                data: { treatment_id : id } 
            }).done(function(status) {
                if(status == 200) reloadDatatable1();
                if(id == 0){
                    $('#treatment_id').find('option').remove().end()
                    .append(new Option("Nama Treatment - Tarif Umum", ""))
                    .append(new Option("TAMBAHKAN SEMUA TREATMENT", "0"));
                }else{
                    $("#treatment_id option[value='"+ id +"']").remove();
                }
                $("#treatment_id").val("").change();
            });	
        }else{
            alert("Pilih Treatment!")
        }
    }

    function submitPr()
    {
        var id = $("#product_id option:selected").val()
        if(id !== ""){
            $.ajax({
                type: "POST",
                url: "<?=site_url('Administrasi/Diskon/addItemProduct/'.$voucher['id'])?>",
                data: { product_id : id } 
            }).done(function(status) {
                if(status == 200) reloadDatatable2();
                if(id == 0){
                    $('#product_id').find('option').remove().end()
                    .append(new Option("Nama Product - Harga Jual", ""))
                    .append(new Option("TAMBAHKAN SEMUA PRODUCT", "0"));
                }else{
                    $("#product_id option[value='"+ id +"']").remove();
                }
                $("#product_id").val("").change();
            });	
        }else{
            alert("Pilih Product!")
        }
    }
</script>

</div>