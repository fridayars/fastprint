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
                    <input type="text" style="text-transform:uppercase" onkeyup="this.value = this.value.toUpperCase()" name="nama" required class="form-control" value="<?= set_value('nama') ?>">
                </div>
                <div class="form-group">
                    <label for="kategori">Deskripsi</label>
                    <textarea class="form-control" name="deskripsi" maxlength="255"rows="3"><?= set_value('deskripsi') ?></textarea>
                </div>
                <div class="form-group">
                    <label for="kategori">Cabang Voucher</label>
                    <?php if($_SESSION['toko_id'] == 99) { ?>
                        <select class="form-control select2bs4" name="toko_id[]" style="width: 100%;" required multiple>
                            <?php foreach ($v_toko as $toko) { ?>
                                <option value="<?= $toko['id'] ?>" <?= set_select('toko_id', $toko['id']) ?>><?= $toko['nama'] ?></option>
                            <?php } ?>
                        </select>
                    <?php } else { ?>
                        <select class="form-control select2bs4" name="toko_id_disabled" style="width: 100%;" disabled>
                            <option value="">Pilih Cabang</option>
                            <?php foreach ($v_toko as $toko) { ?>
                                <option value="<?= $toko['id'] ?>" <?= ($_SESSION['toko_id']==$toko['id']) ? "selected" : ""; ?>><?= $toko['nama'] ?></option>
                            <?php } ?>
                        </select>
                        <input type="hidden" name="toko_id[]" value="<?= $_SESSION['toko_id'] ?>">
                    <?php } ?>
                    
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kategori">Kategori Voucher</label>
                            <select id="voucher_kategori_id" class="form-control select2bs4" name="voucher_kategori_id" style="width: 100%;" required onchange="pilihKategori()">
                                <option value="">Pilih Kategori</option>
                                <?php foreach ($v_kategori as $kategori) { ?>
                                    <option value="<?= $kategori['id'] ?>" <?= set_select('voucher_kategori_id', $kategori['id']) ?>><?= $kategori['opsi'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6" id="kode_voucher">                       
                        <label for="kategori">Kode Voucher</label>
                        <input type="text" name="kode_voucher" class="form-control" value="<?= set_value('kode_voucher') ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="kategori">Jenis Voucher</label>
                    <select class="form-control select2bs4" name="voucher_jenis_id" style="width: 100%;" required>
                        <option value="">Pilih Jenis</option>
                        <?php foreach ($v_jenis as $jenis) { ?>
                            <option value="<?= $jenis['id'] ?>" <?= set_select('voucher_jenis_id', $jenis['id']) ?>><?= $jenis['opsi'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="is_unlimited_date" type="checkbox" value="1" <?= set_checkbox('is_unlimited_date', 1) ?>>
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
                        <input type="text" class="form-control float-right" id="date-voucher" name="date">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="kategori">Tipe Diskon</label>
                            <select name="tipe_diskon" id="tipe_diskon" class="form-control select2bs4" required onchange="pilihTipeDiskon()">
                                <option value="">Pilih Tipe</option>
                                <option value="pr" <?= set_select('tipe_diskon', 'pr') ?>>Persen</option>
                                <option value="rp" <?= set_select('tipe_diskon', 'rp') ?>>Rupiah</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="kategori">Total Diskon</label>
                            <input type="number" name="total_diskon" class="form-control" value="<?= (set_value('total_diskon') == '') ? 0 : set_value('total_diskon') ?>" min="0" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : 0">
                        </div>
                    </div>
                    <div class="col-md-5" id="total_diskon_max">
                        <div class="form-group">
                            <label for="kategori">Total Diskon Max</label>
                            <input type="number" name="total_diskon_max" class="form-control" value="<?= (set_value('total_diskon_max') == '') ? 0 : set_value('total_diskon_max') ?>" min="0" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : 0">
                        </div>
                    </div>
                </div>
                <div class="form-check" id="is_unlimited_qty">
                    <input class="form-check-input" name="is_unlimited_qty" type="checkbox" value="1" <?= set_checkbox('is_unlimited_qty', 1) ?>>
                    <label class="form-check-label"><i>Tidak Ada Batas Jumlah</i></label>
                </div>
                <div class="form-group">
                    <label for="kategori">Jumlah Voucher</label>
                    <input type="number" name="quantity" class="form-control" value="<?= (set_value('quantity') == '') ? 0 : set_value('quantity') ?>" min="0" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : 0">
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="is_combine" type="checkbox" value="1" <?= set_checkbox('is_combine', 1) ?>>
                    <label class="form-check-label"><i>Voucher dapat digabung dengan promo lain?</i></label>
                </div>
                <div class="form-group">
                    <label for="kategori">Template Voucher</label>
                    <select id="voucher_template_id" class="form-control select2bs4" name="voucher_template_id" style="width: 100%;" onchange="pilihTemplate()">
                        <option value="">Pilih Template</option>
                        <?php foreach ($v_template as $template) { ?>
                            <option value="<?= $template['id'] ?>" file="<?= $template['file_url'] ?>" <?= set_select('voucher_template_id', $template['id']) ?>><?= $template['nama_template'] ?></option>
                        <?php } ?>
                    </select>
                    <br>
                    <img src="#" alt="Preview Template" id="PrevTemp" height="200px"/>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-info">Tambah Voucher</button>
            </div>            
        </form>
    </div>
</section>
</div>

<script>
    $(function(){
        v_kategori = $("#voucher_kategori_id option:selected").val()
        if(v_kategori == 1){
            $("#kode_voucher").css({'display' : ''})
            $("#is_unlimited_qty").css({'display' : ''})
        }else{
            $("#kode_voucher").css({'display' : 'none'})
            $("#is_unlimited_qty").css({'display' : 'none'})
        }

        v_tipe = $("#tipe_diskon option:selected").val()
        if(v_tipe == 'pr'){
            $("#total_diskon_max").css({'display' : ''})
        }else{
            $("#total_diskon_max").css({'display' : 'none'})
        }
    });
    function pilihKategori()
    {
        value = $("#voucher_kategori_id option:selected").val()
        if(value == 1){
            $("#kode_voucher").css({'display' : ''})
            $("#is_unlimited_qty").css({'display' : ''})
        }else{
            $("#kode_voucher").css({'display' : 'none'})
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