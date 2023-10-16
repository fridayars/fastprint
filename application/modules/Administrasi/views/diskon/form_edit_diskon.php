<section class="content">
    <!-- Horizontal Form -->
    <div class="card card-info">
        <?php if (validation_errors()) : ?>
            <div class="alert alert-danger" role="alert">
                <?= validation_errors(); ?>
            </div>
        <?php endif; ?>
        <div class="card-header">
            <h3 class="card-title"><?= $title ?></h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="" method="post" class="form-horizontal">
            <div class="card-body">
                <div class="form-group">
                    <label for="kategori">Nama Voucher</label>
                    <input type="text" style="text-transform:uppercase" onkeyup="this.value = this.value.toUpperCase()" name="nama" required class="form-control" value="<?= $voucher['nama'] ?>">
                </div>
                <div class="form-group">
                    <label for="kategori">Deskripsi</label>
                    <textarea class="form-control" name="deskripsi" maxlength="255"rows="3"><?= $voucher['deskripsi'] ?></textarea>
                </div>
                <div class="form-group">
                    <label for="kategori">Cabang Voucher</label>
                    <select class="form-control select2bs4" name="toko_id" style="width: 100%;" disabled multiple>
                        <?php foreach ($v_toko as $toko) { ?>
                            <option value="<?= $toko['id'] ?>" selected><?= $toko['nama'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kategori">Kategori Voucher</label>
                            <select id="voucher_kategori_id" class="form-control select2bs4" name="voucher_kategori_id" style="width: 100%;" disabled onchange="pilihKategori()">
                                <option value="">Pilih Kategori</option>
                                <?php foreach ($v_kategori as $kategori) { ?>
                                    <option value="<?= $kategori['id'] ?>" <?= ($voucher['voucher_kategori_id'] == $kategori['id']) ? "selected" : ""; ?>><?= $kategori['opsi'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6" id="kode_voucher" style="display:<?= ($voucher['voucher_kategori_id'] == 1) ? "" : "none"; ?>">                       
                        <label for="kategori">Kode Voucher</label>
                        <input type="text" name="kode_voucher" class="form-control" value="<?= $voucher['kode_voucher'] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="kategori">Jenis Voucher</label>
                    <select class="form-control select2bs4" name="voucher_jenis_id" style="width: 100%;" disabled>
                        <option value="">Pilih Jenis</option>
                        <?php foreach ($v_jenis as $jenis) { ?>
                            <option value="<?= $jenis['id'] ?>" <?= ($voucher['voucher_jenis_id'] == $jenis['id']) ? "selected" : ""; ?>><?= $jenis['opsi'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="is_unlimited_date" type="checkbox" value="1" <?= ($voucher['is_unlimited_date'] == 1) ? "checked": ""; ?>>
                    <label class="form-check-label"><i>Tidak Ada Batas Tanggal</i></label>
                </div>
                <div class="form-group">
                    <label for="kategori">Tanggal Mulai - Berakhir</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control float-right" id="date-voucher-edit" name="date" value="<?= date("m/d/Y", strtotime($voucher['start_date'])) ?> - <?= date("m/d/Y", strtotime($voucher['exp_date'])) ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="kategori">Tipe Diskon</label>
                            <select name="tipe_diskon" id="tipe_diskon" class="form-control select2bs4" required onchange="pilihTipeDiskon()">
                                <option value="">Pilih Tipe</option>
                                <option value="pr" <?= ($voucher['tipe_diskon'] == 'pr') ? "selected" : ""; ?>>Persen</option>
                                <option value="rp" <?= ($voucher['tipe_diskon'] == 'rp') ? "selected" : ""; ?>>Rupiah</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="kategori">Total Diskon</label>
                            <input type="number" name="total_diskon" class="form-control" value="<?= $voucher['total_diskon'] ?>" min="0" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : 0">
                        </div>
                    </div>
                    <div class="col-md-5" id="total_diskon_max">
                        <div class="form-group">
                            <label for="kategori">Total Diskon Max</label>
                            <input type="number" name="total_diskon_max" class="form-control" value="<?= $voucher['total_diskon_max'] ?>" min="0" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : 0">
                        </div>
                    </div>
                </div>
                <div class="form-check" id="is_unlimited_qty">
                    <input class="form-check-input" name="is_unlimited_qty" type="checkbox" value="1" <?= ($voucher['is_unlimited_qty'] == 1) ? "checked" : ""; ?>>
                    <label class="form-check-label"><i>Tidak Ada Batas Jumlah</i></label>
                </div>
                <div class="form-group">
                    <label for="kategori">Jumlah Voucher</label>
                    <input type="number" name="quantity" class="form-control" value="<?= $voucher['quantity'] ?>" min="0" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : 0" <?= ($voucher['voucher_kategori_id'] == 1) ? "" : "readonly"; ?>>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="is_combine" type="checkbox" value="1" <?= ($voucher['is_combine'] == 1) ? "checked" : ""; ?> disabled>
                    <label class="form-check-label"><i>Voucher dapat digabung dengan promo lain?</i></label>
                </div>
                <div class="form-group">
                    <label for="kategori">Template Voucher</label>
                    <select id="voucher_template_id" class="form-control select2bs4" name="voucher_template_id" style="width: 100%;" onchange="pilihTemplate()">
                        <option value="">Pilih Template</option>
                        <?php foreach ($v_template as $template) { ?>
                            <option value="<?= $template['id'] ?>" file="<?= $template['file_url'] ?>" <?= $voucher['voucher_template_id'] == $template['id'] ? "selected" : ""; ?>><?= $template['nama_template'] ?></option>
                        <?php } ?>
                    </select>
                    <br>
                    <img src="#" alt="Preview Template" id="PrevTemp" height="200px"/>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-info">Edit Voucher</button>
            </div>            
        </form>
    </div>
</section>
</div>

<script>
    $(function(){
        $('#date-voucher-edit').daterangepicker({
            minDate: "<?= date("m/d/Y", strtotime($voucher['start_date'])) ?>",
        })

        v_kategori = $("#voucher_kategori_id option:selected").val()
        if(v_kategori == 1){
            $("#is_unlimited_qty").css({'display' : ''})
        }else{
            $("#is_unlimited_qty").css({'display' : 'none'})
        }

        v_tipe = $("#tipe_diskon option:selected").val()
        if(v_tipe == 'pr'){
            $("#total_diskon_max").css({'display' : ''})
        }else{
            $("#total_diskon_max").css({'display' : 'none'})
        }

        const file = $("#voucher_template_id option:selected").attr("file")
        $("#PrevTemp").attr("src", "<?= base_url().'assets/template/'?>"+file);
    });
    function pilihKategori()
    {
        value = $("#voucher_kategori_id option:selected").val()
        if(value == 1){
            $("#is_unlimited_qty").css({'display' : ''})
        }else{
            $("#is_unlimited_qty").css({'display' : 'none'})
        }
    }
    function pilihTipeDiskon()
    {
        value = $("#tipe_diskon option:selected").val()
        if(value == 'pr'){
            $("#total_diskon_max").css({'display' : ''})
        }else{
            $("#total_diskon_max").css({'display' : 'none'})
        }
    }
    function pilihTemplate()
    {
        const file = $("#voucher_template_id option:selected").attr("file")
        $("#PrevTemp").attr("src", "<?= base_url().'assets/template/'?>"+file);
    }
</script>