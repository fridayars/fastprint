<section class="content">
    <?php if ($this->session->flashdata('berhasil')) { ?>
        <div class="alert alert-success" role="alert" style="margin-bottom: 30px">
            <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
            </button>
            <span class="glyphicon glyphicon-exclamation-sign"></span>
            <strong><?= $this->session->flashdata('berhasil'); ?></strong>
        </div>
    <?php } ?>
    <div class="row md-6">
        <div class="col md-6">
            <a href="<?= base_url() ?>Administrasi/Stok_apotek/list_apotek" type="button" class="btn btn-block btn-danger btn-lg">Data Obat/Alkes/Bahan</a>
        </div>
        <div class="col md-6">
            <a href="<?= base_url() ?>Terima_produk/form" type="button" class="btn btn-block btn-danger btn-lg" disabled>Pembelian Obat/Alkes/Bahan</a>
        </div>
    </div>
    <div class="row md-6" style="margin-top:30;">
        <div class="col md-6">
            <a href="<?= base_url() ?>Administrasi/Stok_apotek/kartu_stock_produk" type="button" class="btn btn-block btn-warning btn-lg">Kartu Stok</a>
        </div>
        <?php
        date_default_timezone_set('Asia/Jakarta');
        $tgl_akhir_bulan=date('t');
        // $tgl_akhir_bulan=4;
        $tgl_hari_ini=date('d');
        if($tgl_akhir_bulan == $tgl_hari_ini){ 
            if(@count(@$cek_so)>0){?>
                
            <?php }else{ ?>
                <div class="col md-6">
                    <a href="<?= base_url() ?>Administrasi/Stok_apotek/stock_opname" type="button" class="btn btn-block btn-success btn-lg">Stok Opname Sekarang!</a>
                </div>
        <?php }
        } ?>
    </div>
    <div class="row md-6" style="margin-top:30;">
        <div class="col md-6">
            <a href="<?= base_url() ?>Administrasi/Stok_apotek/stock_opname_produk" type="button" class="btn btn-block btn-primary btn-lg">Penerimaan Stok</a>
        </div>
         <div class="col md-6">
            <?php if($_SESSION['role_id']== 1){ ?>
                <a href="<?= base_url() ?>Administrasi/Stok_apotek/penyesuaian_stok" type="button" class="btn btn-block btn-success btn-lg">Penyesuaian Stok</a>
            <?php } else { ?>
                <a onclick="alert_apotek()" type="button" class="btn btn-block btn-success btn-lg">Penyesuaian Stok</a>
            <?php } ?>
        </div>
    </div>
</section>
</div>
<script type="text/javascript">
    function alert_apotek()
    {
        alert('Silahkan menghubungi SPV/Manager !!')
    }
</script>